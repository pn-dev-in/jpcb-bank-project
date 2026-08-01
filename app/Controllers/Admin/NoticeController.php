<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NoticeModel;

class NoticeController extends BaseController
{
    public function index()
    {
        $model = new NoticeModel();
        $data['notices'] = $model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/notices/index', $data);
    }

    public function create()
    {
        return view('admin/notices/form');
    }

    public function store()
    {
        $model = new NoticeModel();

        $data = [
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'type'          => $this->request->getPost('type'),
            'date'          => $this->request->getPost('date'),
            'status'        => $this->request->getPost('status') ?? 1,
            'sort_order'    => $this->request->getPost('sort_order') ?? 0,
            'external_link' => $this->request->getPost('external_link') ?? null,
        ];

        // Handle file upload
        $file = $this->request->getFile('notice_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/notices/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['file_path'] = 'uploads/notices/' . $newName;
        }

        $model->save($data);
        $noticeId = $model->getInsertID();

        log_activity('Created', 'notices', $noticeId);
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
        $notice = $model->find($id);
        if (!$notice) {
            return redirect()->to('/admin/notices')->with('error', 'Notice not found.');
        }

        $data = [
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'type'          => $this->request->getPost('type'),
            'date'          => $this->request->getPost('date'),
            'status'        => $this->request->getPost('status') ?? 1,
            'sort_order'    => $this->request->getPost('sort_order') ?? 0,
            'external_link' => $this->request->getPost('external_link') ?? null,
        ];

        // Handle file replacement
        $file = $this->request->getFile('notice_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/notices/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['file_path'] = 'uploads/notices/' . $newName;

            // Remove old file
            $oldPath = $notice['file_path'] ?? '';
            if ($oldPath && file_exists(FCPATH . $oldPath)) {
                @unlink(FCPATH . $oldPath);
            }
        } else {
            // Keep existing file if no new upload
            $data['file_path'] = $notice['file_path'] ?? null;
        }

        $model->update($id, $data);

        log_activity('Updated', 'notices', $id);
        return redirect()->to('/admin/notices')->with('success', 'Notice updated.');
    }

    public function delete($id)
    {
        $model = new NoticeModel();
        $notice = $model->find($id);
        if ($notice && !empty($notice['file_path']) && file_exists(FCPATH . $notice['file_path'])) {
            @unlink(FCPATH . $notice['file_path']);
        }
        $model->delete($id);
        log_activity('Deleted', 'notices', $id);
        return redirect()->to('/admin/notices')->with('success', 'Notice deleted.');
    }
}