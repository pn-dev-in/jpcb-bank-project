<?php

namespace App\Models;

use CodeIgniter\Model;

class ComplaintEscalationLevelModel extends Model
{
    protected $table = 'complaint_escalation_levels';
    protected $primaryKey = 'id';
    protected $allowedFields = ['level', 'title', 'name', 'phone', 'email', 'timeline', 'description', 'sort_order', 'status'];
    protected $useTimestamps = true;
}