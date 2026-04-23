<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RbiOmbudsmanReasonModel;

class RbiOmbudsmanReasons extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new RbiOmbudsmanReasonModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/rbi_ombudsman_reasons/index', $data);
    }

    public function create()
    {
        return view('admin/rbi_ombudsman_reasons/form');
    }

    public function store()
    {
        $rules = [
            'reason'     => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'reason'     => $this->request->getPost('reason'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-ombudsman-reasons')->with('message', 'Reason added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/rbi-ombudsman-reasons')->with('error', 'Not found.');
        return view('admin/rbi_ombudsman_reasons/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'reason'     => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'reason'     => $this->request->getPost('reason'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-ombudsman-reasons')->with('message', 'Reason updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/rbi-ombudsman-reasons')->with('message', 'Reason deleted.');
    }
}