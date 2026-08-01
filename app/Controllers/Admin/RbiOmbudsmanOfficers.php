<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RbiOmbudsmanOfficerModel;

class RbiOmbudsmanOfficers extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new RbiOmbudsmanOfficerModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/rbi_ombudsman_officers/index', $data);
    }

    public function create()
    {
        return view('admin/rbi_ombudsman_officers/form');
    }

    public function store()
    {
        $rules = [
            'title'          => 'permit_empty|max_length[255]',
            'officer_name'   => 'permit_empty|max_length[255]',
            'designation'    => 'permit_empty|max_length[255]',
            'office_address' => 'permit_empty',
            'phone'          => 'permit_empty|max_length[100]',
            'fax'            => 'permit_empty|max_length[100]',
            'email'          => 'permit_empty|max_length[255]|valid_email',
            'website'        => 'permit_empty|max_length[255]',
            'sort_order'     => 'permit_empty|integer',
            'status'         => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'title'          => $this->request->getPost('title') ?? '',
            'officer_name'   => $this->request->getPost('officer_name') ?? '',
            'designation'    => $this->request->getPost('designation') ?? '',
            'office_address' => $this->request->getPost('office_address') ?? '',
            'phone'          => $this->request->getPost('phone') ?? '',
            'fax'            => $this->request->getPost('fax') ?? '',
            'email'          => $this->request->getPost('email') ?? '',
            'website'        => $this->request->getPost('website') ?? '',
            'sort_order'     => $this->request->getPost('sort_order') ?? 0,
            'status'         => $this->request->getPost('status') ?? 1,
        ]);

        $id = $this->model->getInsertID();
        log_activity('Created', 'rbi-ombudsman-officers', $id);
        return redirect()->to('/admin/rbi-ombudsman-officers')->with('message', 'Officer added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/rbi-ombudsman-officers')->with('error', 'Not found.');
        }
        return view('admin/rbi_ombudsman_officers/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'title'          => 'permit_empty|max_length[255]',
            'officer_name'   => 'permit_empty|max_length[255]',
            'designation'    => 'permit_empty|max_length[255]',
            'office_address' => 'permit_empty',
            'phone'          => 'permit_empty|max_length[100]',
            'fax'            => 'permit_empty|max_length[100]',
            'email'          => 'permit_empty|max_length[255]|valid_email',
            'website'        => 'permit_empty|max_length[255]',
            'sort_order'     => 'permit_empty|integer',
            'status'         => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'title'          => $this->request->getPost('title') ?? '',
            'officer_name'   => $this->request->getPost('officer_name') ?? '',
            'designation'    => $this->request->getPost('designation') ?? '',
            'office_address' => $this->request->getPost('office_address') ?? '',
            'phone'          => $this->request->getPost('phone') ?? '',
            'fax'            => $this->request->getPost('fax') ?? '',
            'email'          => $this->request->getPost('email') ?? '',
            'website'        => $this->request->getPost('website') ?? '',
            'sort_order'     => $this->request->getPost('sort_order') ?? 0,
            'status'         => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Updated', 'rbi-ombudsman-officers', $id);
        return redirect()->to('/admin/rbi-ombudsman-officers')->with('message', 'Officer updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'rbi-ombudsman-officers', $id);
        return redirect()->to('/admin/rbi-ombudsman-officers')->with('message', 'Officer deleted.');
    }
}