<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AwardModel;

class Awards extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AwardModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
        return view('admin/awards/index', $data);
    }

    public function create()
    {
        return view('admin/awards/form');
    }

    public function store()
    {
        $rules = [
            'year'         => 'required|max_length[10]',
            'title'        => 'required|max_length[255]',
            'organization' => 'permit_empty|max_length[255]',
            'description'  => 'permit_empty|max_length[255]',
            'image'        => 'permit_empty|is_image[image]|max_size[image,2048]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'year'         => $this->request->getPost('year'),
            'title'        => $this->request->getPost('title'),
            'organization' => $this->request->getPost('organization'),
            'description'  => $this->request->getPost('description'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ];

        // Handle image upload (optional)
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/awards/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['image'] = 'uploads/awards/' . $newName;
        }

        $id = $this->model->insert($data);
        if ($id) {
            log_activity('Created', 'awards', $id);
            return redirect()->to('/admin/awards')->with('success', 'Award added successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add award.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/awards')->with('error', 'Award not found.');
        }
        return view('admin/awards/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'year'         => 'required|max_length[10]',
            'title'        => 'required|max_length[255]',
            'organization' => 'permit_empty|max_length[255]',
            'description'  => 'permit_empty|max_length[255]',
            'image'        => 'permit_empty|is_image[image]|max_size[image,2048]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/awards')->with('error', 'Award not found.');
        }

        $data = [
            'year'         => $this->request->getPost('year'),
            'title'        => $this->request->getPost('title'),
            'organization' => $this->request->getPost('organization'),
            'description'  => $this->request->getPost('description'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ];

        // Handle image upload (optional)
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old image if exists
            if (!empty($item['image']) && is_file(FCPATH . $item['image'])) {
                unlink(FCPATH . $item['image']);
            }
            $uploadPath = FCPATH . 'uploads/awards/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['image'] = 'uploads/awards/' . $newName;
        } else {
            // Preserve existing image if no new file uploaded
            $data['image'] = $item['image'];
        }

        $this->model->update($id, $data);
        log_activity('Updated', 'awards', $id);
        return redirect()->to('/admin/awards')->with('success', 'Award updated successfully.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['image']) && is_file(FCPATH . $item['image'])) {
            unlink(FCPATH . $item['image']);
        }
        $this->model->delete($id);
        log_activity('Deleted', 'awards', $id);
        return redirect()->to('/admin/awards')->with('success', 'Award deleted successfully.');
    }
}