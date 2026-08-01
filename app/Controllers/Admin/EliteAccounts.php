<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EliteAccountModel;
use App\Models\EliteAccountFeatureModel;

class EliteAccounts extends BaseController
{
    protected $model;
    protected $featureModel;

    public function __construct()
    {
        $this->model = new EliteAccountModel();
        $this->featureModel = new EliteAccountFeatureModel();
    }

    public function index()
    {
        $accounts = $this->model->orderBy('sort_order', 'asc')->findAll();
        foreach ($accounts as &$acc) {
            $acc['features'] = $this->featureModel
                ->where('elite_account_id', $acc['id'])
                ->orderBy('sort_order', 'asc')
                ->findColumn('feature') ?? [];
        }
        $data['items'] = $accounts;
        return view('admin/elite_accounts/index', $data);
    }

    public function create()
    {
        return view('admin/elite_accounts/form');
    }

    public function store()
    {
        $rules = [
            'badge_text'        => 'permit_empty|max_length[100]',
            'badge_icon'        => 'permit_empty|max_length[50]',
            'heading'           => 'required|max_length[255]',
            'description'       => 'required',
            'features'          => 'required',
            'sort_order'        => 'permit_empty|integer',
            'status'            => 'permit_empty|integer',
            'show_in_frontend'  => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle PDF upload
        $formPdf = null;
        $file = $this->request->getFile('form_pdf');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/forms/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);
            $newName = time() . '_' . $file->getRandomName();
            $file->move($uploadPath, $newName);
            $formPdf = 'uploads/forms/' . $newName;
        }

        $id = $this->model->insert([
            'badge_text'        => $this->request->getPost('badge_text'),
            'badge_icon'        => $this->request->getPost('badge_icon'),
            'heading'           => $this->request->getPost('heading'),
            'description'       => $this->request->getPost('description'),
            'form_pdf'          => $formPdf,
            'sort_order'        => $this->request->getPost('sort_order') ?? 0,
            'status'            => $this->request->getPost('status') ?? 1,
            'show_in_frontend'  => $this->request->getPost('show_in_frontend') ?? 1,
        ]);

        if (!$id) {
            return redirect()->back()->withInput()->with('error', 'Failed to add elite account.');
        }

        // Save features
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'elite_account_id' => $id,
                'feature'          => $feature,
                'sort_order'       => $order++,
            ]);
        }

        log_activity('Created', 'elite_accounts', $id);
        return redirect()->to('/admin/elite-accounts')->with('message', 'Elite account added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/elite-accounts')->with('error', 'Not found.');

        $features = $this->featureModel
            ->where('elite_account_id', $id)
            ->orderBy('sort_order', 'asc')
            ->findAll();
        $featuresText = implode("\n", array_column($features, 'feature'));

        $data['item'] = $item;
        $data['featuresText'] = $featuresText;
        return view('admin/elite_accounts/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'badge_text'        => 'permit_empty|max_length[100]',
            'badge_icon'        => 'permit_empty|max_length[50]',
            'heading'           => 'required|max_length[255]',
            'description'       => 'required',
            'features'          => 'required',
            'sort_order'        => 'permit_empty|integer',
            'status'            => 'permit_empty|integer',
            'show_in_frontend'  => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        if (!$item) return redirect()->back()->with('error', 'Account not found.');

        $data = [
            'badge_text'        => $this->request->getPost('badge_text'),
            'badge_icon'        => $this->request->getPost('badge_icon'),
            'heading'           => $this->request->getPost('heading'),
            'description'       => $this->request->getPost('description'),
            'sort_order'        => $this->request->getPost('sort_order') ?? 0,
            'status'            => $this->request->getPost('status') ?? 1,
            'show_in_frontend'  => $this->request->getPost('show_in_frontend') ?? 1,
        ];

        // Handle PDF upload
        $file = $this->request->getFile('form_pdf');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/forms/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);
            $newName = time() . '_' . $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['form_pdf'] = 'uploads/forms/' . $newName;

            // Delete old file
            $oldPath = $item['form_pdf'] ?? '';
            if ($oldPath && file_exists(FCPATH . $oldPath)) {
                @unlink(FCPATH . $oldPath);
            }
        } else {
            $data['form_pdf'] = $item['form_pdf'] ?? null;
        }

        $this->model->update($id, $data);

        // Update features
        $this->featureModel->where('elite_account_id', $id)->delete();
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'elite_account_id' => $id,
                'feature'          => $feature,
                'sort_order'       => $order++,
            ]);
        }

        log_activity('Updated', 'elite_accounts', $id);
        return redirect()->to('/admin/elite-accounts')->with('message', 'Elite account updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['form_pdf']) && file_exists(FCPATH . $item['form_pdf'])) {
            @unlink(FCPATH . $item['form_pdf']);
        }

        $this->featureModel->where('elite_account_id', $id)->delete();
        $this->model->delete($id);
        log_activity('Deleted', 'elite_accounts', $id);
        return redirect()->to('/admin/elite-accounts')->with('message', 'Elite account deleted.');
    }
}