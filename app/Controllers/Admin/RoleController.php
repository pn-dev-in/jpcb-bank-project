<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;
use Config\PermissionModules;

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
        $this->roleModel->save(['name' => $this->request->getPost('name')]);
        $id = $this->roleModel->getInsertID();
        log_activity('Created', 'roles', $id);
        return redirect()->to('/admin/roles')->with('message', 'Role created Sucessfully');
    }

    public function edit($id)
    {
        $data['role'] = $this->roleModel->find($id);
        if (!$data['role']) {
            return redirect()->to('/admin/roles')->with('error', 'Role not found.');
        }
        return view('admin/roles/edit', $data);
    }

    public function update($id)
    {
        $this->roleModel->update($id, ['name' => $this->request->getPost('name')]);
        log_activity('Updated', 'roles', $id);
        return redirect()->to('/admin/roles')->with('message', 'Role updated.');
    }

    public function delete($id)
    {
        // Check if any admin uses this role
        $adminModel = new \App\Models\AdminModel();
        $count = $adminModel->where('role_id', $id)->countAllResults();
        if ($count > 0) {
            return redirect()->to('/admin/roles')->with('error', 'Cannot delete role because it is assigned to admins.');
        }
        $this->roleModel->delete($id);
        log_activity('Deleted', 'roles', $id);
        return redirect()->to('/admin/roles')->with('message', 'Role deleted.');
    }

    // Permission Matrix (Assign permissions to role)
    public function assign($role_id)
    {
        $role = $this->roleModel->find($role_id);
        if (!$role) {
            log_activity('Assigned', 'role permissions', $role_id);
            return redirect()->to('/admin/roles')->with('error', 'Role not found.');
        }

        // Get all permissions from database
        $allPermissions = $this->permissionModel->findAll();

        // Group permissions by module and action
        $permissionsByModule = [];
        foreach ($allPermissions as $perm) {
            $parts = explode('.', $perm['name'], 2);
            $module = $parts[0];
            $action = $parts[1] ?? 'view';
            $permissionsByModule[$module][$action] = $perm['id'];
        }

        // Get currently assigned permissions for this role
        $assigned = $this->rpModel->where('role_id', $role_id)->findColumn('permission_id') ?? [];

        $data = [
            'role' => $role,
            'modules' => PermissionModules::$modules,
            'actions' => PermissionModules::$actions,
            'permissionsByModule' => $permissionsByModule,
            'assigned' => $assigned,
        ];
        return view('admin/roles/permission_matrix', $data);
    }

    public function savePermissions($role_id)
    {
        $permissions = $this->request->getPost('permissions');
        if (!is_array($permissions)) {
            $permissions = [];
        }

        // Delete old assignments
        $this->rpModel->where('role_id', $role_id)->delete();

        // Insert new assignments
        foreach ($permissions as $permId) {
            $this->rpModel->insert([
                'role_id' => $role_id,
                'permission_id' => (int)$permId,
            ]);
        }
        log_activity('Updated', 'roles permissions', $role_id);
        return redirect()->to('/admin/roles')->with('message', 'Permissions updated for role.');
    }
}