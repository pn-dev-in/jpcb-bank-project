<?php

namespace App\Models;

use CodeIgniter\Model;

class SupportTicketMessageModel extends Model
{
    protected $table = 'support_ticket_messages';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';

    protected $allowedFields = [
        'ticket_id', 'sender_type', 'sender_name', 'message'
    ];

    /**
     * Get all messages for a ticket
     */
    public function getConversation(int $ticketId): array
    {
        return $this->where('ticket_id', $ticketId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}