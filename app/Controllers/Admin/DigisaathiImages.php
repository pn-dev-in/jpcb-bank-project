<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DigisaathiImageModel;

class DigisaathiImages extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DigisaathiImageModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('section', 'asc')->orderBy('sort_order', 'asc')->findAll();
        return view('admin/digisaathi_images/index', $data);
    }

    public function create()
    {
        return view('admin/digisaathi_images/form');
    }

    public function store()
    {
        $rules = [
            'section'     => 'required|max_length[100]',
            'image_path'  => 'required|max_length[255]',
            'alt_text'    => 'permit_empty|max_length[255]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        $img = $this->request->getFile('image_file');
        $imagePath = $this->request->getPost('image_path');
        
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = 'digisaathi_' . $this->request->getPost('section') . '_' . $img->getRandomName();
            $img->move('uploads/digisaathi', $newName);
            $imagePath = 'uploads/digisaathi/' . $newName;
        }

        $this->model->insert([
            'section'     => $this->request->getPost('section'),
            'image_path'  => $imagePath,
            'alt_text'    => $this->request->getPost('alt_text'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        session()->setFlashdata('message', 'Image added successfully.');
        return redirect()->to('/admin/digisaathi-images');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            session()->setFlashdata('error', 'Image not found.');
            return redirect()->to('/admin/digisaathi-images');
        }
        return view('admin/digisaathi_images/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'section'     => 'required|max_length[100]',
            'alt_text'    => 'permit_empty|max_length[255]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        $imagePath = $item['image_path'];
        
        // Handle file upload
        $img = $this->request->getFile('image_file');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Delete old image if exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $newName = 'digisaathi_' . $this->request->getPost('section') . '_' . $img->getRandomName();
            $img->move('uploads/digisaathi', $newName);
            $imagePath = 'uploads/digisaathi/' . $newName;
        }

        $this->model->update($id, [
            'section'     => $this->request->getPost('section'),
            'image_path'  => $imagePath,
            'alt_text'    => $this->request->getPost('alt_text'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        session()->setFlashdata('message', 'Image updated successfully.');
        return redirect()->to('/admin/digisaathi-images');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && file_exists($item['image_path'])) {
            unlink($item['image_path']);
        }
        $this->model->delete($id);
        session()->setFlashdata('message', 'Image deleted successfully.');
        return redirect()->to('/admin/digisaathi-images');
    }
}