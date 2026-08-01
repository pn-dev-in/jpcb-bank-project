<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanSchemeModel;

class LoanSchemes extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new LoanSchemeModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/loan_schemes/index', $data);
    }

    public function create()
    {
        return view('admin/loan_schemes/form');
    }

    public function store()
    {
        $rules = [
            'name'               => 'required|max_length[255]',
            'max_loan_amount'    => 'permit_empty|max_length[100]',
            'max_tenure'         => 'permit_empty|max_length[255]',
            'repayment'          => 'permit_empty|max_length[255]',
            'margin'             => 'permit_empty|max_length[255]',
            'collateral_security'=> 'permit_empty',
            'purpose'            => 'required',
            'eligibility'        => 'required',
            'prime_security'     => 'required',
            'sort_order'         => 'permit_empty|integer',
            'status'             => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle PDF upload
        $formPdf = null;
        $file = $this->request->getFile('form_pdf');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/forms/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $formPdf = 'uploads/forms/' . $newName;
        }

        $id = $this->model->insert([
            'name'               => $this->request->getPost('name'),
            'max_loan_amount'    => $this->request->getPost('max_loan_amount'),
            'max_tenure'         => $this->request->getPost('max_tenure'),
            'repayment'          => $this->request->getPost('repayment'),
            'margin'             => $this->request->getPost('margin'),
            'collateral_security'=> $this->request->getPost('collateral_security'),
            'purpose'            => $this->request->getPost('purpose'),
            'eligibility'        => $this->request->getPost('eligibility'),
            'prime_security'     => $this->request->getPost('prime_security'),
            'form_pdf'           => $formPdf,                     // NEW
            'sort_order'         => $this->request->getPost('sort_order') ?? 0,
            'status'             => $this->request->getPost('status') ?? 1,
        ]);

        if ($id) {
            log_activity('Created', 'loan_schemes', $id);
            return redirect()->to('/admin/loan-schemes')->with('success', 'Loan scheme added.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/loan-schemes')->with('error', 'Not found.');
        return view('admin/loan_schemes/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'name'               => 'required|max_length[255]',
            'max_loan_amount'    => 'permit_empty|max_length[100]',
            'max_tenure'         => 'permit_empty|max_length[255]',
            'repayment'          => 'permit_empty|max_length[255]',
            'margin'             => 'permit_empty|max_length[255]',
            'collateral_security'=> 'permit_empty',
            'purpose'            => 'required',
            'eligibility'        => 'required',
            'prime_security'     => 'required',
            'sort_order'         => 'permit_empty|integer',
            'status'             => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);

        // Handle PDF upload
        $file = $this->request->getFile('form_pdf');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/forms/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['form_pdf'] = 'uploads/forms/' . $newName;

            // Delete old file
            $oldPath = $item['form_pdf'] ?? '';
            if ($oldPath && file_exists(FCPATH . $oldPath)) {
                @unlink(FCPATH . $oldPath);
            }
        } else {
            $data['form_pdf'] = $item['form_pdf'] ?? null;
        }

        $updated = $this->model->update($id, [
            'name'               => $this->request->getPost('name'),
            'max_loan_amount'    => $this->request->getPost('max_loan_amount'),
            'max_tenure'         => $this->request->getPost('max_tenure'),
            'repayment'          => $this->request->getPost('repayment'),
            'margin'             => $this->request->getPost('margin'),
            'collateral_security'=> $this->request->getPost('collateral_security'),
            'purpose'            => $this->request->getPost('purpose'),
            'eligibility'        => $this->request->getPost('eligibility'),
            'prime_security'     => $this->request->getPost('prime_security'),
            'form_pdf'           => $data['form_pdf'],           // NEW
            'sort_order'         => $this->request->getPost('sort_order') ?? 0,
            'status'             => $this->request->getPost('status') ?? 1,
        ]);

        if ($updated) {
            log_activity('Updated', 'loan_schemes', $id);
            return redirect()->to('/admin/loan-schemes')->with('success', 'Loan scheme updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update.');
        }
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['form_pdf']) && file_exists(FCPATH . $item['form_pdf'])) {
            @unlink(FCPATH . $item['form_pdf']);
        }

        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'loan_schemes', $id);
            return redirect()->to('/admin/loan-schemes')->with('success', 'Loan scheme deleted.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete.');
        }
    }
}