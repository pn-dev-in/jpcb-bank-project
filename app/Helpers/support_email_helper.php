<?php

/**
 * Send email to JBB Technologies support team when JPCB creates a ticket
 */
function sendTicketToJBB(array $ticket, string $creatorName, string $creatorEmail): bool
{
    $email = \Config\Services::email();
    
    $jbbEmails = [
        env('jbb.supportEmail', 'ishan@jbbtechnologies.in'),
        env('jbb.supportEmail2', 'mdkurude@jbbtechnologies.in'),
    ];
    
    // Subject format: [JPCB] [TKT-2026-0001] [HIGH] Subject here
    $subject = sprintf(
        '[JPCB] [%s] [%s] %s',
        $ticket['ticket_number'],
        strtoupper($ticket['priority']),
        $ticket['subject']
    );
    
    $body = <<<HTML
    <!DOCTYPE html>
    <html>
    <head><meta charset="UTF-8"></head>
    <body style="font-family:Arial,sans-serif;line-height:1.6;">
        <div style="max-width:600px;margin:0 auto;padding:20px;">
            <h2 style="color:#198754;">📌 New Support Ticket from JPCB Bank</h2>
            
            <table style="width:100%;border-collapse:collapse;margin:15px 0;">
                <tr><td style="padding:8px;font-weight:bold;width:30%;">Ticket:</td><td>{$ticket['ticket_number']}</td></tr>
                <tr><td style="padding:8px;font-weight:bold;">Priority:</td><td>{$ticket['priority']}</td></tr>
                <tr><td style="padding:8px;font-weight:bold;">From:</td><td>{$creatorName} ({$creatorEmail})</td></tr>
                <tr><td style="padding:8px;font-weight:bold;">Subject:</td><td>{$ticket['subject']}</td></tr>
            </table>
            
            <div style="background:#f8f9fa;padding:15px;border-left:4px solid #198754;margin:15px 0;">
                <h4>Description:</h4>
                <p>{$ticket['description']}</p>
            </div>
            
            <p style="color:#6c757d;font-size:12px;">
                Reply to this email to update the ticket. Include <strong>[{$ticket['ticket_number']}]</strong> in subject.
            </p>
        </div>
    </body>
    </html>
    HTML;
    
    $email->setFrom(env('email.fromEmail', 'support@jpcbank.com'), 'JPCB Bank Support');
    $email->setTo($jbbEmails[0]);
    if (!empty($jbbEmails[1])) {
        $email->setCC($jbbEmails[1]);
    }
    $email->setSubject($subject);
    $email->setMessage($body);
    $email->setMailType('html');
    
    if (!$email->send()) {
        log_message('error', '[Support] Failed to send ticket email: ' . $email->printDebugger(['headers']));
        return false;
    }
    
    return true;
}

/**
 * Send auto-reply confirmation to JPCB employee who raised ticket
 */
function sendAutoReplyToJPCB(array $ticket, string $creatorEmail): bool
{
    $email = \Config\Services::email();
    
    $subject = "Re: [{$ticket['ticket_number']}] Thank you for contacting support";
    
    $body = <<<HTML
    <h2>✅ Ticket Received – {$ticket['ticket_number']}</h2>
    <p>Your support ticket has been received by JBB Technologies.</p>
    <p><strong>Subject:</strong> {$ticket['subject']}</p>
    <p><strong>Priority:</strong> {$ticket['priority']}</p>
    <p>We will review your issue and respond shortly.</p>
    <p>Track your ticket in <a href="{$_ENV['app.baseURL']}/admin/support-tickets">JPCB Admin Panel</a></p>
    HTML;
    
    $email->setFrom('noreply@jpcbank.com', 'JPCB Support System');
    $email->setTo($creatorEmail);
    $email->setSubject($subject);
    $email->setMessage($body);
    $email->setMailType('html');
    
    return $email->send();
}

/**
 * Notify JPCB when JBB replies via email
 */
function notifyJPCBOnReply(array $ticket, string $jpcbEmail): bool
{
    $email = \Config\Services::email();
    
    $subject = "[{$ticket['ticket_number']}] New reply from Support Team";
    $adminUrl = base_url('admin/support-tickets/show/' . $ticket['id']);
    
    $body = <<<HTML
    <h2>💬 New Reply on Ticket {$ticket['ticket_number']}</h2>
    <p>JBB Technologies has replied to your support ticket.</p>
    <a href="{$adminUrl}" style="background:#0d6efd;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;display:inline-block;">
        View in Admin Panel
    </a>
    HTML;
    
    $email->setFrom('noreply@jpcbank.com', 'JPCB Support System');
    $email->setTo($jpcbEmail);
    $email->setSubject($subject);
    $email->setMessage($body);
    $email->setMailType('html');
    
    return $email->send();
}

/**
 * Extract ticket number from email subject
 * Format: [TKT-2026-0001]
 */
function extractTicketNumber(string $subject): ?string
{
    if (preg_match('/\[(TKT-\d{4}-\d{4})\]/', $subject, $matches)) {
        return $matches[1];
    }
    return null;
}

/**
 * Determine action from email subject
 * Returns: 'reply', 'resolved', 'closed', or null
 */
function extractEmailAction(string $subject): ?string
{
    $subject = strtolower($subject);
    
    if (strpos($subject, '[resolved]') !== false) return 'resolved';
    if (strpos($subject, '[closed]') !== false) return 'closed';
    if (strpos($subject, '[in_progress]') !== false) return 'in_progress';
    
    return 'reply'; // default
}

/**
 * Sync newly created ticket to JBB portal tables
 * Runs after JPCB creates a ticket
 */
function syncTicketToJbbPortal(array $ticket, string $creatorName): bool
{
    try {
        $jbbTicketModel = new \App\Models\JbbTicketModel();
        $jbbMessageModel = new \App\Models\JbbTicketMessageModel();

        // Check if already synced
        $existing = $jbbTicketModel->findByJpcbNumber($ticket['ticket_number']);
        if ($existing) return true;

        // Insert into jbb_tickets
        $jbbTicketId = $jbbTicketModel->insert([
            'jpcb_ticket_number'  => $ticket['ticket_number'],
            'subject'             => $ticket['subject'],
            'priority'            => $ticket['priority'],
            'status'              => 'open',
            'description'         => $ticket['description'],
            'jpcb_contact_email'  => env('email.fromEmail', 'support@jpcbank.com'),
            'created_at'          => date('Y-m-d H:i:s'),
        ]);

        if ($jbbTicketId) {
            // Insert first message
            $jbbMessageModel->insert([
                'ticket_id'   => $jbbTicketId,
                'sender_type' => 'jpcb',
                'sender_name' => $creatorName . ' (JPCB Bank)',
                'message'     => $ticket['description'],
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        return true;
    } catch (\Exception $e) {
        log_message('error', '[Sync] Portal sync error: ' . $e->getMessage());
        return false;
    }
}