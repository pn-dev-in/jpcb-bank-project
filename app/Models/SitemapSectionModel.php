<?php namespace App\Models; use CodeIgniter\Model;
class SitemapSectionModel extends Model {
    protected $table = 'sitemap_sections';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'sort_order', 'status'];
    protected $useTimestamps = true;
}