<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BranchModel;

class BranchController extends BaseController
{
    protected $branchModel;

    public function __construct()
    {
        $this->branchModel = new BranchModel();
    }

    public function index()
    {
        $data['branches'] = $this->branchModel->findAll() ?? [];
        return view('admin/branches/index', $data);
    }

    public function create()
    {
        return view('admin/branches/create');
    }

    public function store()
    {
        // Convert services (comma separated) to JSON
        $servicesInput = $this->request->getPost('services');
        $servicesArray = array_map('trim', explode(',', $servicesInput));
        $servicesJson = json_encode($servicesArray);

        $this->branchModel->save([
            'branch_name' => $this->request->getPost('branch_name'),
            'address'     => $this->request->getPost('address'),
            'area'        => $this->request->getPost('area'),
            'city'        => $this->request->getPost('city'),
            'pincode'     => $this->request->getPost('pincode'),
            'ifsc'        => $this->request->getPost('ifsc'),
            'micr'        => $this->request->getPost('micr'),
            'phone'       => $this->request->getPost('phone'),
            'timings'     => $this->request->getPost('timings'),
            'services'    => $servicesJson,
            'has_atm'     => $this->request->getPost('has_atm') ? 1 : 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->branchModel->getInsertID();
        log_activity('Created', 'branches', $id);
        return redirect()->to('/admin/branches')->with('message', 'Branch added successfully.');
    }

    public function edit($id)
    {
        $data['branch'] = $this->branchModel->find($id);
        if (!$data['branch']) {
            return redirect()->to('/admin/branches')->with('error', 'Branch not found.');
        }
        return view('admin/branches/edit', $data);
    }

    public function update($id)
    {
        $servicesInput = $this->request->getPost('services');
        $servicesArray = array_map('trim', explode(',', $servicesInput));
        $servicesJson = json_encode($servicesArray);

        $this->branchModel->update($id, [
            'branch_name' => $this->request->getPost('branch_name'),
            'address'     => $this->request->getPost('address'),
            'area'        => $this->request->getPost('area'),
            'city'        => $this->request->getPost('city'),
            'pincode'     => $this->request->getPost('pincode'),
            'ifsc'        => $this->request->getPost('ifsc'),
            'micr'        => $this->request->getPost('micr'),
            'phone'       => $this->request->getPost('phone'),
            'timings'     => $this->request->getPost('timings'),
            'services'    => $servicesJson,
            'has_atm'     => $this->request->getPost('has_atm') ? 1 : 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'branches', $id);
        return redirect()->to('/admin/branches')->with('message', 'Branch updated successfully.');
    }

    public function delete($id)
    {
        $this->branchModel->delete($id);
        log_activity('Deleted', 'branches', $id);
        return redirect()->to('/admin/branches')->with('message', 'Branch deleted.');
    }
}
