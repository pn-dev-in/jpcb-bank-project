<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SitemapSectionModel;
use App\Models\SitemapLinkModel;

class SitemapSections extends BaseController
{
    protected $model;
    protected $linkModel;

    public function __construct()
    {
        $this->model = new SitemapSectionModel();
        $this->linkModel = new SitemapLinkModel();
    }

    public function index()
    {
        $sections = $this->model->orderBy('sort_order', 'asc')->findAll();
        foreach ($sections as &$section) {
            $section['links'] = $this->linkModel->where('section_id', $section['id'])->orderBy('sort_order', 'asc')->findAll();
        }
        $data['items'] = $sections;
        return view('admin/sitemap_sections/index', $data);
    }

    public function create()
    {
        return view('admin/sitemap_sections/form');
    }

    public function store()
    {
        $rules = [
            'title'      => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'title'      => $this->request->getPost('title'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/sitemap-sections')->with('message', 'Sitemap section added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/sitemap-sections')->with('error', 'Not found.');
        $data['item'] = $item;
        $data['links'] = $this->linkModel->where('section_id', $id)->orderBy('sort_order', 'asc')->findAll();
        return view('admin/sitemap_sections/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'title'      => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'title'      => $this->request->getPost('title'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/sitemap-sections')->with('message', 'Sitemap section updated.');
    }

    public function delete($id)
    {
        // Delete all links under this section first
        $this->linkModel->where('section_id', $id)->delete();
        $this->model->delete($id);
        return redirect()->to('/admin/sitemap-sections')->with('message', 'Sitemap section deleted.');
    }
}