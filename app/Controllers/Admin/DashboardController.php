<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ComplaintModel;
use App\Models\AdminModel;
use App\Models\ActivityLogModel;
use App\Models\ComplaintLogModel; // if you have one; otherwise use activity_logs for complaint updates

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
        $total = $complaintModel->countAll();
        $pending = $complaintModel->where('status', 'Pending')->countAllResults();
        $resolved = $complaintModel->where('status', 'Resolved')->countAllResults();
        $delayed = $complaintModel
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

        // ========== 3. RECENT COMPLAINTS TABLE (with assigned admin name) ==========
        $recentComplaints = $complaintModel
            ->select('complaints.*, admins.name as assigned_admin_name')
            ->join('admins', 'admins.id = complaints.assigned_to', 'left')
            ->orderBy('complaints.created_at', 'DESC')
            ->limit(10)
            ->findAll();

        // ========== 4. ASSIGNMENT OVERVIEW (complaints per admin) ==========
        $assignmentOverview = $adminModel
            ->select('admins.id, admins.name, COUNT(complaints.id) as complaint_count')
            ->join('complaints', 'complaints.assigned_to = admins.id', 'left')
            ->where('complaints.status !=', 'Resolved') // or count all? We'll count unresolved for workload
            ->groupBy('admins.id')
            ->orderBy('complaint_count', 'DESC')
            ->findAll();

        // ========== 5. ANALYTICS (weekly, monthly, resolution rate) ==========
        $now = date('Y-m-d H:i:s');
        $weekStart = date('Y-m-d H:i:s', strtotime('-7 days'));
        $monthStart = date('Y-m-d H:i:s', strtotime('-30 days'));

        $complaintsThisWeek = $complaintModel
            ->where('created_at >=', $weekStart)
            ->countAllResults();
        $complaintsThisMonth = $complaintModel
            ->where('created_at >=', $monthStart)
            ->countAllResults();
        $resolvedThisMonth = $complaintModel
            ->where('status', 'Resolved')
            ->where('updated_at >=', $monthStart)
            ->countAllResults();
        $resolutionRate = ($complaintsThisMonth > 0) ? round(($resolvedThisMonth / $complaintsThisMonth) * 100, 1) : 0;

        // ========== 6. SLA / TAT MONITORING ==========
        // Average resolution time (in hours) for resolved complaints
        $avgResolutionHours = $complaintModel
            ->select('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
            ->where('status', 'Resolved')
            ->where('updated_at IS NOT NULL')
            ->first();
        $avgResolution = round($avgResolutionHours['avg_hours'] ?? 0, 1);

        // SLA compliance: complaints resolved within 48 hours
        $resolvedWithin48h = $complaintModel
            ->where('status', 'Resolved')
            ->where('TIMESTAMPDIFF(HOUR, created_at, updated_at) <= 48', null, false)
            ->countAllResults();
        $totalResolved = $complaintModel->where('status', 'Resolved')->countAllResults();
        $slaCompliance = ($totalResolved > 0) ? round(($resolvedWithin48h / $totalResolved) * 100, 1) : 0;

        // ========== 7. ACTIVITY LOG (last 10 actions) ==========
        $activityLog = $activityModel
            ->select('activity_logs.*, admins.name as admin_name')
            ->join('admins', 'admins.id = activity_logs.admin_id', 'left')
            ->orderBy('activity_logs.created_at', 'DESC')
            ->limit(10)
            ->findAll();

        // ========== 8. QUICK ACTIONS (will be in view) ==========

        // ========== 9. NOTIFICATIONS (simulated – from activity log) ==========
        $notifications = array_filter($activityLog, function ($log) {
            return strpos($log['action'], 'complaint') !== false || $log['action'] === 'login';
        });
        $notificationCount = count($notifications);

        // ========== 10. SECURITY INFO (last login, failed attempts) ==========
        $adminId = session()->get('admin_id');
        if (!$adminId) {
            return redirect()->to('/admin/login');
        }

        $currentAdmin = $adminModel->find($adminId);
        if (!$currentAdmin) {
            return redirect()->to('/admin/login');
        }

        $lastLogin = $currentAdmin['last_login'] ?? 'Never';
        $failedAttempts = $currentAdmin['failed_attempts'] ?? 0;

        // Update last login time only if the admin exists
        $adminModel->update($adminId, ['last_login' => date('Y-m-d H:i:s')]);

        $data = [
            'total' => $total,
            'pending' => $pending,
            'resolved' => $resolved,
            'delayed' => $delayed,
            'unassigned' => $unassigned,
            'olderThan24h' => $olderThan24h,
            'recentComplaints' => $recentComplaints,
            'assignmentOverview' => $assignmentOverview,
            'complaintsThisWeek' => $complaintsThisWeek,
            'complaintsThisMonth' => $complaintsThisMonth,
            'resolutionRate' => $resolutionRate,
            'avgResolution' => $avgResolution,
            'slaCompliance' => $slaCompliance,
            'activityLog' => $activityLog,
            'notificationCount' => $notificationCount,
            'lastLogin' => $lastLogin,
            'failedAttempts' => $failedAttempts,
        ];

        return view('admin/dashboard', $data);
    }
}
