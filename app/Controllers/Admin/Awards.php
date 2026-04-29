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
            'organization' => 'required|max_length[255]',
            'description'  => 'required',
            'image'        => 'uploaded[image]|is_image[image]|max_size[image,2048]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('image');
        $imageName = '';
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/awards/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $newName = $imageFile->getRandomName();
            $imageFile->move($uploadPath, $newName);
            $imageName = 'uploads/awards/' . $newName;
        }

        $this->model->insert([
            'year'         => $this->request->getPost('year'),
            'title'        => $this->request->getPost('title'),
            'organization' => $this->request->getPost('organization'),
            'description'  => $this->request->getPost('description'),
            'image'        => $imageName,
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'awards', $id);
        return redirect()->to('/admin/awards')->with('message', 'Award added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/awards')->with('error', 'Not found.');
        return view('admin/awards/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'year'         => 'required|max_length[10]',
            'title'        => 'required|max_length[255]',
            'organization' => 'required|max_length[255]',
            'description'  => 'required',
            'image'        => 'permit_empty|is_image[image]|max_size[image,2048]',
            'sort_order'   => 'permit_empty|integer',
            'status'       => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        $imageName = $item['image'] ?? '';

        $newImage = $this->request->getFile('image');
        if ($newImage && $newImage->isValid() && !$newImage->hasMoved()) {
            if (!empty($imageName) && file_exists(FCPATH . $imageName)) {
                unlink(FCPATH . $imageName);
            }
            $uploadPath = FCPATH . 'uploads/awards/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $newName = $newImage->getRandomName();
            $newImage->move($uploadPath, $newName);
            $imageName = 'uploads/awards/' . $newName;
        }

        $this->model->update($id, [
            'year'         => $this->request->getPost('year'),
            'title'        => $this->request->getPost('title'),
            'organization' => $this->request->getPost('organization'),
            'description'  => $this->request->getPost('description'),
            'image'        => $imageName,
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'awards', $id);
        return redirect()->to('/admin/awards')->with('message', 'Award updated.');
    }

    public function delete($id)
    {   
         $item = $this->model->find($id);
        if ($item && !empty($item['image']) && file_exists(FCPATH . $item['image'])) {
            unlink(FCPATH . $item['image']);
        }

        $this->model->delete($id);
        log_activity('Deleted', 'awards', $id);
        return redirect()->to('/admin/awards')->with('message', 'Award deleted.');
    }
}