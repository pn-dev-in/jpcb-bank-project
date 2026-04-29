<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeAlertBannerModel extends Model
{
    protected $table = 'home_alert_banner';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'image',
        'title',
        'description',
        'status',
        'is_popup'
    ];

    protected $useTimestamps = true;
}