<?php

namespace App\Models;

use CodeIgniter\Model;

class PopupModel extends Model
{
    protected $table = 'popups';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'message',
        'image',
        'button_text',
        'button_link',
        'status'
    ];
}