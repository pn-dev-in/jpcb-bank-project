<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AtmLocationModel;

class AtmLocations extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AtmLocationModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/atm_locations/index', $data);
    }

    public function create()
    {
        return view('admin/atm_locations/form');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'city'       => 'required|max_length[100]',
            'area'       => 'permit_empty|max_length[100]',
            'pin'        => 'permit_empty|max_length[10]',
            'hours'      => 'permit_empty|max_length[50]',
            'atm_status' => 'permit_empty|max_length[20]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'city'       => $this->request->getPost('city'),
            'area'       => $this->request->getPost('area'),
            'pin'        => $this->request->getPost('pin'),
            'hours'      => $this->request->getPost('hours') ?? '24x7',
            'atm_status' => $this->request->getPost('atm_status') ?? 'Active',
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/atm-locations')->with('message', 'ATM location added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/atm-locations')->with('error', 'Not found.');
        return view('admin/atm_locations/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required|max_length[150]',
            'city'       => 'required|max_length[100]',
            'area'       => 'permit_empty|max_length[100]',
            'pin'        => 'permit_empty|max_length[10]',
            'hours'      => 'permit_empty|max_length[50]',
            'atm_status' => 'permit_empty|max_length[20]',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'city'       => $this->request->getPost('city'),
            'area'       => $this->request->getPost('area'),
            'pin'        => $this->request->getPost('pin'),
            'hours'      => $this->request->getPost('hours') ?? '24x7',
            'atm_status' => $this->request->getPost('atm_status') ?? 'Active',
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/atm-locations')->with('message', 'ATM location updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/atm-locations')->with('message', 'ATM location deleted.');
    }
}