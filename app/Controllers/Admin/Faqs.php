<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FaqModel;
use App\Models\FaqCategoryModel;

class Faqs extends BaseController
{
    protected $model;
    protected $categoryModel;

    public function __construct()
    {
        $this->model = new FaqModel();
        $this->categoryModel = new FaqCategoryModel();
    }

    public function index()
    {
        $faqs = $this->model->select('faqs.*, faq_categories.name as category_name')
            ->join('faq_categories', 'faq_categories.id = faqs.category_id')
            ->orderBy('faqs.sort_order', 'asc')
            ->findAll();
        $data['items'] = $faqs;
        return view('admin/faqs/index', $data);
    }

    public function create()
    {
        $data['categories'] = $this->categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
        return view('admin/faqs/form', $data);
    }

    public function store()
    {
        $rules = [
            'category_id' => 'required|integer',
            'question'    => 'required',
            'answer'      => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'category_id' => $this->request->getPost('category_id'),
            'question'    => $this->request->getPost('question'),
            'answer'      => $this->request->getPost('answer'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'faqs', $id);
        return redirect()->to('/admin/faqs')->with('message', 'FAQ added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/faqs')->with('error', 'Not found.');
        $data['item'] = $item;
        $data['categories'] = $this->categoryModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
        return view('admin/faqs/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'category_id' => 'required|integer',
            'question'    => 'required',
            'answer'      => 'required',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'question'    => $this->request->getPost('question'),
            'answer'      => $this->request->getPost('answer'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'faqs', $id);
        return redirect()->to('/admin/faqs')->with('message', 'FAQ updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'faqs', $id);
        return redirect()->to('/admin/faqs')->with('message', 'FAQ deleted.');
    }
}