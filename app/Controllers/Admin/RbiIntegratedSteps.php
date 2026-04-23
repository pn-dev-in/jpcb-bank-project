<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RbiIntegratedStepModel;

class RbiIntegratedSteps extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new RbiIntegratedStepModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/rbi_integrated_steps/index', $data);
    }

    public function create()
    {
        return view('admin/rbi_integrated_steps/form');
    }

    public function store()
    {
        $rules = [
            'step_number' => 'required|max_length[10]',
            'title'       => 'required|max_length[100]',
            'description' => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'step_number' => $this->request->getPost('step_number'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-integrated-steps')->with('message', 'Step added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/rbi-integrated-steps')->with('error', 'Not found.');
        return view('admin/rbi_integrated_steps/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'step_number' => 'required|max_length[10]',
            'title'       => 'required|max_length[100]',
            'description' => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'step_number' => $this->request->getPost('step_number'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-integrated-steps')->with('message', 'Step updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/rbi-integrated-steps')->with('message', 'Step deleted.');
    }
}