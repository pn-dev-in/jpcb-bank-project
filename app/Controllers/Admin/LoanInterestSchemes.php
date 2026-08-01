<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanInterestSchemeModel;

class LoanInterestSchemes extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new LoanInterestSchemeModel();
    }

    public function index()
    {
        $data['retail'] = $this->model->where('category', 'retail')->orderBy('serial_no', 'asc')->findAll();
        $data['wholesale'] = $this->model->where('category', 'wholesale')->orderBy('serial_no', 'asc')->findAll();
        return view('admin/loan_interest_schemes/index', $data);
    }

    public function create()
    {
        return view('admin/loan_interest_schemes/form');
    }

    public function store()
    {
        $rules = [
            'category'      => 'required|in_list[retail,wholesale]',
            'serial_no'     => 'required|integer',
            'scheme_name'   => 'required|max_length[255]',
            'min_roi'       => 'permit_empty',
            'max_roi'       => 'permit_empty',
            'women_benefit' => 'permit_empty|max_length[100]',
            'sort_order'    => 'permit_empty|integer',
            'status'        => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'category'      => $this->request->getPost('category'),
            'serial_no'     => $this->request->getPost('serial_no'),
            'scheme_name'   => $this->request->getPost('scheme_name'),
            'min_roi'       => $this->request->getPost('min_roi'),
            'max_roi'       => $this->request->getPost('max_roi'),
            'women_benefit' => $this->request->getPost('women_benefit'),
            'sort_order'    => $this->request->getPost('sort_order') ?? 0,
            'status'        => $this->request->getPost('status') ?? 1,
        ]);
        if ($id) {
            log_activity('Created', 'loan_interest_schemes', $id);
            return redirect()->to('/admin/loan-interest-schemes')->with('success', 'Scheme added.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/loan-interest-schemes')->with('error', 'Scheme not found.');
        return view('admin/loan_interest_schemes/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'category'      => 'required|in_list[retail,wholesale]',
            'serial_no'     => 'required|integer',
            'scheme_name'   => 'required|max_length[255]',
            'min_roi'       => 'permit_empty',
            'max_roi'       => 'permit_empty',
            'women_benefit' => 'permit_empty|max_length[100]',
            'sort_order'    => 'permit_empty|integer',
            'status'        => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updated = $this->model->update($id, [
            'category'      => $this->request->getPost('category'),
            'serial_no'     => $this->request->getPost('serial_no'),
            'scheme_name'   => $this->request->getPost('scheme_name'),
            'min_roi'       => $this->request->getPost('min_roi'),
            'max_roi'       => $this->request->getPost('max_roi'),
            'women_benefit' => $this->request->getPost('women_benefit'),
            'sort_order'    => $this->request->getPost('sort_order') ?? 0,
            'status'        => $this->request->getPost('status') ?? 1,
        ]);
        if ($updated) {
            log_activity('Updated', 'loan_interest_schemes', $id);
            return redirect()->to('/admin/loan-interest-schemes')->with('success', 'Scheme updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update.');
        }
    }

    // Toggle status (active/inactive) – this does NOT delete
    public function toggleStatus($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->back()->with('error', 'Scheme not found.');
        }
        $newStatus = $item['status'] ? 0 : 1;
        $this->model->update($id, ['status' => $newStatus]);
        log_activity('Toggled Status', 'loan_interest_schemes', $id);
        return redirect()->to('/admin/loan-interest-schemes')->with('success', 'Scheme status updated.');
    }

    // Physical delete (use with caution)
    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'loan_interest_schemes', $id);
        return redirect()->to('/admin/loan-interest-schemes')->with('success', 'Scheme deleted.');
    }
}