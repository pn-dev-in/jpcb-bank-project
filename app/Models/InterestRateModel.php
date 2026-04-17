<?php

namespace App\Models;

use CodeIgniter\Model;

class InterestRateModel extends Model
{
    protected $table = 'interest_rates';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'type',
        'title',
        'rate',
        'description'
    ];
}