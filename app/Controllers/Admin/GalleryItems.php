<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GalleryItemModel;
use App\Models\GalleryCategoryModel;

class GalleryItems extends BaseController
{
    protected $model;
    protected $categoryModel;

    public function __construct()
    {
        $this->model = new GalleryItemModel();
        $this->categoryModel = new GalleryCategoryModel();
    }

    public function index()
    {
        $data['items'] = $this->model->select('gallery_items.*, gallery_categories.name as category_name')
            ->join('gallery_categories', 'gallery_categories.id = gallery_items.category_id')
            ->orderBy('gallery_items.sort_order', 'asc')
            ->findAll();
        return view('admin/gallery_items/index', $data);
    }

    public function create()
    {
        $data['categories'] = $this->categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
        return view('admin/gallery_items/form', $data);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|max_length[255]',
            'category_id' => 'required|integer',
            'description' => 'permit_empty',
            'image'       => 'uploaded[image]|is_image[image]|max_size[image,5120]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = '';
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/gallery', $newName);
            $imageName = 'uploads/gallery/' . $newName;
        }

        $this->model->insert([
            'title'       => $this->request->getPost('title'),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description'),
            'image'       => $imageName,
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'gallery-items', $id);
        return redirect()->to('/admin/gallery-items')->with('message', 'Gallery item added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/gallery-items')->with('error', 'Item not found.');
        }
        $data['item'] = $item;
        $data['categories'] = $this->categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
        return view('admin/gallery_items/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'title'       => 'required|max_length[255]',
            'category_id' => 'required|integer',
            'description' => 'permit_empty',
            'image'       => 'permit_empty|is_image[image]|max_size[image,5120]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        $imageName = $item['image'] ?? '';

        $newImage = $this->request->getFile('image');
        if ($newImage && $newImage->isValid() && !$newImage->hasMoved()) {
            // Delete old image if exists
            if (!empty($imageName) && file_exists(FCPATH . $imageName)) {
                unlink(FCPATH . $imageName);
            }
            $newName = $newImage->getRandomName();
            $newImage->move('uploads/gallery', $newName);
            $imageName = 'uploads/gallery/' . $newName;
        }

        $this->model->update($id, [
            'title'       => $this->request->getPost('title'),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description'),
            'image'       => $imageName,
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'gallery-items', $id);
        return redirect()->to('/admin/gallery-items')->with('message', 'Gallery item updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['image']) && file_exists(FCPATH . $item['image'])) {
            unlink(FCPATH . $item['image']);
        }
        $this->model->delete($id);
        log_activity('Deleted', 'gallery-items', $id);
        return redirect()->to('/admin/gallery-items')->with('message', 'Gallery item deleted.');
    }
}