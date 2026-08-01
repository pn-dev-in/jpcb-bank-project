<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DownloadCategoryModel;

class DownloadCategories extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DownloadCategoryModel();
    }

    public function index()
    {
        $data['categories'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/download_categories/index', $data);
    }

    public function create()
    {
        return view('admin/download_categories/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[100]|is_unique[download_categories.name]',
            'slug'       => 'required|max_length[100]|is_unique[download_categories.slug]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'       => $this->request->getPost('name'),
            'slug'       => $this->request->getPost('slug'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ];

        $id = $this->model->insert($data);
        if ($id) {
            log_activity('Created', 'download_categories', $id);
            return redirect()->to('/admin/download-categories')->with('success', 'Category added.');
        }
        return redirect()->back()->with('error', 'Failed to add.');
    }

    public function edit($id)
    {
        $category = $this->model->find($id);
        if (!$category) return redirect()->to('/admin/download-categories')->with('error', 'Not found.');
        return view('admin/download_categories/form', ['category' => $category]);
    }

    public function update($id)
    {
        $rules = [
            'name'       => "required|max_length[100]|is_unique[download_categories.name,id,{$id}]",
            'slug'       => "required|max_length[100]|is_unique[download_categories.slug,id,{$id}]",
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'       => $this->request->getPost('name'),
            'slug'       => $this->request->getPost('slug'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ];

        $this->model->update($id, $data);
        log_activity('Updated', 'download_categories', $id);
        return redirect()->to('/admin/download-categories')->with('success', 'Category updated.');
    }

    public function delete($id)
    {
        // Check if any downloads use this category
        $downloadModel = new \App\Models\DownloadModel();
        $count = $downloadModel->where('category_id', $id)->countAllResults();
        if ($count > 0) {
            return redirect()->back()->with('error', 'Cannot delete category – it has ' . $count . ' downloads assigned.');
        }
        $this->model->delete($id);
        log_activity('Deleted', 'download_categories', $id);
        return redirect()->to('/admin/download-categories')->with('success', 'Category deleted.');
    }
}