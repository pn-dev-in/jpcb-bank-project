<?php

namespace App\Models;

use CodeIgniter\Model;

class SupportTicketModel extends Model
{
    protected $table = 'support_tickets';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'ticket_number', 'user_id', 'subject', 'priority',
        'status', 'description', 'last_reply_from'
    ];

    /**
     * Generate ticket number: TKT-YYYY-0001
     */
    public function generateTicketNumber(): string
    {
        $year = date('Y');
        $prefix = "TKT-{$year}-";
        
        $last = $this->like('ticket_number', $prefix, 'after')
                     ->orderBy('id', 'DESC')
                     ->first();
        
        if ($last) {
            $next = (int)substr($last['ticket_number'], -4) + 1;
        } else {
            $next = 1;
        }
        
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get ticket by ticket number
     */
    public function findByTicketNumber(string $ticketNumber)
    {
        return $this->where('ticket_number', $ticketNumber)->first();
    }

    /**
     * Get tickets with creator info
     */
    public function getTicketsWithCreator(int $userId = null)
    {
        $builder = $this->select('support_tickets.*, admins.name as creator_name')
                        ->join('admins', 'admins.id = support_tickets.user_id', 'left')
                        ->orderBy('support_tickets.id', 'DESC');
        
        if ($userId) {
            $builder->where('support_tickets.user_id', $userId);
        }
        
        return $builder->findAll();
    }
}