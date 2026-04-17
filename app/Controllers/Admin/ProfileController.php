<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfileModel;

class ProfileController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProfileModel();
    }

    // LIST ALL PROFILES
    public function index()
    {
        $data['profiles'] = $this->model->findAll();
        return view('admin/profiles/index', $data);
    }

    // SHOW CREATE FORM
    public function create()
    {
        return view('admin/profiles/create');
    }

    // STORE DATA
    public function store()
    {
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $fileName = $file->getRandomName();
            $file->move('uploads/profiles/', $fileName);

            $this->model->save([
                'name' => $this->request->getPost('name'),
                'designation' => $this->request->getPost('designation'),
                'image' => 'uploads/profiles/' . $fileName
            ]);
        }

        return redirect()->to('/admin/profiles');
    }

    // DELETE PROFILE
    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/profiles');
    }
}