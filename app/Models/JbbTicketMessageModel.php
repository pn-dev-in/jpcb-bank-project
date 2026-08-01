<?php

namespace App\Models;

use CodeIgniter\Model;

class JbbTicketMessageModel extends Model
{
    protected $table = 'jbb_ticket_messages';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $allowedFields = ['ticket_id', 'sender_type', 'sender_name', 'message'];

    public function getConversation(int $ticketId): array
    {
        return $this->where('ticket_id', $ticketId)->orderBy('created_at', 'ASC')->findAll();
    }
}