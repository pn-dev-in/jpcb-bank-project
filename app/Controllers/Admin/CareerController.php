<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CareerApplicationModel;

class CareerController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CareerApplicationModel();
    }

    public function index()
    {
        $data['applications'] = $this->model
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('admin/careers/index', $data);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/careers');
    }
}