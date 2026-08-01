<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanInterestNoteModel extends Model
{
    protected $table = 'loan_interest_notes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'note', 'sort_order', 'status'
    ];
    protected $useTimestamps = true;
}