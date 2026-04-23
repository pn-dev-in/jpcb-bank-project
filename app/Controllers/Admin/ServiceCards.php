<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceCardModel;

class ServiceCards extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ServiceCardModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/service_cards/index', $data);
    }

    public function create()
    {
        return view('admin/service_cards/form');
    }

    public function store()
    {
        $rules = [
            'icon'       => 'required|max_length[50]',
            'title'      => 'required|max_length[100]',
            'description'=> 'required',
            'href'       => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'icon'       => $this->request->getPost('icon'),
            'title'      => $this->request->getPost('title'),
            'description'=> $this->request->getPost('description'),
            'href'       => $this->request->getPost('href'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/service-cards')->with('message', 'Service card added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/service-cards')->with('error', 'Not found.');
        return view('admin/service_cards/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'icon'       => 'required|max_length[50]',
            'title'      => 'required|max_length[100]',
            'description'=> 'required',
            'href'       => 'required|max_length[255]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'icon'       => $this->request->getPost('icon'),
            'title'      => $this->request->getPost('title'),
            'description'=> $this->request->getPost('description'),
            'href'       => $this->request->getPost('href'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/service-cards')->with('message', 'Service card updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/service-cards')->with('message', 'Service card deleted.');
    }
}