<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SavingsAccountModel;
use App\Models\SavingsAccountFeatureModel;

class SavingsAccounts extends BaseController
{
    protected $model;
    protected $featureModel;

    public function __construct()
    {
        $this->model = new SavingsAccountModel();
        $this->featureModel = new SavingsAccountFeatureModel();
    }

    public function index()
    {
        $accounts = $this->model->orderBy('sort_order', 'asc')->findAll();
        foreach ($accounts as &$acc) {
            $acc['features'] = $this->featureModel
                ->where('savings_account_id', $acc['id'])
                ->orderBy('sort_order', 'asc')
                ->findColumn('feature') ?? [];
        }
        $data['items'] = $accounts;
        return view('admin/savings_accounts/index', $data);
    }

    public function create()
    {
        return view('admin/savings_accounts/form');
    }

    public function store()
    {
        $rules = [
            'name'                  => 'required|max_length[150]',
            'badge_text'            => 'permit_empty|max_length[100]',
            'badge_icon'            => 'permit_empty|max_length[50]',
            'heading'               => 'required|max_length[255]',
            'description'           => 'required',
            'min_balance_individual'=> 'permit_empty|max_length[50]',
            'min_balance_trust'     => 'permit_empty|max_length[50]',
            'min_balance_salary'    => 'permit_empty|max_length[50]',
            'interest_rate_note'    => 'permit_empty|max_length[255]',
            'features'              => 'required',
            'sort_order'            => 'permit_empty|integer',
            'status'                => 'permit_empty|integer',
            'show_in_frontend'      => 'permit_empty|integer',
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
            'name'                  => $this->request->getPost('name'),
            'badge_text'            => $this->request->getPost('badge_text'),
            'badge_icon'            => $this->request->getPost('badge_icon'),
            'heading'               => $this->request->getPost('heading'),
            'description'           => $this->request->getPost('description'),
            'min_balance_individual'=> $this->request->getPost('min_balance_individual'),
            'min_balance_trust'     => $this->request->getPost('min_balance_trust'),
            'min_balance_salary'    => $this->request->getPost('min_balance_salary'),
            'interest_rate'         => $this->request->getPost('interest_rate'),
            'interest_rate_note'    => $this->request->getPost('interest_rate_note'),
            'form_pdf'              => $formPdf,
            'sort_order'            => $this->request->getPost('sort_order') ?? 0,
            'status'                => $this->request->getPost('status') ?? 1,
            'show_in_frontend'      => $this->request->getPost('show_in_frontend') ?? 1,
        ]);

        if (!$id) {
            return redirect()->back()->withInput()->with('error', 'Failed to add account.');
        }

        // Save features
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'savings_account_id' => $id,
                'feature'            => $feature,
                'sort_order'         => $order++,
            ]);
        }

        log_activity('Created', 'savings-accounts', $id);
        return redirect()->to('/admin/savings-accounts')->with('message', 'Savings account added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/savings-accounts')->with('error', 'Not found.');

        $features = $this->featureModel
            ->where('savings_account_id', $id)
            ->orderBy('sort_order', 'asc')
            ->findAll();
        $featuresText = implode("\n", array_column($features, 'feature'));

        $data['item'] = $item;
        $data['featuresText'] = $featuresText;
        return view('admin/savings_accounts/form', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'                  => 'required|max_length[150]',
            'badge_text'            => 'permit_empty|max_length[100]',
            'badge_icon'            => 'permit_empty|max_length[50]',
            'heading'               => 'required|max_length[255]',
            'description'           => 'required',
            'min_balance_individual'=> 'permit_empty|max_length[50]',
            'min_balance_trust'     => 'permit_empty|max_length[50]',
            'min_balance_salary'    => 'permit_empty|max_length[50]',
            'interest_rate_note'    => 'permit_empty|max_length[255]',
            'features'              => 'required',
            'sort_order'            => 'permit_empty|integer',
            'status'                => 'permit_empty|integer',
            'show_in_frontend'      => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        if (!$item) return redirect()->back()->with('error', 'Account not found.');

        $data = [
            'name'                  => $this->request->getPost('name'),
            'badge_text'            => $this->request->getPost('badge_text'),
            'badge_icon'            => $this->request->getPost('badge_icon'),
            'heading'               => $this->request->getPost('heading'),
            'description'           => $this->request->getPost('description'),
            'min_balance_individual'=> $this->request->getPost('min_balance_individual'),
            'min_balance_trust'     => $this->request->getPost('min_balance_trust'),
            'min_balance_salary'    => $this->request->getPost('min_balance_salary'),
            'interest_rate'         => $this->request->getPost('interest_rate'),
            'interest_rate_note'    => $this->request->getPost('interest_rate_note'),
            'sort_order'            => $this->request->getPost('sort_order') ?? 0,
            'status'                => $this->request->getPost('status') ?? 1,
            'show_in_frontend'      => $this->request->getPost('show_in_frontend') ?? 1,
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
        $this->featureModel->where('savings_account_id', $id)->delete();
        $features = explode("\n", str_replace("\r", "", $this->request->getPost('features')));
        $features = array_filter(array_map('trim', $features));
        $order = 0;
        foreach ($features as $feature) {
            $this->featureModel->insert([
                'savings_account_id' => $id,
                'feature'            => $feature,
                'sort_order'         => $order++,
            ]);
        }

        log_activity('Updated', 'savings-accounts', $id);
        return redirect()->to('/admin/savings-accounts')->with('message', 'Savings account updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item && !empty($item['form_pdf']) && file_exists(FCPATH . $item['form_pdf'])) {
            @unlink(FCPATH . $item['form_pdf']);
        }

        $this->featureModel->where('savings_account_id', $id)->delete();
        $this->model->delete($id);
        log_activity('Deleted', 'savings-accounts', $id);
        return redirect()->to('/admin/savings-accounts')->with('message', 'Savings account deleted.');
    }
}