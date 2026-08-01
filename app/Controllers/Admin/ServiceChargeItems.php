<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceChargeItemsModel;

class ServiceChargeItems extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ServiceChargeItemsModel();
    }

    // List items, filtered by tab (default 'advances')
    public function index($tab = 'advances')
    {
        $data['items'] = $this->model
            ->where('tab', $tab)
            ->orderBy('section', 'asc')
            ->orderBy('sort_order', 'asc')
            ->findAll();

        $data['currentTab'] = $tab;

        // Provide list of available tabs for the admin view
        $data['tabs'] = [
            'advances' => 'Advances',
            'dd'       => 'DD / Pay Order',
            'cheque'   => 'Cheque & Passbook',
            'cash'     => 'Cash & ATM',
            'rtgs'     => 'RTGS / NEFT / OBC',
            'account'  => 'Account Services',
            'misc'     => 'Miscellaneous',
            'scheme'   => 'Scheme-wise Fees',
        ];

        return view('admin/service_charge_items/index', $data);
    }

    public function create()
    {
        return view('admin/service_charge_items/form');
    }

    public function store()
    {
        $rules = [
            'tab'      => 'required|max_length[50]',
            'section'  => 'required|max_length[255]',
            'type'     => 'required|in_list[row,three_col,sub_header,note,callout,scheme_row]',
            'label'    => 'permit_empty',
            'charge'   => 'permit_empty|max_length[255]',
            'description' => 'permit_empty',
            'sort_order' => 'permit_empty|integer',
            'status'   => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'tab'         => $this->request->getPost('tab'),
            'section'     => $this->request->getPost('section'),
            'type'        => $this->request->getPost('type'),
            'label'       => $this->request->getPost('label') ?? '',
            'charge'      => $this->request->getPost('charge') ?? '',
            'description' => $this->request->getPost('description') ?? '',
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Created', 'service_charge_items', $this->model->getInsertID());

        return redirect()->to('/admin/service-charge-items/' . $this->request->getPost('tab'))
            ->with('message', 'Charge item added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/service-charge-items')->with('error', 'Not found.');
        }
        return view('admin/service_charge_items/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'tab'      => 'required|max_length[50]',
            'section'  => 'required|max_length[255]',
            'type'     => 'required|in_list[row,three_col,sub_header,note,callout,scheme_row]',
            'label'    => 'permit_empty',
            'charge'   => 'permit_empty|max_length[255]',
            'description' => 'permit_empty',
            'sort_order' => 'permit_empty|integer',
            'status'   => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'tab'         => $this->request->getPost('tab'),
            'section'     => $this->request->getPost('section'),
            'type'        => $this->request->getPost('type'),
            'label'       => $this->request->getPost('label') ?? '',
            'charge'      => $this->request->getPost('charge') ?? '',
            'description' => $this->request->getPost('description') ?? '',
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Updated', 'service_charge_items', $id);

        return redirect()->to('/admin/service-charge-items/' . $this->request->getPost('tab'))
            ->with('message', 'Charge item updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        $tab  = $item['tab'] ?? 'advances';

        $this->model->delete($id);
        log_activity('Deleted', 'service_charge_items', $id);

        return redirect()->to('/admin/service-charge-items/' . $tab)
            ->with('message', 'Charge item deleted.');
    }
}