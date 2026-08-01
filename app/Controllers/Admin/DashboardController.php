<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ComplaintModel;
use App\Models\AdminModel;
use App\Models\ActivityLogModel;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $complaintModel = new ComplaintModel();
        $adminModel = new AdminModel();
        $activityModel = new ActivityLogModel();

        // ========== 1. CORE METRICS ==========
        $total    = $complaintModel->countAll();
        $pending  = $complaintModel->where('status', 'Pending')->countAllResults();
        $resolved = $complaintModel->where('status', 'Resolved')->countAllResults();
        $delayed  = $complaintModel
            ->where('status', 'Pending')
            ->where('created_at <', date('Y-m-d H:i:s', strtotime('-48 hours')))
            ->countAllResults();

        // ========== 2. CRITICAL ALERTS ==========
        $unassigned = $complaintModel
            ->where('status !=', 'Resolved')
            ->where('assigned_to IS NULL')
            ->countAllResults();

        $olderThan24h = $complaintModel
            ->where('status !=', 'Resolved')
            ->where('created_at <', date('Y-m-d H:i:s', strtotime('-24 hours')))
            ->countAllResults();

        // ========== 3. RECENT COMPLAINTS ==========
        $recentComplaints = $complaintModel
            ->select('complaints.*, admins.name as assigned_admin_name')
            ->join('admins', 'admins.id = complaints.assigned_to', 'left')
            ->orderBy('complaints.created_at', 'DESC')
            ->limit(10)
            ->findAll() ?? [];

        // ========== 4. ASSIGNMENT OVERVIEW ==========
        $assignmentOverview = $adminModel
            ->select('admins.id, admins.name, COUNT(complaints.id) as complaint_count')
            ->join('complaints', 'complaints.assigned_to = admins.id', 'left')
            ->where('complaints.status !=', 'Resolved')
            ->groupBy('admins.id')
            ->orderBy('complaint_count', 'DESC')
            ->findAll() ?? [];

        // ========== 5. ANALYTICS ==========
        $weekStart   = date('Y-m-d H:i:s', strtotime('-7 days'));
        $monthStart  = date('Y-m-d H:i:s', strtotime('-30 days'));

        $complaintsThisWeek  = $complaintModel->where('created_at >=', $weekStart)->countAllResults();
        $complaintsThisMonth = $complaintModel->where('created_at >=', $monthStart)->countAllResults();
        $resolvedThisMonth   = $complaintModel
            ->where('status', 'Resolved')
            ->where('updated_at >=', $monthStart)
            ->countAllResults();

        $resolutionRate = ($complaintsThisMonth > 0)
            ? round(($resolvedThisMonth / $complaintsThisMonth) * 100, 1)
            : 0;

        // ========== 6. SLA MONITORING ==========
        $avgHours = $complaintModel
            ->select('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
            ->where('status', 'Resolved')
            ->where('updated_at IS NOT NULL')
            ->first();
        $avgResolution = round($avgHours['avg_hours'] ?? 0, 1);

        $resolvedWithin48h = $complaintModel
            ->where('status', 'Resolved')
            ->where('TIMESTAMPDIFF(HOUR, created_at, updated_at) <= 48', null, false)
            ->countAllResults();

        $totalResolved = $complaintModel->where('status', 'Resolved')->countAllResults();
        $slaCompliance = ($totalResolved > 0)
            ? round(($resolvedWithin48h / $totalResolved) * 100, 1)
            : 0;

        // ========== 7. ACTIVITY LOG ==========
        $activityLog = $activityModel
            ->select('activity_logs.*, admins.name as admin_name')
            ->join('admins', 'admins.id = activity_logs.admin_id', 'left')
            ->orderBy('activity_logs.created_at', 'DESC')
            ->limit(10)
            ->findAll() ?? [];

        // ========== 8. NOTIFICATIONS ==========
        $notifications = array_filter($activityLog, function ($log) {
            return stripos($log['action'], 'complaint') !== false || stripos($log['action'], 'login') !== false;
        });
        $notificationCount = count($notifications);

        // ========== 9. SECURITY INFO ==========
        $adminId = session()->get('admin_id');
        if (!$adminId) {
            return redirect()->to('/admin/login');
        }

        $currentAdmin = $adminModel->find($adminId);
        if (!$currentAdmin) {
            return redirect()->to('/admin/login');
        }

        $lastLogin      = $currentAdmin['last_login'] ?? 'Never';
        $failedAttempts = $currentAdmin['failed_attempts'] ?? 0;

        // Update last login (only once per session, but here it's fine)
        $adminModel->update($adminId, ['last_login' => date('Y-m-d H:i:s')]);

        // ========== 10. PASS TO VIEW ==========
        $data = [
            'total'              => $total,
            'pending'            => $pending,
            'resolved'           => $resolved,
            'delayed'            => $delayed,
            'unassigned'         => $unassigned ?? 0,
            'olderThan24h'       => $olderThan24h ?? 0,
            'recentComplaints'   => $recentComplaints,
            'assignmentOverview' => $assignmentOverview,
            'complaintsThisWeek' => $complaintsThisWeek,
            'complaintsThisMonth' => $complaintsThisMonth,
            'resolutionRate'     => $resolutionRate,
            'avgResolution'      => $avgResolution,
            'slaCompliance'      => $slaCompliance,
            'activityLog'        => $activityLog,
            'notificationCount'  => $notificationCount ?? 0,
            'lastLogin'          => $lastLogin,
            'failedAttempts'     => $failedAttempts,
        ];

        return view('admin/dashboard', $data);
    }
}
