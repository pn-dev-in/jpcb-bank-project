<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BoardMemberModel;

class BoardMembers extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new BoardMemberModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
        return view('admin/board_members/index', $data);
    }

    public function create()
    {
        return view('admin/board_members/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'role'       => 'required|max_length[100]',
            'category'   => 'required|max_length[100]',
            'bio'        => 'permit_empty',
            'image'    => 'uploaded[image]|is_image[image]|max_size[image,2048]', // 2MB max
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('image');
        $imageName = '';
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/board_members/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $newName = $imageFile->getRandomName();
            $imageFile->move($uploadPath, $newName);
            $imageName = 'uploads/board_members/' . $newName;
        }

        $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'role'       => $this->request->getPost('role'),
            'category'   => $this->request->getPost('category'),
            'bio'        => $this->request->getPost('bio'),
            'image'      => $imageName,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'board_members', $id);
        return redirect()->to('/admin/board-members')->with('message', 'Board member added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/board-members')->with('error', 'Not found.');
        return view('admin/board_members/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'role'       => 'required|max_length[100]',
            'category'   => 'required|max_length[100]',
            'bio'        => 'permit_empty',
            'image'    => 'permit_empty|is_image[image]|max_size[image,2048]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        $imageName = $item['image'] ?? '';

        $newImage = $this->request->getFile('image');
        if ($newImage && $newImage->isValid() && !$newImage->hasMoved()) {
            // Delete old image
            if (!empty($imageName) && file_exists(FCPATH . $imageName)) {
                unlink(FCPATH . $imageName);
            }
            $uploadPath = FCPATH . 'uploads/board_members/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $newName = $newImage->getRandomName();
            $newImage->move($uploadPath, $newName);
            $imageName = 'uploads/board_members/' . $newName;
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'role'       => $this->request->getPost('role'),
            'category'   => $this->request->getPost('category'),
            'bio'        => $this->request->getPost('bio'),
            'image'      => $imageName,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'board_members', $id);
        return redirect()->to('/admin/board-members')->with('message', 'Board member updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['image']) && file_exists(FCPATH . $item['image'])) {
            unlink(FCPATH . $item['image']);
        }
        $this->model->delete($id);
        log_activity('Deleted', 'board_members', $id);
        return redirect()->to('/admin/board-members')->with('message', 'Board member deleted.');
    }
}