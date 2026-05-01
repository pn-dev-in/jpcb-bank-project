<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TrustStatModel;

class TrustStats extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TrustStatModel();
    }

    public function index()
    {
        $stats = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/trust_stats/index', ['stats' => $stats]);
    }

    public function create()
    {
        return view('admin/trust_stats/form');
    }

    public function store()
    {
        $rules = [
            'icon' => 'required|max_length[50]',
            'value' => 'required|max_length[50]',
            'label' => 'required|max_length[100]',
            'link' => 'permit_empty|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->model->save([
            'icon' => $this->request->getPost('icon'),
            'value' => $this->request->getPost('value'),
            'label' => $this->request->getPost('label'),
            'link' => $this->request->getPost('link'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created','trust-stats', $id);
        return redirect()->to('/admin/trust-stats')->with('message', 'Stat added.');
    }

    public function edit($id)
    {
        $stat = $this->model->find($id);
        if (!$stat) return redirect()->to('/admin/trust-stats')->with('error', 'Not found');
        return view('admin/trust_stats/form', ['stat' => $stat]);
    }

    public function update($id)
    {
        $rules = [
            'icon' => 'required|max_length[50]',
            'value' => 'required|max_length[50]',
            'label' => 'required|max_length[100]',
            'link' => 'permit_empty|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->model->update($id, [
            'icon' => $this->request->getPost('icon'),
            'value' => $this->request->getPost('value'),
            'label' => $this->request->getPost('label'),
            'link' => $this->request->getPost('link'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1
        ]);
        log_activity('Updated','trust-stats', $id);
        return redirect()->to('/admin/trust-stats')->with('message', 'Stat updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted','trust-stats', $id);
        return redirect()->to('/admin/trust-stats')->with('message', 'Stat deleted.');
    }
}