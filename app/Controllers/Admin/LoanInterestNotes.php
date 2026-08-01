<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanInterestNoteModel;

class LoanInterestNotes extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new LoanInterestNoteModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/loan_interest_notes/index', $data);
    }

    public function create()
    {
        return view('admin/loan_interest_notes/form');
    }

    public function store()
    {
        $rules = [
            'note'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'note'       => $this->request->getPost('note'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        if ($id) {
            log_activity('Created', 'loan_interest_notes', $id);
            return redirect()->to('/admin/loan-interest-notes')->with('success', 'Note added.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add note.');
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/loan-interest-notes')->with('error', 'Note not found.');
        return view('admin/loan_interest_notes/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'note'       => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updated = $this->model->update($id, [
            'note'       => $this->request->getPost('note'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        if ($updated) {
            log_activity('Updated', 'loan_interest_notes', $id);
            return redirect()->to('/admin/loan-interest-notes')->with('success', 'Note updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update note.');
        }
    }

    public function delete($id)
    {
        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'loan_interest_notes', $id);
            return redirect()->to('/admin/loan-interest-notes')->with('success', 'Note deleted.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete note.');
        }
    }
}