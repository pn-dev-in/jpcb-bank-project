<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PopupModel;

class PopupController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PopupModel();
    }

    public function index()
    {
        $data['popups'] = $this->model->findAll();
        return view('admin/popups/index', $data);
    }

    public function create()
    {
        return view('admin/popups/create');
    }

    public function store()
    {
        $file = $this->request->getFile('image');

        $filePath = null;

        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/popups/', $fileName);
            $filePath = 'uploads/popups/' . $fileName;
        }

        $this->model->save([
            'title' => $this->request->getPost('title'),
            'message' => $this->request->getPost('message'),
            'image' => $filePath,
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'status' => $this->request->getPost('status') ? 1 : 0,
        ]);

        return redirect()->to('/admin/popups');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/popups');
    }
}