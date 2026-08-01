<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MobileBankingEligibilityModel;

class MobileBankingEligibility extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MobileBankingEligibilityModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/mobile_banking_eligibility/index', $data);
    }

    public function create()
    {
        return view('admin/mobile_banking_eligibility/form');
    }

    public function store()
    {
        $rules = [
            'account_type'      => 'required|max_length[100]',
            'constitution'      => 'required|max_length[100]',
            'mode_of_operation' => 'required|max_length[100]',
            'eligible'          => 'permit_empty|integer',
            'sort_order'        => 'permit_empty|integer',
            'status'            => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $id = $this->model->insert([
            'account_type'      => $this->request->getPost('account_type'),
            'constitution'      => $this->request->getPost('constitution'),
            'mode_of_operation' => $this->request->getPost('mode_of_operation'),
            'eligible'          => $this->request->getPost('eligible') ?? 0,
            'sort_order'        => $this->request->getPost('sort_order') ?? 0,
            'status'            => $this->request->getPost('status') ?? 1,
        ]);
        if ($id) {
            log_activity('Created', 'mobile_banking_eligibility', $id);
            return redirect()->to('/admin/mobile-banking-eligibility')->with('success', 'Eligibility entry added.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/mobile-banking-eligibility')->with('error', 'Not found.');
        return view('admin/mobile_banking_eligibility/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'account_type'      => 'required|max_length[100]',
            'constitution'      => 'required|max_length[100]',
            'mode_of_operation' => 'required|max_length[100]',
            'eligible'          => 'permit_empty|integer',
            'sort_order'        => 'permit_empty|integer',
            'status'            => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $updated = $this->model->update($id, [
            'account_type'      => $this->request->getPost('account_type'),
            'constitution'      => $this->request->getPost('constitution'),
            'mode_of_operation' => $this->request->getPost('mode_of_operation'),
            'eligible'          => $this->request->getPost('eligible') ?? 0,
            'sort_order'        => $this->request->getPost('sort_order') ?? 0,
            'status'            => $this->request->getPost('status') ?? 1,
        ]);
        if ($updated) {
            log_activity('Updated', 'mobile_banking_eligibility', $id);
            return redirect()->to('/admin/mobile-banking-eligibility')->with('success', 'Eligibility entry updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update.');
        }
    }

    public function delete($id)
    {
        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'mobile_banking_eligibility', $id);
            return redirect()->to('/admin/mobile-banking-eligibility')->with('success', 'Entry deleted.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete.');
        }
    }
}