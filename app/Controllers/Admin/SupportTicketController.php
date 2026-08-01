<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SupportTicketModel;
use App\Models\SupportTicketMessageModel;
use App\Models\AdminModel;

class SupportTicketController extends BaseController
{
    protected $ticketModel;
    protected $messageModel;
    protected $adminModel;

    public function __construct()
    {
        $this->ticketModel = new SupportTicketModel();
        $this->messageModel = new SupportTicketMessageModel();
        $this->adminModel = new AdminModel();
        helper('support_email');
    }

    /**
     * List all tickets
     * Super Admin (role 1) sees all, others see only their own
     */
    public function index()
    {
        $userId = session('admin_id');
        $roleId = session('role_id');
        $isSuperAdmin = ($roleId == 1);

        $data['tickets'] = $this->ticketModel->getTicketsWithCreator(
            $isSuperAdmin ? null : $userId
        );

        return view('admin/support_tickets/index', $data);
    }

    /**
     * Create ticket form
     */
    public function create()
    {
        return view('admin/support_tickets/create');
    }

    /**
     * Store new ticket + send emails
     */
    public function store()
    {
        $rules = [
            'subject' => 'required|max_length[255]',
            'priority' => 'required|in_list[low,medium,high,critical]',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = session('admin_id');
        $creator = $this->adminModel->find($userId);
        $creatorName = $creator['name'] ?? 'JPCB Employee';
        $creatorEmail = $creator['support_email'] ?? $creator['email'] ?? '';

        // Generate ticket number & save
        $ticketNumber = $this->ticketModel->generateTicketNumber();

        $ticketId = $this->ticketModel->insert([
            'ticket_number' => $ticketNumber,
            'user_id' => $userId,
            'subject' => $this->request->getPost('subject'),
            'priority' => $this->request->getPost('priority'),
            'description' => $this->request->getPost('description'),
            'last_reply_from' => 'jpcb',
        ]);

        // Save first message
        $this->messageModel->insert([
            'ticket_id' => $ticketId,
            'sender_type' => 'jpcb',
            'sender_name' => $creatorName,
            'message' => $this->request->getPost('description'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Send emails
        $ticket = $this->ticketModel->find($ticketId);

        try {
            sendTicketToJBB($ticket, $creatorName, $creatorEmail);

            if (!empty($creatorEmail)) {
                sendAutoReplyToJPCB($ticket, $creatorEmail);
            }

            // ✅ SYNC TO JBB PORTAL
            syncTicketToJbbPortal($ticket, $creatorName);

        } catch (\Exception $e) {
            log_message('error', '[Support] Email error: ' . $e->getMessage());
        }

        log_activity('Created', 'support_tickets', $ticketId);

        return redirect()->to('/admin/support-tickets')
            ->with('success', "Ticket <strong>#{$ticketNumber}</strong> created. JBB Technologies notified.");
    }

    /**
     * Show ticket detail with conversation
     */
    public function show($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            return redirect()->to('/admin/support-tickets')->with('error', 'Ticket not found.');
        }

        // Restrict access: only Super Admin or ticket creator can view
        $userId = session('admin_id');
        if (session('role_id') != 1 && $ticket['user_id'] != $userId) {
            return redirect()->to('/admin/support-tickets')->with('error', 'Access denied.');
        }

        $data['ticket'] = $ticket;
        $data['messages'] = $this->messageModel->getConversation($id);
        $data['creator'] = $this->adminModel->find($ticket['user_id']);

        return view('admin/support_tickets/show', $data);
    }

    /**
     * JPCB replies to ticket
     */
    public function reply($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket || $ticket['status'] === 'closed') {
            return redirect()->back()->with('error', 'Cannot reply to closed ticket.');
        }

        $rules = ['message' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->adminModel->find(session('admin_id'));
        $message = $this->request->getPost('message');
        $senderName = $user['name'] ?? 'JPCB Employee';

        // Save message in JPCB table
        $this->messageModel->insert([
            'ticket_id' => $id,
            'sender_type' => 'jpcb',
            'sender_name' => $senderName,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Update ticket
        $this->ticketModel->update($id, [
            'last_reply_from' => 'jpcb',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Sync to JBB portal
        $this->syncReplyToJbb($ticket, $message, $senderName);

        // Send email to JBB
        try {
            $this->sendReplyEmailToJBB($ticket, $message, $user);
        } catch (\Exception $e) {
            log_message('error', '[Support] Reply email error: ' . $e->getMessage());
        }

        log_activity('Replied', 'support_tickets', $id);

        return redirect()->to('/admin/support-tickets/show/' . $id)
            ->with('success', 'Reply sent.');
    }

    /**
 * Sync JPCB reply to JBB database
 */
private function syncReplyToJbb(array $jpcbTicket, string $message, string $senderName): void
{
    try {
        $jbbTicketModel = new \App\Models\JbbTicketModel();
        $jbbTicket = $jbbTicketModel->findByJpcbNumber($jpcbTicket['ticket_number']);

        if (!$jbbTicket) {
            // Ticket not in JBB yet - create it first
            $jbbTicketId = $jbbTicketModel->insert([
                'jpcb_ticket_number' => $jpcbTicket['ticket_number'],
                'subject'            => $jpcbTicket['subject'],
                'priority'           => $jpcbTicket['priority'],
                'status'             => $jpcbTicket['status'],
                'description'        => $jpcbTicket['description'],
                'created_at'         => date('Y-m-d H:i:s'),
            ]);
            $jbbTicket = $jbbTicketModel->find($jbbTicketId);
        }

        if ($jbbTicket && !empty($jbbTicket['id'])) {
            $jbbMsgModel = new \App\Models\JbbTicketMessageModel();
            $jbbMsgModel->insert([
                'ticket_id'   => $jbbTicket['id'],
                'sender_type' => 'jpcb',
                'sender_name' => $senderName . ' (JPCB Bank)',
                'message'     => $message,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    } catch (\Exception $e) {
        log_message('error', '[Sync] Reply sync error: ' . $e->getMessage());
    }
}

    /**
 * Sync JPCB status change to JBB database
 */
private function syncStatusToJbb(array $jpcbTicket, string $newStatus, string $senderName): void
{
    try {
        $jbbTicketModel = new \App\Models\JbbTicketModel();
        $jbbTicket = $jbbTicketModel->findByJpcbNumber($jpcbTicket['ticket_number']);

        if (!$jbbTicket) {
            // Create ticket in JBB first
            $jbbTicketId = $jbbTicketModel->insert([
                'jpcb_ticket_number' => $jpcbTicket['ticket_number'],
                'subject'            => $jpcbTicket['subject'],
                'priority'           => $jpcbTicket['priority'],
                'status'             => $newStatus,
                'description'        => $jpcbTicket['description'],
                'created_at'         => date('Y-m-d H:i:s'),
            ]);
            $jbbTicket = $jbbTicketModel->find($jbbTicketId);
        }

        if ($jbbTicket && !empty($jbbTicket['id'])) {
            // Update status
            $jbbTicketModel->update($jbbTicket['id'], [
                'status'     => $newStatus,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            // Add system message
            $jbbMsgModel = new \App\Models\JbbTicketMessageModel();
            $jbbMsgModel->insert([
                'ticket_id'   => $jbbTicket['id'],
                'sender_type' => 'system',
                'sender_name' => 'System',
                'message'     => "Status changed to {$newStatus} by {$senderName} (JPCB Bank)",
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    } catch (\Exception $e) {
        log_message('error', '[Sync] Status sync error: ' . $e->getMessage());
    }
}

    /**
     * JPCB changes ticket status
     */
    public function changeStatus($id)
    {
        $ticket = $this->ticketModel->find($id);
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        $newStatus = $this->request->getPost('status');
        if (!in_array($newStatus, ['resolved', 'closed'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $this->ticketModel->update($id, ['status' => $newStatus]);

        // Add system message
        $user = $this->adminModel->find(session('admin_id'));
        $senderName = $user['name'] ?? 'JPCB Employee';

        $this->messageModel->insert([
            'ticket_id' => $id,
            'sender_type' => 'system',
            'sender_name' => 'System',
            'message' => "Ticket marked as <strong>{$newStatus}</strong> by {$senderName}",
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // ✅ Sync to JBB
        $ticket = $this->ticketModel->find($id);
        $this->syncStatusToJbb($ticket, $newStatus, $senderName);

        // Send email
        try {
            $this->sendStatusEmailToJBB($ticket, $newStatus, $user);
        } catch (\Exception $e) {
            log_message('error', '[Support] Status email error: ' . $e->getMessage());
        }

        log_activity('Status Changed', 'support_tickets', $id);

        return redirect()->to('/admin/support-tickets')
            ->with('success', "Ticket #{$ticket['ticket_number']} marked as {$newStatus}.");
    }

    /**
     * Send reply email to JBB
     */
    private function sendReplyEmailToJBB($ticket, $message, $user)
    {
        $email = \Config\Services::email();

        $subject = "Re: [JPCB] [{$ticket['ticket_number']}] {$ticket['subject']}";

        $body = <<<HTML
        <p><strong>New reply from JPCB Bank</strong></p>
        <p><strong>From:</strong> {$user['name']}</p>
        <p><strong>Ticket:</strong> {$ticket['ticket_number']}</p>
        <hr>
        <p>{$message}</p>
        <hr>
        <p style="color:#6c757d;font-size:12px;">
            Reply to update ticket. Include <strong>[{$ticket['ticket_number']}]</strong> in subject.
        </p>
        HTML;

        $email->setTo(env('jbb.supportEmail', 'ishan@jbbtechnologies.in'));
        $email->setSubject($subject);
        $email->setMessage($body);
        $email->setMailType('html');
        $email->send();
    }

    /**
     * Send status change email to JBB
     */
    private function sendStatusEmailToJBB($ticket, $newStatus, $user)
    {
        $email = \Config\Services::email();

        $subject = "[{$ticket['ticket_number']}] Status: {$newStatus}";

        $body = <<<HTML
        <p><strong>Ticket {$ticket['ticket_number']}</strong> status changed to <strong>{$newStatus}</strong></p>
        <p>Changed by: {$user['name']}</p>
        HTML;

        $email->setTo(env('jbb.supportEmail', 'ishan@jbbtechnologies.in'));
        $email->setSubject($subject);
        $email->setMessage($body);
        $email->setMailType('html');
        $email->send();
    }
}