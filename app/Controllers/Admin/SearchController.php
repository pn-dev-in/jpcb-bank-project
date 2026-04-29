<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\AdminPages;

class SearchController extends BaseController
{
    public function index()
    {
        $query = trim($this->request->getGet('q'));
        if (!$query) {
            return redirect()->to('/admin/dashboard')->with('error', 'Please enter a search term.');
        }

        $results = [];
        $pageResults = [];

        // 1. Search admin pages (from config)
        foreach (AdminPages::$pages as $label => $url) {
            if (stripos($label, $query) !== false) {
                $pageResults[] = [
                    'label' => $label,
                    'url' => base_url($url),
                    'type' => 'page'
                ];
            }
        }

        // Optional: Also search data records (products, notices, etc.)
        // But keep them separate to avoid clutter
        $dataResults = $this->searchDataRecords($query);

        return view('admin/search/results', [
            'query' => $query,
            'pageResults' => $pageResults,
            'dataResults' => $dataResults
        ]);
    }

    private function searchDataRecords(string $query): array
    {
        $results = [];

        // Products
        $productModel = new \App\Models\ProductModel();
        $products = $productModel->like('name', $query)->findAll(10);
        if ($products) {
            $results['products'] = $products;
        }

        // Notices
        $noticeModel = new \App\Models\NoticeModel();
        $notices = $noticeModel->like('title', $query)->findAll(10);
        if ($notices) {
            $results['notices'] = $notices;
        }

        // Branches
        $branchModel = new \App\Models\BranchModel();
        $branches = $branchModel->like('branch_name', $query)->orLike('city', $query)->findAll(10);
        if ($branches) {
            $results['branches'] = $branches;
        }

        // Add other models as needed...

        return $results;
    }
}