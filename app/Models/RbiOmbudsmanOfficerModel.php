<?php

namespace App\Models;

use CodeIgniter\Model;

class RbiOmbudsmanOfficerModel extends Model
{
    protected $table = 'rbi_ombudsman_officers';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title', 'officer_name', 'designation', 'office_address',
        'phone', 'fax', 'email', 'website',
        'sort_order', 'status'
    ];

    protected $useTimestamps = true;
}