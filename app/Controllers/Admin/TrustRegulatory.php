<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TrustRegulatoryModel;

class TrustRegulatory extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TrustRegulatoryModel();
    }

    public function edit()
    {
        $data = $this->model->find(1);
        if (!$data) {
            $this->model->insert([
                'description' => 'The Jalgaon Peoples Co-Op. Bank Ltd. is a regulated entity operating under the supervision of the Reserve Bank of India (RBI). Deposits are insured by DICGC up to ₹5,00,000 per depositor per bank.',
                'disclaimer' => '*Badges shown are for illustration. Please verify certifications independently.'
            ]);
            $data = $this->model->find(1);
        }
        return view('admin/trust_regulatory/edit', ['settings' => $data]);
    }

    public function update()
    {
        $rules = [
            'description' => 'required',
            'disclaimer' => 'required|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update(1, [
            'description' => $this->request->getPost('description'),
            'disclaimer' => $this->request->getPost('disclaimer')
        ]);

        return redirect()->to('/admin/trust-regulatory/edit')->with('message', 'Regulatory section updated.');
    }
}