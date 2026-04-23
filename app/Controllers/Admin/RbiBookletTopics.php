<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RbiBookletTopicModel;

class RbiBookletTopics extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new RbiBookletTopicModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/rbi_booklet_topics/index', $data);
    }

    public function create()
    {
        return view('admin/rbi_booklet_topics/form');
    }

    public function store()
    {
        $rules = [
            'topic'      => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'topic'      => $this->request->getPost('topic'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-booklet-topics')->with('message', 'Topic added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/rbi-booklet-topics')->with('error', 'Not found.');
        return view('admin/rbi_booklet_topics/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'topic'      => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'topic'      => $this->request->getPost('topic'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/rbi-booklet-topics')->with('message', 'Topic updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/rbi-booklet-topics')->with('message', 'Topic deleted.');
    }
}