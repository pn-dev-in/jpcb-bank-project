<?php namespace App\Models; use CodeIgniter\Model;
class SitemapLinkModel extends Model {
    protected $table = 'sitemap_links';
    protected $primaryKey = 'id';
    protected $allowedFields = ['section_id', 'label', 'href', 'sort_order', 'status'];
    protected $useTimestamps = true;
}