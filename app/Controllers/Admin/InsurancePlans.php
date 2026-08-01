<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InsurancePlanModel;

class InsurancePlans extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new InsurancePlanModel();
    }

    // List plans, optionally filtered by tab (default 'life')
    public function index($tab = 'life')
    {
        $data['items'] = $this->model
            ->where('tab', $tab)
            ->orderBy('category', 'asc')
            ->orderBy('sort_order', 'asc')
            ->findAll();

        $data['currentTab'] = $tab;
        return view('admin/insurance_plans/index', $data);
    }

    public function create()
    {
        return view('admin/insurance_plans/form');
    }

    public function store()
    {
        $rules = [
            'tab'        => 'required|max_length[50]',
            'category'   => 'permit_empty|max_length[100]',
            'plan_name'  => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'tab'         => $this->request->getPost('tab'),
            'category'    => $this->request->getPost('category') ?? '',
            'plan_name'   => $this->request->getPost('plan_name'),
            'description' => $this->request->getPost('description') ?? '',
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Created', 'insurance_plans', $this->model->getInsertID());

        return redirect()->to('/admin/insurance-plans/' . $this->request->getPost('tab'))
            ->with('message', 'Insurance plan added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/insurance-plans')->with('error', 'Not found.');
        }
        return view('admin/insurance_plans/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'tab'        => 'required|max_length[50]',
            'category'   => 'permit_empty|max_length[100]',
            'plan_name'  => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'tab'         => $this->request->getPost('tab'),
            'category'    => $this->request->getPost('category') ?? '',
            'plan_name'   => $this->request->getPost('plan_name'),
            'description' => $this->request->getPost('description') ?? '',
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Updated', 'insurance_plans', $id);

        return redirect()->to('/admin/insurance-plans/' . $this->request->getPost('tab'))
            ->with('message', 'Insurance plan updated.');
    }

    public function delete($id)
    {
        $plan = $this->model->find($id);
        $tab  = $plan['tab'] ?? 'life';

        $this->model->delete($id);
        log_activity('Deleted', 'insurance_plans', $id);

        return redirect()->to('/admin/insurance-plans/' . $tab)
            ->with('message', 'Insurance plan deleted.');
    }
}