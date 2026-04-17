<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GrievanceStepModel;

class GrievanceSteps extends BaseController
{
    protected $stepModel;

    public function __construct()
    {
        $this->stepModel = new GrievanceStepModel();
    }

    public function index()
    {
        $steps = $this->stepModel->orderBy('step', 'asc')->findAll();
        return view('admin/grievance_steps/index', ['steps' => $steps]);
    }

    public function create()
    {
        return view('admin/grievance_steps/form');
    }

    public function store()
    {
        $rules = [
            'step'        => 'required|integer',
            'icon'        => 'required|max_length[50]',
            'title'       => 'required|max_length[255]',
            'description' => 'required',
            'timeline'    => 'required|max_length[100]',
            'action'      => 'required|max_length[255]',
            'href'        => 'required|max_length[255]',
            'external'    => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->stepModel->insert([
            'step'        => $this->request->getPost('step'),
            'icon'        => $this->request->getPost('icon'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'timeline'    => $this->request->getPost('timeline'),
            'action'      => $this->request->getPost('action'),
            'href'        => $this->request->getPost('href'),
            'external'    => $this->request->getPost('external') ?? 0,
        ]);

        return redirect()->to('/admin/grievance-steps')->with('message', 'Step added.');
    }

    public function edit($id)
    {
        $step = $this->stepModel->find($id);
        if (!$step) {
            return redirect()->to('/admin/grievance-steps')->with('error', 'Step not found.');
        }
        return view('admin/grievance_steps/form', ['step' => $step]);
    }

    public function update($id)
    {
        $rules = [
            'step'        => 'required|integer',
            'icon'        => 'required|max_length[50]',
            'title'       => 'required|max_length[255]',
            'description' => 'required',
            'timeline'    => 'required|max_length[100]',
            'action'      => 'required|max_length[255]',
            'href'        => 'required|max_length[255]',
            'external'    => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->stepModel->update($id, [
            'step'        => $this->request->getPost('step'),
            'icon'        => $this->request->getPost('icon'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'timeline'    => $this->request->getPost('timeline'),
            'action'      => $this->request->getPost('action'),
            'href'        => $this->request->getPost('href'),
            'external'    => $this->request->getPost('external') ?? 0,
        ]);

        return redirect()->to('/admin/grievance-steps')->with('message', 'Step updated.');
    }

    public function delete($id)
    {
        $this->stepModel->delete($id);
        return redirect()->to('/admin/grievance-steps')->with('message', 'Step deleted.');
    }
}