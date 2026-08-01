<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ManagementTeamModel;

class ManagementTeam extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ManagementTeamModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/management_team/index', $data);
    }

    public function create()
    {
        return view('admin/management_team/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'role'       => 'required|max_length[100]',
            'department' => 'required|max_length[100]',
            'bio'        => 'permit_empty',
            'image'      => 'uploaded[image]|is_image[image]|max_size[image,2048]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('image');
        $imageName = '';
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/management_team/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $newName = $imageFile->getRandomName();
            $imageFile->move($uploadPath, $newName);
            $imageName = 'uploads/management_team/' . $newName;
        }

        $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'role'       => $this->request->getPost('role'),
            'department' => $this->request->getPost('department'),
            'bio'        => $this->request->getPost('bio'),
            'image'      => $imageName,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'management-team', $id);
        return redirect()->to('/admin/management-team')->with('message', 'Management member added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/management-team')->with('error', 'Not found.');
        return view('admin/management_team/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'role'       => 'required|max_length[100]',
            'department' => 'required|max_length[100]',
            'bio'        => 'permit_empty',
            'image'      => 'permit_empty|is_image[image]|max_size[image,2048]',
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
            if (!empty($imageName) && !preg_match('~^https?://~i', $imageName) && file_exists(FCPATH . $imageName)) {
                unlink(FCPATH . $imageName);
            }
            $uploadPath = FCPATH . 'uploads/management_team/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $newName = $newImage->getRandomName();
            $newImage->move($uploadPath, $newName);
            $imageName = 'uploads/management_team/' . $newName;
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'role'       => $this->request->getPost('role'),
            'department' => $this->request->getPost('department'),
            'bio'        => $this->request->getPost('bio'),
            'image'      => $imageName,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'management-team', $id);
        return redirect()->to('/admin/management-team')->with('message', 'Management member updated.');
    }

    public function delete($id)
    {   
         $item = $this->model->find($id);
        if ($item && !empty($item['image']) && !preg_match('~^https?://~i', $item['image']) && file_exists(FCPATH . $item['image'])) {
            unlink(FCPATH . $item['image']);
        }

        $this->model->delete($id);
        log_activity('Deleted', 'management-team', $id);
        return redirect()->to('/admin/management-team')->with('message', 'Management member deleted.');
    }
}
