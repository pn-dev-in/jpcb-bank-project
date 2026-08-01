<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailProcessingLogModel extends Model
{
    protected $table = 'email_processing_log';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null; // no updated_at

    protected $allowedFields = [
        'email_uid', 'ticket_number', 'action', 'processed'
    ];

    /**
     * Check if email UID already processed
     */
    public function isEmailProcessed(string $uid): bool
    {
        return $this->where('email_uid', $uid)->countAllResults() > 0;
    }

    /**
     * Mark email as processed
     */
    public function markProcessed(string $uid, string $ticketNumber, string $action): void
    {
        $this->insert([
            'email_uid'     => $uid,
            'ticket_number' => $ticketNumber,
            'action'        => $action,
            'processed'     => 1,
        ]);
    }
}