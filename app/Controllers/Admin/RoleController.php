<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $rpModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->rpModel = new RolePermissionModel();
    }

    public function index()
    {
        $data['roles'] = $this->roleModel->findAll();
        return view('admin/roles/index', $data);
    }

    public function create()
    {
        return view('admin/roles/create');
    }

    public function store()
    {
        $this->roleModel->save([
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to('/admin/roles');
    }

    public function assign($role_id)
    {
        $data['role'] = $this->roleModel->find($role_id);
        $data['permissions'] = $this->permissionModel->findAll();

        return view('admin/roles/assign', $data);
    }

    public function savePermissions($role_id)
    {
        $permissions = $this->request->getPost('permissions');

        $this->rpModel->where('role_id', $role_id)->delete();

        if ($permissions) {
            foreach ($permissions as $pid) {
                $this->rpModel->insert([
                    'role_id' => $role_id,
                    'permission_id' => $pid
                ]);
            }
        }

        return redirect()->to('/admin/roles');
    }
}