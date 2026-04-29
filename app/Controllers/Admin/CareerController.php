<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CareerApplicationModel;

class CareerController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CareerApplicationModel();
    }

    public function index()
    {
        $data['applications'] = $this->model
            ->orderBy('id', 'DESC')
            ->findAll() ?? [];

        return view('admin/careers/index', $data);
    }

    public function delete($id)
    {
        // Check if application exists
        $application = $this->model->find($id);
        if (!$application) {
            return redirect()->to('/admin/careers')->with('error', 'Application not found.');
        }

        // Attempt deletion
        $deleted = $this->model->delete($id);
        if ($deleted) {
            log_activity('Deleted', 'careers', $id);
            return redirect()->to('/admin/careers')->with('success', 'Application deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete application.');
        }
    }
}