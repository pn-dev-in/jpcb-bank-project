<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WhatsNewModel;

class WhatsNew extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new WhatsNewModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/whats_new/index', $data);
    }

    public function create()
    {
        return view('admin/whats_new/form');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'type' => 'required|in_list[announcement,update,offer,news,alert]',
            'link_text' => 'permit_empty|max_length[100]',
            'link_url' => 'permit_empty|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle image upload
        $imagePath = '';
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/whats_new/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = time() . '_' . $file->getRandomName();
            $file->move($uploadPath, $newName);
            $imagePath = 'uploads/whats_new/' . $newName;
        }

        $isSticky = $this->request->getPost('is_sticky') ?? 0;
        $stickyPosition = $this->request->getPost('sticky_position') ?? 'top';
        $bgColor = $this->request->getPost('bg_color');
        $textColor = $this->request->getPost('text_color');

        $id = $this->model->insert([
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'image' => $imagePath,
            'type' => $this->request->getPost('type'),
            'link_text' => $this->request->getPost('link_text'),
            'link_url' => $this->request->getPost('link_url'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1,
            'is_sticky'       => $isSticky,
'sticky_position' => $stickyPosition,
'bg_color'        => $bgColor,
'text_color'      => $textColor,

        ]);

        if ($id) {
            return redirect()->to('/admin/whats-new')->with('success', 'What\'s New item added.');
        }
        log_activity('Created', 'Whats New', $this->model->getInsertID());
        return redirect()->back()->withInput()->with('error', 'Failed to add item.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/whats-new')->with('error', 'Item not found.');
        }
        log_activity('Created', 'upi_transaction_limits', $this->model->getInsertID());
        return view('admin/whats_new/form', ['item' => $item]);
    }

    public function update($id)
    {
        $existingItem = $this->model->find($id);
        if (!$existingItem) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        $rules = [
            'title' => 'required|max_length[255]',
            'content' => 'required',
            'type' => 'required|in_list[announcement,update,offer,news,alert]',
            'link_text' => 'permit_empty|max_length[100]',
            'link_url' => 'permit_empty|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer',
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
            $uploadPath = FCPATH . 'uploads/whats_new/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = time() . '_' . $file->getRandomName();
            $file->move($uploadPath, $newName);
            $imagePath = 'uploads/whats_new/' . $newName;
        }

        $isSticky = $this->request->getPost('is_sticky') ?? 0;
$stickyPosition = $this->request->getPost('sticky_position') ?? 'top';
$bgColor = $this->request->getPost('bg_color');
$textColor = $this->request->getPost('text_color');

        $updated = $this->model->update($id, [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'image' => $imagePath,
            'type' => $this->request->getPost('type'),
            'link_text' => $this->request->getPost('link_text'),
            'link_url' => $this->request->getPost('link_url'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1,
            'is_sticky'       => $isSticky,
'sticky_position' => $stickyPosition,
'bg_color'        => $bgColor,
'text_color'      => $textColor,
        ]);

        if ($updated) {
            return redirect()->to('/admin/whats-new')->with('success', 'What\'s New item updated.');
        }
        log_activity('Updated', 'Whats New', $this->model->getInsertID());
        return redirect()->back()->withInput()->with('error', 'Failed to update item.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['image']) && file_exists(FCPATH . $item['image'])) {
            unlink(FCPATH . $item['image']);
        }
        $this->model->delete($id);
        log_activity('Deleted', 'Whats New', $this->model->getInsertID());
        return redirect()->to('/admin/whats-new')->with('success', 'Item deleted.');
    }
}