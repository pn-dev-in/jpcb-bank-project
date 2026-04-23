<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RbiDontModel;

class RbiDonts extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new RbiDontModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/rbi_donts/index', $data);
    }

    public function create()
    {
        return view('admin/rbi_donts/form');
    }

    public function store()
    {
        $rules = [
            'item'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'item'       => $this->request->getPost('item'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-donts')->with('message', 'Dont item added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/rbi-donts')->with('error', 'Not found.');
        return view('admin/rbi_donts/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'item'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'item'       => $this->request->getPost('item'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-donts')->with('message', 'Dont item updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/rbi-donts')->with('message', 'Dont item deleted.');
    }
}