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

         $rules = [
            'name'    => 'required|max_length[150]',
            'email'   => 'required|valid_email|max_length[150]',
            'phone'   => 'required|max_length[20]',
            'message' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

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
        $id = $model->getInsertID();
        log_activity('Created', 'complaints', $id);
        return redirect()->back()->with('success', 'Complaint submitted successfully. Your Ticket ID: ' . $ticket);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $model = new ComplaintModel();
        $db = \Config\Database::connect();

        // Check if complaint exists
        $complaint = $model->find($id);
        if (!$complaint) {
            return redirect()->to('/admin/complaints')->with('error', 'Complaint not found.');
        }

        $status = $this->request->getPost('status');
        $assignedTo = $this->request->getPost('assigned_to');


        // Update main table
        $model->update($id, [
            'status' => $status,
            'assigned_to' => $this->request->getPost('assigned_to')
        ]);
        
        log_activity('Updated', 'complaints', $id);
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
