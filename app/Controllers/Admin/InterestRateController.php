<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InterestRateModel;

class InterestRateController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new InterestRateModel();
    }

    public function index()
    {
        $data['rates'] = $this->model->orderBy('id', 'DESC')->findAll();
        return view('admin/interest_rates/index', $data);
    }

    public function create()
    {
        return view('admin/interest_rates/create');
    }

    public function store()
    {
        $this->model->save([
            'type' => $this->request->getPost('type'),
            'title' => $this->request->getPost('title'),
            'rate' => $this->request->getPost('rate'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/interest-rates');
    }

    public function edit($id)
    {
        $data['rate'] = $this->model->find($id);
        return view('admin/interest_rates/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'type' => $this->request->getPost('type'),
            'title' => $this->request->getPost('title'),
            'rate' => $this->request->getPost('rate'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/interest-rates');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/interest-rates');
    }
}