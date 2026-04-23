<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DigisaathiCategoryModel;

class DigisaathiCategories extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DigisaathiCategoryModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/digisaathi_categories/index', $data);
    }

    public function create()
    {
        return view('admin/digisaathi_categories/form');
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|max_length[150]',
            'description' => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/digisaathi-categories')->with('message', 'Category added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/digisaathi-categories')->with('error', 'Not found.');
        return view('admin/digisaathi_categories/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'title'       => 'required|max_length[150]',
            'description' => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/digisaathi-categories')->with('message', 'Category updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/digisaathi-categories')->with('message', 'Category deleted.');
    }
}