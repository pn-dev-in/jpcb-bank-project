<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DeafDepositModel;

class DeafSearch extends BaseController
{
    public function index()
    {
        $name = trim($this->request->getGet('name') ?? '');
        $address = trim($this->request->getGet('address') ?? '');
        
        // Validate: at least name OR address should have minimum 4 characters
        if (strlen($name) < 4 && strlen($address) < 4) {
            return redirect()->to('/deposits/deaf')->with('error', 'Please enter at least 4 characters in Name OR Address to search.');
        }
        
        $deafModel = new DeafDepositModel();
        
        // Build the search query
        $builder = $deafModel->where('status', 1);
        
        // Search by name (partial match)
        if (!empty($name)) {
            $builder->groupStart()
                    ->like('name', $name)
                    ->orLike('name', strtoupper($name))
                    ->orLike('name', strtolower($name))
                    ->groupEnd();
        }
        
        // Search by address (partial match)
        if (!empty($address)) {
            $builder->groupStart()
                    ->like('address', $address)
                    ->orLike('address', strtoupper($address))
                    ->orLike('address', strtolower($address))
                    ->groupEnd();
        }
        
        // Get results ordered by sr_no
        $results = $builder->orderBy('sr_no', 'asc')->findAll();
        
        // Store search params and results in session flashdata
        session()->setFlashdata('search_name', $name);
        session()->setFlashdata('search_address', $address);
        session()->setFlashdata('search_performed', true);
        session()->setFlashdata('search_results', $results);
        session()->setFlashdata('search_count', count($results));
        
        if (count($results) == 0) {
            session()->setFlashdata('info', 'No matching unclaimed deposits found. Please try with different keywords or contact your branch for assistance.');
        } else {
            session()->setFlashdata('success', 'Found ' . count($results) . ' matching record(s).');
        }
        
        return redirect()->to('/deposits/deaf');
    }
}