<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UpiItemModel;

class UpiItems extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpiItemModel();
    }

    public function index($tab = 'features')
    {
        $data['items'] = $this->model
            ->where('tab', $tab)
            ->orderBy('section', 'asc')
            ->orderBy('sort_order', 'asc')
            ->findAll();
        $data['currentTab'] = $tab;
        $data['tabs'] = ['features' => 'Features', 'eligibility' => 'Eligibility', 'transactions' => 'Transactions'];
        return view('admin/upi_items/index', $data);
    }

    public function create()
    {
        return view('admin/upi_items/form');
    }

    public function store()
    {
        $rules = [
            'tab'         => 'required|max_length[50]',
            'section'     => 'required|max_length[100]',
            'type' => 'required|in_list[card,checklist,detail,stat]',
            'icon'        => 'permit_empty|max_length[50]',
            'title'       => 'permit_empty|max_length[255]',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->model->insert([
            'tab'         => $this->request->getPost('tab'),
            'section'     => $this->request->getPost('section'),
            'type'        => $this->request->getPost('type'),
            'icon'        => $this->request->getPost('icon') ?? '',
            'title'       => $this->request->getPost('title') ?? '',
            'description' => $this->request->getPost('description') ?? '',
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Created', 'upi_items', $this->model->getInsertID());
        return redirect()->to('/admin/upi-items/' . $this->request->getPost('tab'))->with('message', 'Item added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/upi-items')->with('error', 'Not found.');
        return view('admin/upi_items/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'tab'         => 'required|max_length[50]',
            'section'     => 'required|max_length[100]',
            'type' => 'required|in_list[card,checklist,detail,stat]',
            'icon'        => 'permit_empty|max_length[50]',
            'title'       => 'permit_empty|max_length[255]',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->model->update($id, [
            'tab'         => $this->request->getPost('tab'),
            'section'     => $this->request->getPost('section'),
            'type'        => $this->request->getPost('type'),
            'icon'        => $this->request->getPost('icon') ?? '',
            'title'       => $this->request->getPost('title') ?? '',
            'description' => $this->request->getPost('description') ?? '',
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'upi_items', $id);
        return redirect()->to('/admin/upi-items/' . $this->request->getPost('tab'))->with('message', 'Item updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        $tab  = $item['tab'] ?? 'features';
        $this->model->delete($id);
        return redirect()->to('/admin/upi-items/' . $tab)->with('message', 'Item deleted.');
    }
}