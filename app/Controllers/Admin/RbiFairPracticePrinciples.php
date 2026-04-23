<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RbiFairPracticePrincipleModel;

class RbiFairPracticePrinciples extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new RbiFairPracticePrincipleModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/rbi_fair_practice_principles/index', $data);
    }

    public function create()
    {
        return view('admin/rbi_fair_practice_principles/form');
    }

    public function store()
    {
        $rules = [
            'principle'  => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'principle'  => $this->request->getPost('principle'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-fair-practice-principles')->with('message', 'Principle added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/rbi-fair-practice-principles')->with('error', 'Not found.');
        return view('admin/rbi_fair_practice_principles/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'principle'  => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'principle'  => $this->request->getPost('principle'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-fair-practice-principles')->with('message', 'Principle updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/rbi-fair-practice-principles')->with('message', 'Principle deleted.');
    }
}