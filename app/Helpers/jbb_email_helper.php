<?php

/**
 * Send reply email from JBB to JPCB
 */
function jbbSendReplyEmail(array $ticket, string $message, string $senderName): bool
{
    $email = \Config\Services::email();
    $jpcbContact = $ticket['jpcb_contact_email'] ?? null;

    if (empty($jpcbContact)) return false;

    $subject = "[{$ticket['jpcb_ticket_number']}] New reply from JBB Support";

    $body = <<<HTML
    <h2>💬 New Reply on Ticket {$ticket['jpcb_ticket_number']}</h2>
    <p><strong>From:</strong> {$senderName} (JBB Technologies)</p>
    <hr>
    <p>{$message}</p>
    <hr>
    <p style="color:#6c757d;font-size:12px;">
        JBB Technologies Support Team
    </p>
    HTML;

    $email->setFrom('support@jbbtechnologies.in', 'JBB Technologies Support');
    $email->setTo($jpcbContact);
    $email->setSubject($subject);
    $email->setMessage($body);
    $email->setMailType('html');

    return $email->send();
}

/**
 * Send status change email from JBB to JPCB
 */
function jbbSendStatusEmail(array $ticket, string $newStatus, string $senderName): bool
{
    $email = \Config\Services::email();
    $jpcbContact = $ticket['jpcb_contact_email'] ?? null;

    if (empty($jpcbContact)) return false;

    $subject = "[{$ticket['jpcb_ticket_number']}] [$newStatus] Ticket status updated";

    $body = <<<HTML
    <h2>📌 Ticket {$ticket['jpcb_ticket_number']} Status: {$newStatus}</h2>
    <p>Status changed by: {$senderName} (JBB Technologies)</p>
    HTML;

    $email->setFrom('support@jbbtechnologies.in', 'JBB Technologies Support');
    $email->setTo($jpcbContact);
    $email->setSubject($subject);
    $email->setMessage($body);
    $email->setMailType('html');

    return $email->send();
}