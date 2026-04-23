<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlockCardAfterStepModel;

class BlockCardAfterSteps extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new BlockCardAfterStepModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/block_card_after_steps/index', $data);
    }

    public function create()
    {
        return view('admin/block_card_after_steps/form');
    }

    public function store()
    {
        $rules = [
            'step'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'step'       => $this->request->getPost('step'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/block-card-after-steps')->with('message', 'Step added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/block-card-after-steps')->with('error', 'Not found.');
        return view('admin/block_card_after_steps/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'step'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'step'       => $this->request->getPost('step'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/block-card-after-steps')->with('message', 'Step updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/block-card-after-steps')->with('message', 'Step deleted.');
    }
}