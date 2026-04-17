<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SocialLinkModel;

class SocialLinks extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SocialLinkModel();
    }

    public function index()
    {
        $links = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/social_links/index', ['links' => $links]);
    }

    public function create()
    {
        return view('admin/social_links/form');
    }

    public function store()
    {
        $rules = [
            'platform' => 'required|max_length[50]',
            'icon' => 'required|max_length[50]',
            'url' => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->model->save([
            'platform' => $this->request->getPost('platform'),
            'icon' => $this->request->getPost('icon'),
            'url' => $this->request->getPost('url'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1
        ]);
        return redirect()->to('/admin/social-links')->with('message', 'Social link added.');
    }

    public function edit($id)
    {
        $link = $this->model->find($id);
        if (!$link) return redirect()->to('/admin/social-links')->with('error', 'Link not found');
        return view('admin/social_links/form', ['link' => $link]);
    }

    public function update($id)
    {
        $rules = [
            'platform' => 'required|max_length[50]',
            'icon' => 'required|max_length[50]',
            'url' => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->model->update($id, [
            'platform' => $this->request->getPost('platform'),
            'icon' => $this->request->getPost('icon'),
            'url' => $this->request->getPost('url'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1
        ]);
        return redirect()->to('/admin/social-links')->with('message', 'Social link updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/social-links')->with('message', 'Social link deleted.');
    }
}