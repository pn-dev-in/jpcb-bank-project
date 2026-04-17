<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ComplaintModel;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'totalComplaints' => (new ComplaintModel())->countAll(),

            'pendingComplaints' => (new ComplaintModel())
                ->where('status', 'Pending')
                ->countAllResults(),

            'resolvedComplaints' => (new ComplaintModel())
                ->where('status', 'Resolved')
                ->countAllResults(),

            // 🔥 NEW: DELAYED COMPLAINTS (48+ hours)
            'delayedComplaints' => (new ComplaintModel())
                ->where('status', 'Pending')
                ->where('created_at <', date('Y-m-d H:i:s', strtotime('-48 hours')))
                ->countAllResults(),

            'latestComplaints' => (new ComplaintModel())
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->findAll()
        ];

        return view('admin/dashboard', $data);
    }
}