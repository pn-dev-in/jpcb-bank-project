<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BannerModel;

class BannerController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }

        $model = new BannerModel();
        $data['banners'] = $model->findAll();

        return view('admin/banners/index', $data);
    }

    public function create()
    {
        return view('admin/banners/create');
    }

    public function store()
    {
        $model = new BannerModel();

        $file = $this->request->getFile('image');

        if ($file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName();
            $file->move('uploads/banners', $name);

            $model->save([
                'title' => $this->request->getPost('title'),
                'image' => $name,
                'status' => 1
            ]);
        }

        return redirect()->to('/admin/banners');
    }

    public function delete($id)
    {
        $model = new BannerModel();
        $model->delete($id);

        return redirect()->to('/admin/banners');
    }
}