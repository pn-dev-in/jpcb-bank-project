<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ComplaintModel;

class ComplaintController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $model = new ComplaintModel();

        $status = $this->request->getGet('status');

        if ($status) {
            $data['complaints'] = $model->where('status', $status)->findAll();
        } else {
            $data['complaints'] = $model->findAll();
        }

        return view('admin/complaints/index', $data);
    }

    public function view($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $model = new ComplaintModel();
        $data['complaint'] = $model->find($id);

        return view('admin/complaints/view', $data);
    }

    // 🔥 CREATE / STORE COMPLAINT (AUTO TICKET GENERATION)
    public function store()
    {
        $model = new ComplaintModel();

        // Generate unique ticket number
        $ticket = 'JPCB-' . time();

        $model->save([
            'ticket_number' => $ticket,
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'message' => $this->request->getPost('message'),
            'status' => 'Pending'
        ]);

        return redirect()->back()->with('success', 'Complaint submitted successfully. Your Ticket ID: ' . $ticket);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $model = new ComplaintModel();
        $db = \Config\Database::connect();

        $status = $this->request->getPost('status');

        // Update main table
        $model->update($id, [
            'status' => $status,
            'assigned_to' => $this->request->getPost('assigned_to')
        ]);

        // Insert log
        $db->table('complaint_logs')->insert([
            'complaint_id' => $id,
            'status' => $status,
            'comment' => 'Status updated',
            'updated_by' => session()->get('admin_id'),
        ]);

        return redirect()->to('/admin/complaints');
    }
}
