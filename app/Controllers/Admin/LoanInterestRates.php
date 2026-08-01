<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanInterestRateModel;
use App\Models\ServiceSettingModel;

class LoanInterestRates extends BaseController
{
    protected $model;
    protected $settingsModel;

    public function __construct()
    {
        $this->model = new LoanInterestRateModel();
        $this->settingsModel = new ServiceSettingModel();
    }

    // ---------- Existing CRUD for rates (unchanged) ----------
    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/loan_interest_rates/index', $data);
    }

    public function create()
    {
        return view('admin/loan_interest_rates/form');
    }

    public function store()
    {
        $rules = [
            'product_name'      => 'required|max_length[150]',
            'rate'              => 'required|max_length[50]',
            'processing_fee'    => 'required|max_length[50]',
            'prepayment_charge' => 'required|max_length[50]',
            'sort_order'        => 'permit_empty|integer',
            'status'            => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'product_name'      => $this->request->getPost('product_name'),
            'rate'              => $this->request->getPost('rate'),
            'processing_fee'    => $this->request->getPost('processing_fee'),
            'prepayment_charge' => $this->request->getPost('prepayment_charge'),
            'sort_order'        => $this->request->getPost('sort_order') ?? 0,
            'status'            => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'loan-interest-rates', $id);
        return redirect()->to('/admin/loan-interest-rates')->with('message', 'Interest rate entry added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/loan-interest-rates')->with('error', 'Not found.');
        return view('admin/loan_interest_rates/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'product_name'      => 'required|max_length[150]',
            'rate'              => 'required|max_length[50]',
            'processing_fee'    => 'required|max_length[50]',
            'prepayment_charge' => 'required|max_length[50]',
            'sort_order'        => 'permit_empty|integer',
            'status'            => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'product_name'      => $this->request->getPost('product_name'),
            'rate'              => $this->request->getPost('rate'),
            'processing_fee'    => $this->request->getPost('processing_fee'),
            'prepayment_charge' => $this->request->getPost('prepayment_charge'),
            'sort_order'        => $this->request->getPost('sort_order') ?? 0,
            'status'            => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'loan-interest-rates', $id);
        return redirect()->to('/admin/loan-interest-rates')->with('message', 'Interest rate entry updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'loan-interest-rates', $id);
        return redirect()->to('/admin/loan-interest-rates')->with('message', 'Interest rate entry deleted.');
    }

    // ---------- NEW: Settings for the downloadable PDF ----------
    public function settings()
    {
        $row = $this->settingsModel->where('key', 'loan_rates_pdf')->first();
        $data['pdfPath'] = $row['value'] ?? '';
        return view('admin/loan_interest_rates/settings', $data);
    }

    public function updateSettings()
    {
        $file = $this->request->getFile('loan_rates_pdf');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/forms/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $pdfPath = 'uploads/forms/' . $newName;

            // Delete old file
            $old = $this->settingsModel->where('key', 'loan_rates_pdf')->first()['value'] ?? '';
            if ($old && file_exists(FCPATH . $old)) {
                @unlink(FCPATH . $old);
            }

            $existing = $this->settingsModel->where('key', 'loan_rates_pdf')->first();
            if ($existing) {
                $this->settingsModel->update($existing['id'], ['value' => $pdfPath]);
            } else {
                $this->settingsModel->insert(['key' => 'loan_rates_pdf', 'value' => $pdfPath]);
            }
        }

        log_activity('Updated', 'loan-interest-rates-settings', 0);
        return redirect()->to('/admin/loan-interest-rates/settings')->with('message', 'PDF updated.');
    }
}