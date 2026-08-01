<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HomeSliderModel;

class HomeSliders extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new HomeSliderModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/home_sliders/index', $data);
    }

    public function create()
    {
        return view('admin/home_sliders/form');
    }

    public function store()
    {
        $rules = [
            'title'       => 'permit_empty|max_length[255]',
            'subtitle'    => 'permit_empty',
            'image'       => 'uploaded[image]|max_size[image,5120]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'button_text' => 'permit_empty|max_length[100]',
            'button_link' => 'permit_empty|max_length[255]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle image upload
        $file = $this->request->getFile('image');
        $imagePath = '';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Create directory if not exists
            $uploadPath = FCPATH . 'uploads/sliders/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique filename
            $newName = time() . '_' . $file->getRandomName();
            $file->move($uploadPath, $newName);
            $imagePath = 'uploads/sliders/' . $newName;
        }

        $id = $this->model->insert([
            'title'       => $this->request->getPost('title'),
            'subtitle'    => $this->request->getPost('subtitle'),
            'image'       => $imagePath,
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        if ($id) {
            return redirect()->to('/admin/home-sliders')->with('success', 'Slider added successfully.');
        }
        return redirect()->back()->withInput()->with('error', 'Failed to add slider.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/home-sliders')->with('error', 'Slider not found.');
        }
        return view('admin/home_sliders/form', ['item' => $item]);
    }

    public function update($id)
    {
        $existingItem = $this->model->find($id);
        if (!$existingItem) {
            return redirect()->back()->with('error', 'Slider not found.');
        }

        $rules = [
            'title'       => 'permit_empty|max_length[255]',
            'subtitle'    => 'permit_empty',
            'image'       => 'permit_empty|max_size[image,5120]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'button_text' => 'permit_empty|max_length[100]',
            'button_link' => 'permit_empty|max_length[255]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imagePath = $existingItem['image'];

        // Handle new image upload
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old image
            if (!empty($existingItem['image']) && file_exists(FCPATH . $existingItem['image'])) {
                unlink(FCPATH . $existingItem['image']);
            }

            // Create directory if not exists
            $uploadPath = FCPATH . 'uploads/sliders/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique filename
            $newName = time() . '_' . $file->getRandomName();
            $file->move($uploadPath, $newName);
            $imagePath = 'uploads/sliders/' . $newName;
        }

        $updated = $this->model->update($id, [
            'title'       => $this->request->getPost('title'),
            'subtitle'    => $this->request->getPost('subtitle'),
            'image'       => $imagePath,
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        if ($updated) {
            return redirect()->to('/admin/home-sliders')->with('success', 'Slider updated successfully.');
        }
        return redirect()->back()->withInput()->with('error', 'Failed to update slider.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['image']) && file_exists(FCPATH . $item['image'])) {
            unlink(FCPATH . $item['image']);
        }
        
        $this->model->delete($id);
        return redirect()->to('/admin/home-sliders')->with('success', 'Slider deleted successfully.');
    }
}