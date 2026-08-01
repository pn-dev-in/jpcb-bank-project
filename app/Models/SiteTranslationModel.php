<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteTranslationModel extends Model
{
    protected $table = 'site_translations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'text_key',
        'source_text',
        'language',
        'translation',
        'context',
        'status',
        'sort_order',
    ];
    protected $useTimestamps = true;
}
