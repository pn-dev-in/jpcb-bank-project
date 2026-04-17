<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\RoleModel;

class AdminUserController extends BaseController
{
    protected $model;
    protected $roleModel;

    public function __construct()
    {
        $this->model = new AdminModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        $data['admins'] = $this->model
            ->select('admins.*, roles.name as role_name')
            ->join('roles', 'roles.id = admins.role_id', 'left')
            ->findAll();

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data['roles'] = $this->roleModel->findAll();
        return view('admin/users/create', $data);
    }

    public function store()
    {
        $this->model->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id' => $this->request->getPost('role_id'),
        ]);

        return redirect()->to('/admin/users');
    }
}