<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NoticeModel;

class NoticeController extends BaseController
{
    public function index()
    {
        $model = new NoticeModel();
        $data['notices'] = $model->orderBy('date', 'DESC')->findAll();
        return view('admin/notices/index', $data);
    }

    public function create()
    {
        return view('admin/notices/form');
    }

    public function store()
    {
        $model = new NoticeModel();
        $model->save([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'type'        => $this->request->getPost('type'),
            'date'        => $this->request->getPost('date'),
        ]);
        return redirect()->to('/admin/notices')->with('success', 'Notice added.');
    }

    public function edit($id)
    {
        $model = new NoticeModel();
        $data['notice'] = $model->find($id);
        if (!$data['notice']) {
            return redirect()->to('/admin/notices')->with('error', 'Notice not found.');
        }
        return view('admin/notices/form', $data);
    }

    public function update($id)
    {
        $model = new NoticeModel();
        $model->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'type'        => $this->request->getPost('type'),
            'date'        => $this->request->getPost('date'),
        ]);
        return redirect()->to('/admin/notices')->with('success', 'Notice updated.');
    }

    public function delete($id)
    {
        $model = new NoticeModel();
        $model->delete($id);
        return redirect()->to('/admin/notices')->with('success', 'Notice deleted.');
    }
}