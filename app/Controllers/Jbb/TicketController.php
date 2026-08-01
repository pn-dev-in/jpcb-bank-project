<?php

namespace App\Controllers\Jbb;

use App\Controllers\BaseController;
use App\Models\JbbTicketModel;
use App\Models\JbbTicketMessageModel;
use App\Models\SupportTicketModel;
use App\Models\SupportTicketMessageModel;

class TicketController extends BaseController
{
    protected $ticketModel;
    protected $messageModel;

    public function __construct()
    {
        $this->ticketModel  = new JbbTicketModel();
        $this->messageModel = new JbbTicketMessageModel();
        helper('jbb_email');

        // Protect all methods
        if (!session('jbb_logged_in')) {
            header('Location: ' . base_url('jbb/login'));
            exit;
        }
    }

    /**
     * List all tickets
     */
    public function index()
    {
        $data['tickets'] = $this->ticketModel->orderBy('id', 'DESC')->findAll();
        return view('jbb/tickets/index', $data);
    }

    /**
     * Show ticket detail with conversation
     */
    public function show($id)
    {
        $ticket = $this->ticketModel->find($id);
        if (!$ticket) {
            return redirect()->to('/jbb/tickets')->with('error', 'Ticket not found.');
        }

        $data['ticket']   = $ticket;
        $data['messages'] = $this->messageModel->getConversation($id);
        return view('jbb/tickets/show', $data);
    }

    /**
     * Reply to ticket (SYNCS BOTH WAYS)
     */
    public function reply($id)
    {
        $ticket = $this->ticketModel->find($id);
        if (!$ticket || $ticket['status'] === 'closed') {
            return redirect()->back()->with('error', 'Cannot reply to closed ticket.');
        }

        $message = $this->request->getPost('message');
        if (empty($message)) {
            return redirect()->back()->with('error', 'Message required.');
        }

        $senderName = session('jbb_user_name');

        // ========== 1. SAVE IN JBB TABLE ==========
        $this->messageModel->insert([
            'ticket_id'   => $id,
            'sender_type' => 'jbb',
            'sender_name' => $senderName,
            'message'     => $message,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        // ========== 2. SYNC TO JPCB TABLE ==========
        $this->syncReplyToJpcb($ticket, $message, $senderName);

        // ========== 3. SEND EMAIL TO JPCB ==========
        jbbSendReplyEmail($ticket, $message, $senderName);

        return redirect()->to('/jbb/tickets/show/' . $id)->with('success', 'Reply sent and synced to JPCB.');
    }

    /**
     * Change ticket status (SYNCS BOTH WAYS)
     */
    public function changeStatus($id)
    {
        $ticket = $this->ticketModel->find($id);
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        $newStatus = $this->request->getPost('status');
        if (!in_array($newStatus, ['in_progress', 'resolved', 'closed'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $senderName = session('jbb_user_name');

        // ========== 1. UPDATE JBB TABLE ==========
        $this->ticketModel->update($id, ['status' => $newStatus]);

        // Add system message in JBB
        $this->messageModel->insert([
            'ticket_id'   => $id,
            'sender_type' => 'system',
            'sender_name' => 'System',
            'message'     => "Status changed to <strong>{$newStatus}</strong> by {$senderName}",
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        // ========== 2. SYNC TO JPCB TABLE ==========
        $this->syncStatusToJpcb($ticket, $newStatus, $senderName);

        // ========== 3. SEND EMAIL TO JPCB ==========
        jbbSendStatusEmail($ticket, $newStatus, $senderName);

        return redirect()->to('/jbb/tickets/show/' . $id)->with('success', "Status changed to {$newStatus}.");
    }

    /**
     * Sync JBB reply to JPCB database
     */
    private function syncReplyToJpcb(array $jbbTicket, string $message, string $senderName): void
    {
        $jpcbTicketModel = new SupportTicketModel();
        $jpcbMsgModel    = new SupportTicketMessageModel();

        $jpcbTicket = $jpcbTicketModel->findByTicketNumber($jbbTicket['jpcb_ticket_number']);

        if ($jpcbTicket) {
            // Insert message in JPCB table
            $jpcbMsgModel->insert([
                'ticket_id'   => $jpcbTicket['id'],
                'sender_type' => 'jbb',
                'sender_name' => $senderName . ' (JBB Support)',
                'message'     => $message,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            // Update JPCB ticket last_reply_from
            $jpcbTicketModel->update($jpcbTicket['id'], [
                'last_reply_from' => 'jbb',
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Sync JBB status change to JPCB database
     */
    private function syncStatusToJpcb(array $jbbTicket, string $newStatus, string $senderName): void
    {
        $jpcbTicketModel = new SupportTicketModel();
        $jpcbMsgModel    = new SupportTicketMessageModel();

        $jpcbTicket = $jpcbTicketModel->findByTicketNumber($jbbTicket['jpcb_ticket_number']);

        if ($jpcbTicket) {
            // Update status in JPCB table
            $jpcbTicketModel->update($jpcbTicket['id'], [
                'status'     => $newStatus,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            // Add system message in JPCB
            $jpcbMsgModel->insert([
                'ticket_id'   => $jpcbTicket['id'],
                'sender_type' => 'system',
                'sender_name' => 'System',
                'message'     => "Status changed to <strong>{$newStatus}</strong> by {$senderName} (JBB Support)",
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    }
}