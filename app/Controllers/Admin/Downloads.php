<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DownloadModel;

class Downloads extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DownloadModel();
    }

    public function index()
{
    $this->model->select('downloads.*, download_categories.name as category_name')
        ->join('download_categories', 'download_categories.id = downloads.category_id', 'left');
    $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
    return view('admin/downloads/index', $data);
}

    public function create()
{
    $catModel = new \App\Models\DownloadCategoryModel();
    $data['categories'] = $catModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
    return view('admin/downloads/form', $data);
}

    public function store()
    {
        $file = $this->request->getFile('document');
        
        // Manual file validation
        if (!$file || !$file->isValid()) {
            return redirect()->back()->withInput()->with('error', 'Please select a valid file.');
        }
        
        if ($file->getSize() > 10 * 1024 * 1024) { // 10MB
            return redirect()->back()->withInput()->with('error', 'File size must be less than 10MB.');
        }
        
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $ext = strtolower($file->getExtension());
        if (!in_array($ext, $allowedExtensions)) {
            return redirect()->back()->withInput()->with('error', 'Allowed file types: PDF, DOC, DOCX, XLS, XLSX.');
        }
        
        // Validate title and category
        $rules = [
            'title'       => 'required|max_length[255]',
            'category_id'    => 'required|integer',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create directory if not exists
        $uploadPath = FCPATH . 'uploads/downloads';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Move file
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        $filePath = 'uploads/downloads/' . $newName;
        $fileSize = $file->getSize();
        $fileType = strtoupper($ext);
        $thumbPath = null;
$thumb = $this->request->getFile('thumbnail');
if ($thumb && $thumb->isValid() && !$thumb->hasMoved()) {
    $thumbDir = FCPATH . 'uploads/downloads/thumbs';
    if (!is_dir($thumbDir)) mkdir($thumbDir, 0777, true);
    $thumbName = $thumb->getRandomName();
    $thumb->move($thumbDir, $thumbName);
    $thumbPath = 'uploads/downloads/thumbs/' . $thumbName;
}

        $this->model->insert([
            'title'        => $this->request->getPost('title'),
            'category_id' => $this->request->getPost('category_id'),
            'file_path'    => $filePath,
            'file_size'    => $fileSize,
            'file_type'    => $fileType,
            'thumbnail' => $thumbPath,
            'updated_date' => date('Y-m-d'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'downloads', $id);
        return redirect()->to('/admin/downloads')->with('message', 'Document uploaded successfully.');
    }

   public function edit($id)
{
    $item = $this->model->find($id);
    if (!$item) return redirect()->to('/admin/downloads')->with('error', 'Not found.');
    $catModel = new \App\Models\DownloadCategoryModel();
    $data['categories'] = $catModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
    $data['item'] = $item;
    return view('admin/downloads/form', $data);
}

    public function update($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/downloads')->with('error', 'Document not found.');
        }

        $rules = [
            'title'       => 'required|max_length[255]',
            'category_id' => 'required|integer',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'        => $this->request->getPost('title'),
            'category_id' => $this->request->getPost('category_id'),
            'sort_order'   => $this->request->getPost('sort_order') ?? 0,
            'status'       => $this->request->getPost('status') ?? 1,
        ];

        // Handle thumbnail replacement
$thumb = $this->request->getFile('thumbnail');
if ($thumb && $thumb->isValid() && !$thumb->hasMoved()) {
    // Delete old thumbnail if exists
    if (!empty($item['thumbnail']) && file_exists(FCPATH . $item['thumbnail'])) {
        unlink(FCPATH . $item['thumbnail']);
    }
    $thumbDir = FCPATH . 'uploads/downloads/thumbs';
    if (!is_dir($thumbDir)) mkdir($thumbDir, 0777, true);
    $thumbName = $thumb->getRandomName();
    $thumb->move($thumbDir, $thumbName);
    $data['thumbnail'] = 'uploads/downloads/thumbs/' . $thumbName;
}

        $newFile = $this->request->getFile('document');
        if ($newFile && $newFile->isValid() && !$newFile->hasMoved()) {
            // Validate new file
            if ($newFile->getSize() > 10 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'File size must be less than 10MB.');
            }
            $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
            $ext = strtolower($newFile->getExtension());
            if (!in_array($ext, $allowedExtensions)) {
                return redirect()->back()->withInput()->with('error', 'Allowed file types: PDF, DOC, DOCX, XLS, XLSX.');
            }

            // Delete old file
            $oldPath = FCPATH . $item['file_path'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $uploadPath = FCPATH . 'uploads/downloads';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = $newFile->getRandomName();
            $newFile->move($uploadPath, $newName);
            $data['file_path'] = 'uploads/downloads/' . $newName;
            $data['file_size'] = $newFile->getSize();
            $data['file_type'] = strtoupper($ext);
            $data['updated_date'] = date('Y-m-d');
        }

        $this->model->update($id, $data);
        log_activity('Updated', 'downloads', $id);
        return redirect()->to('/admin/downloads')->with('message', 'Document updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item) {
            $filePath = FCPATH . $item['file_path'];
            if (file_exists($filePath)) {
                // Delete thumbnail if exists
if (!empty($item['thumbnail']) && file_exists(FCPATH . $item['thumbnail'])) {
    unlink(FCPATH . $item['thumbnail']);
}
                unlink($filePath);
            }
            $this->model->delete($id);
        }
        log_activity('Deleted', 'downloads', $id);
        return redirect()->to('/admin/downloads')->with('message', 'Document deleted.');
    }
}