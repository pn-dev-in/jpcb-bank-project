<?php

namespace App\Models;

use CodeIgniter\Model;

class JbbTicketModel extends Model
{
    protected $table = 'jbb_tickets';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'jpcb_ticket_number', 'subject', 'priority', 'status',
        'description', 'jpcb_contact_email', 'assigned_to'
    ];

    public function getAllTickets()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }

    public function findByJpcbNumber(string $ticketNumber)
    {
        return $this->where('jpcb_ticket_number', $ticketNumber)->first();
    }
}