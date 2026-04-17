<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;

class ActivityLogController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ActivityLogModel();
    }

    public function index()
    {
        $data['logs'] = $this->model
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('admin/logs/index', $data);
    }
}