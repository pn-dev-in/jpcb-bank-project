<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DocumentModel;

class DocumentController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DocumentModel();
    }

    public function index()
{
    $data['documents'] = $this->model->orderBy('id', 'DESC')->findAll();
    return view('admin/documents/index', $data);
}

    public function create()
    {
        return view('admin/documents/create');
    }

    public function store()
    {
        $file = $this->request->getFile('file');

        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/documents/', $fileName);

            $this->model->save([
                'title' => $this->request->getPost('title'),
                'category' => $this->request->getPost('category'),
                'file_path' => 'uploads/documents/' . $fileName
            ]);
        }

        return redirect()->to('/admin/documents');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/documents');
    }

    public function forms()
{
    $model = new \App\Models\DocumentModel();

    $data['documents'] = $model
        ->where('category', 'Forms')
        ->findAll();

    return view('admin/documents/forms', $data);
}
}