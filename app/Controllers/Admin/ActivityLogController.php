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
        $builder = $this->model->select('activity_logs.*, admins.name as admin_name')
            ->join('admins', 'admins.id = activity_logs.admin_id', 'left');

        if ($search = $this->request->getGet('search')) {
            $builder->groupStart()
                ->like('admins.name', $search)
                ->orLike('action', $search)
                ->orLike('module', $search)
                ->orLike('ip_address', $search)
                ->groupEnd();
        }
        if ($module = $this->request->getGet('module')) {
            $builder->where('module', $module);
        }
        if ($from = $this->request->getGet('from')) {
            $builder->where('activity_logs.created_at >=', $from);
        }
        if ($to = $this->request->getGet('to')) {
            $builder->where('activity_logs.created_at <=', $to . ' 23:59:59');
        }

         $data['search'] = $search;
        $data['module_filter'] = $module;
        $data['from_date'] = $from;
        $data['to_date'] = $to;

        $data['logs'] = $builder->orderBy('activity_logs.id', 'DESC')->paginate(50);
        $data['pager'] = $this->model->pager;
        $data['modules'] = $this->model->select('module')->distinct()->findAll();
        return view('admin/logs/index', $data);
    }
}