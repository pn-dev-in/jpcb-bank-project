<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
    'site_name', 'phone', 'email', 'address', 
    'business_hours', 'digital_banking_link', 'locate_branch_link',
    'block_card_link', 'lodge_complaint_link', 'digital_banking_button_text',
    'footer_address', 'copyright_text', 'rbi_guidelines_text', 
    'rbi_guidelines_link', 'bank_type_text', 'facebook_url', 
    'twitter_url', 'linkedin_url', 'youtube_url'
];
}