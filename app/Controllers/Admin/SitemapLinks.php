<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SitemapLinkModel;
use App\Models\SitemapSectionModel;

class SitemapLinks extends BaseController
{
    protected $model;
    protected $sectionModel;

    public function __construct()
    {
        $this->model = new SitemapLinkModel();
        $this->sectionModel = new SitemapSectionModel();
    }

    public function index()
    {
        $data['items'] = $this->model->select('sitemap_links.*, sitemap_sections.title as section_title')
            ->join('sitemap_sections', 'sitemap_sections.id = sitemap_links.section_id')
            ->orderBy('sitemap_links.sort_order', 'asc')
            ->findAll();
        return view('admin/sitemap_links/index', $data);
    }

    public function create()
    {
        $data['sections'] = $this->sectionModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
        return view('admin/sitemap_links/form', $data);
    }

    public function store()
    {
        $rules = [
            'section_id' => 'required|integer',
            'label'      => 'required|max_length[255]',
            'href'       => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'section_id' => $this->request->getPost('section_id'),
            'label'      => $this->request->getPost('label'),
            'href'       => $this->request->getPost('href'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'sitemap-links', $id);
        return redirect()->to('/admin/sitemap-links')->with('message', 'Sitemap link added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/sitemap-links')->with('error', 'Not found.');
        $data['item'] = $item;
        $data['sections'] = $this->sectionModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
        return view('admin/sitemap_links/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'section_id' => 'required|integer',
            'label'      => 'required|max_length[255]',
            'href'       => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'section_id' => $this->request->getPost('section_id'),
            'label'      => $this->request->getPost('label'),
            'href'       => $this->request->getPost('href'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'sitemap-links', $id);
        return redirect()->to('/admin/sitemap-links')->with('message', 'Sitemap link updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'sitemap-links', $id);
        return redirect()->to('/admin/sitemap-links')->with('message', 'Sitemap link deleted.');
    }
}