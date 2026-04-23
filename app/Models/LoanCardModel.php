<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanCardModel extends Model
{
    protected $table = 'loan_cards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['icon', 'title', 'description', 'href', 'rate', 'sort_order', 'status'];
    protected $useTimestamps = true;
}