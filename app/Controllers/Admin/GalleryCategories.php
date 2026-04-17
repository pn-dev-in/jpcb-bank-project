<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GalleryCategoryModel;

class GalleryCategories extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new GalleryCategoryModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/gallery_categories/index', $data);
    }

    public function create()
    {
        return view('admin/gallery_categories/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[100]',
            'slug'       => 'permit_empty|max_length[100]|is_unique[gallery_categories.slug]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = $this->request->getPost('slug');
        if (empty($slug)) {
            $slug = url_title($this->request->getPost('name'), '-', true);
        }

        $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'slug'       => $slug,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/gallery-categories')->with('message', 'Category added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/gallery-categories')->with('error', 'Not found.');
        return view('admin/gallery_categories/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[100]',
            'slug'       => 'permit_empty|max_length[100]|is_unique[gallery_categories.slug,id,'.$id.']',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = $this->request->getPost('slug');
        if (empty($slug)) {
            $slug = url_title($this->request->getPost('name'), '-', true);
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'slug'       => $slug,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/gallery-categories')->with('message', 'Category updated.');
    }

    public function delete($id)
    {
        // Check if category has items
        $itemModel = new \App\Models\GalleryItemModel();
        $count = $itemModel->where('category_id', $id)->countAllResults();
        if ($count > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with existing gallery items. Delete items first.');
        }
        $this->model->delete($id);
        return redirect()->to('/admin/gallery-categories')->with('message', 'Category deleted.');
    }
}