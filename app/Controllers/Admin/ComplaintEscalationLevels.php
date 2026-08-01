<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ComplaintEscalationLevelModel;

class ComplaintEscalationLevels extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ComplaintEscalationLevelModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
        return view('admin/complaint_escalation_levels/index', $data);
    }

    public function create()
    {
        return view('admin/complaint_escalation_levels/form');
    }

    public function store()
    {
        $rules = [
            'level'       => 'required|max_length[20]',
            'title'       => 'required|max_length[100]',
            'name'        => 'permit_empty|max_length[50]',
            'phone'       => 'permit_empty|max_length[50]',
            'email'       => 'permit_empty|max_length[150]',
            'timeline'    => 'permit_empty|max_length[100]',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'level'       => $this->request->getPost('level'),
            'title'       => $this->request->getPost('title'),
            'name'        => $this->request->getPost('name'),
            'phone'       => $this->request->getPost('phone'),
            'email'       => $this->request->getPost('email'),
            'timeline'    => $this->request->getPost('timeline'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'complaint_escalation_levels', $id);
        return redirect()->to('/admin/complaint-escalation-levels')->with('message', 'Escalation level added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/complaint-escalation-levels')->with('error', 'Not found.');
        return view('admin/complaint_escalation_levels/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'level'       => 'required|max_length[20]',
            'title'       => 'required|max_length[100]',
            'name'        => 'permit_empty|max_length[50]',
            'phone'       => 'permit_empty|max_length[50]',
            'email'       => 'permit_empty|max_length[150]',
            'timeline'    => 'permit_empty|max_length[100]',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'level'       => $this->request->getPost('level'),
            'title'       => $this->request->getPost('title'),
            'name'        => $this->request->getPost('name'),
            'phone'       => $this->request->getPost('phone'),
            'email'       => $this->request->getPost('email'),
            'timeline'    => $this->request->getPost('timeline'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'complaint_escalation_levels', $id);
        return redirect()->to('/admin/complaint-escalation-levels')->with('message', 'Escalation level updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'complaint_escalation_levels', $id);
        return redirect()->to('/admin/complaint-escalation-levels')->with('message', 'Escalation level deleted.');
    }
}