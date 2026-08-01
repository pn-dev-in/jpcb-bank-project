<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GalleryItemModel;
use App\Models\GalleryCategoryModel;

class GalleryItems extends BaseController
{
    protected $model;
    protected $categoryModel;

    public function __construct()
    {
        $this->model = new GalleryItemModel();
        $this->categoryModel = new GalleryCategoryModel();
    }

    public function index()
    {
        $data['items'] = $this->model->select('gallery_items.*, gallery_categories.name as category_name')
            ->join('gallery_categories', 'gallery_categories.id = gallery_items.category_id')
            ->orderBy('gallery_items.sort_order', 'asc')
            ->findAll();
        return view('admin/gallery_items/index', $data);
    }

    public function create()
    {
        $categoryModel = new \App\Models\GalleryCategoryModel();
        $data['categories'] = $categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll() ?? [];
        return view('admin/gallery_items/form', $data);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|max_length[255]',
            'category_id' => 'required|integer',
            'description' => 'permit_empty',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,5120]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = '';
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/gallery/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = $image->getRandomName();
            $image->move($uploadPath, $newName);
            $imageName = 'uploads/gallery/' . $newName;
        }

        $id = $this->model->insert([
            'title' => $this->request->getPost('title'),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description'),
            'event_date' => $this->request->getPost('event_date'),
            'image' => $imageName,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1,
        ]);

        // Handle sub‑photos (multiple)
        $subImages = $this->request->getFileMultiple('sub_images');
        if ($subImages) {
            $imageModel = new \App\Models\GalleryImageModel();
            $order = 0;
            foreach ($subImages as $img) {
                if ($img && $img->isValid() && !$img->hasMoved()) {
                    $uploadPath = FCPATH . 'uploads/gallery/sub/';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    $subName = $img->getRandomName();
                    $img->move($uploadPath, $subName);
                    $imageModel->insert([
                        'gallery_item_id' => $id,
                        'image_path' => 'uploads/gallery/sub/' . $subName,
                        'sort_order' => $order++,
                        'status' => 1,
                    ]);
                }
            }
        }

        log_activity('Created', 'gallery_items', $id);
        return redirect()->to('/admin/gallery-items')->with('success', 'Gallery item added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/gallery-items')->with('error', 'Item not found.');
        }
        $categoryModel = new \App\Models\GalleryCategoryModel();
        $data['categories'] = $categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll() ?? [];
        $data['item'] = $item;

        // (Optional) If you have sub‑photos, fetch them too
        $imageModel = new \App\Models\GalleryImageModel();
        $data['subImages'] = $imageModel->where('gallery_item_id', $id)->orderBy('sort_order', 'asc')->findAll() ?? [];

        return view('admin/gallery_items/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'title' => 'required|max_length[255]',
            'category_id' => 'required|integer',
            'description' => 'permit_empty',
            'image' => 'permit_empty|is_image[image]|max_size[image,5120]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        $imageName = $item['image'] ?? '';

        $newImage = $this->request->getFile('image');
        if ($newImage && $newImage->isValid() && !$newImage->hasMoved()) {
            // Delete old image if exists
            if (!empty($imageName) && !preg_match('~^https?://~i', $imageName) && file_exists(FCPATH . $imageName)) {
                unlink(FCPATH . $imageName);
            }
            $uploadPath = FCPATH . 'uploads/gallery/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = $newImage->getRandomName();
            $newImage->move($uploadPath, $newName);
            $imageName = 'uploads/gallery/' . $newName;
        }

        $this->model->update($id, [
            'title' => $this->request->getPost('title'),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description'),
            'event_date' => $this->request->getPost('event_date'),
            'image' => $imageName,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1,
        ]);

        // Handle sub‑photos
        $imageModel = new \App\Models\GalleryImageModel();
        $keepIds = $this->request->getPost('keep_sub_image_ids') ?: []; // array of IDs to keep
        $existingSubs = $imageModel->where('gallery_item_id', $id)->findAll();
        foreach ($existingSubs as $sub) {
            if (!in_array($sub['id'], $keepIds)) {
                // Delete file
                if (!preg_match('~^https?://~i', $sub['image_path']) && is_file(FCPATH . $sub['image_path']))
                    unlink(FCPATH . $sub['image_path']);
                $imageModel->delete($sub['id']);
            }
        }
        // Add new sub‑photos
        $newSubs = $this->request->getFileMultiple('sub_images');
        if ($newSubs) {
            $maxOrder = $imageModel->where('gallery_item_id', $id)->selectMax('sort_order')->first()['sort_order'] ?? -1;
            $order = $maxOrder + 1;
            foreach ($newSubs as $img) {
                if ($img && $img->isValid() && !$img->hasMoved()) {
                    $uploadPath = FCPATH . 'uploads/gallery/sub/';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    $subName = $img->getRandomName();
                    $img->move($uploadPath, $subName);
                    $imageModel->insert([
                        'gallery_item_id' => $id,
                        'image_path' => 'uploads/gallery/sub/' . $subName,
                        'sort_order' => $order++,
                        'status' => 1,
                    ]);
                }
            }
        }
        log_activity('Updated', 'gallery_items', $id);
        return redirect()->to('/admin/gallery-items')->with('success', 'Gallery item updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['image']) && !preg_match('~^https?://~i', $item['image']) && is_file(FCPATH . $item['image']))
            unlink(FCPATH . $item['image']);
        // Delete sub‑photos
        $subModel = new \App\Models\GalleryImageModel();
        $subs = $subModel->where('gallery_item_id', $id)->findAll();
        foreach ($subs as $sub) {
            if (!preg_match('~^https?://~i', $sub['image_path']) && is_file(FCPATH . $sub['image_path']))
                unlink(FCPATH . $sub['image_path']);
            $subModel->delete($sub['id']);
        }
        $this->model->delete($id);
        log_activity('Deleted', 'gallery_items', $id);
        return redirect()->to('/admin/gallery-items')->with('success', 'Gallery item deleted.');
    }
}
