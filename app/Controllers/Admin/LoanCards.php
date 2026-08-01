<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanCardModel;

class LoanCards extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new LoanCardModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/loan_cards/index', $data);
    }

    public function create()
    {
        return view('admin/loan_cards/form');
    }

    public function store()
    {
        $rules = [
            'icon'       => 'required|max_length[50]',
            'title'      => 'required|max_length[100]',
            'description'=> 'required',
            'href'       => 'required|max_length[255]',
            'rate'       => 'required|max_length[50]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'icon'       => $this->request->getPost('icon'),
            'title'      => $this->request->getPost('title'),
            'description'=> $this->request->getPost('description'),
            'href'       => $this->request->getPost('href'),
            'rate'       => $this->request->getPost('rate'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'loan-cards', $id);
        return redirect()->to('/admin/loan-cards')->with('message', 'Loan card added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/loan-cards')->with('error', 'Not found.');
        return view('admin/loan_cards/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'icon'       => 'required|max_length[50]',
            'title'      => 'required|max_length[100]',
            'description'=> 'required',
            'href'       => 'required|max_length[255]',
            'rate'       => 'required|max_length[50]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'icon'       => $this->request->getPost('icon'),
            'title'      => $this->request->getPost('title'),
            'description'=> $this->request->getPost('description'),
            'href'       => $this->request->getPost('href'),
            'rate'       => $this->request->getPost('rate'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'loan-cards', $id);
        return redirect()->to('/admin/loan-cards')->with('message', 'Loan card updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'loan-cards', $id);
        return redirect()->to('/admin/loan-cards')->with('message', 'Loan card deleted.');
    }
}