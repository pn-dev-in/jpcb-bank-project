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
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll() ?? [];
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
            'unique_id'  => 'permit_empty|max_length[50]|is_unique[atm_locations.unique_id]',
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
            'unique_id'  => $this->request->getPost('unique_id'),
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'atm_locations', $id);
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
            'unique_id'  => "permit_empty|max_length[50]|is_unique[atm_locations.unique_id,id,{$id}]",
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
            'unique_id'  => $this->request->getPost('unique_id'),
        ]);
        log_activity('Updated', 'atm_locations', $id);
        return redirect()->to('/admin/atm-locations')->with('message', 'ATM location updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'atm_locations', $id);
        return redirect()->to('/admin/atm-locations')->with('message', 'ATM location deleted.');
    }

    public function import()
    {
        return view('admin/atm_locations/import');
    }

    public function processImport()
    {
        $file = $this->request->getFile('csv_file');
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Please upload a valid CSV file.');
        }

        $extension = $file->getExtension();
        if (!in_array(strtolower($extension), ['csv'])) {
            return redirect()->back()->with('error', 'Only CSV files are allowed.');
        }

        $handle = fopen($file->getTempName(), 'r');
        $headers = fgetcsv($handle);

        // Expected headers (case-insensitive)
        $required = ['name', 'city', 'area', 'pin', 'hours', 'atm_status', 'sort_order', 'status', 'unique_id'];
        $headerMap = [];
        foreach ($headers as $index => $col) {
            $colClean = strtolower(trim($col));
            if (in_array($colClean, $required)) {
                $headerMap[$colClean] = $index;
            }
        }

        $missing = array_diff($required, array_keys($headerMap));
        if (!empty($missing)) {
            fclose($handle);
            return redirect()->back()->with('error', 'CSV missing columns: ' . implode(', ', $missing));
        }

        $inserted = 0;
        $updated = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            $data = [];
            foreach ($required as $field) {
                $value = trim($row[$headerMap[$field]] ?? '');
                if ($field === 'pin') {
                    $value = $value ?: null;
                } elseif ($field === 'sort_order') {
                    $value = is_numeric($value) ? (int)$value : 0;
                } elseif ($field === 'status') {
                    $value = (strtolower($value) === 'active' || $value == 1) ? 1 : 0;
                } elseif ($field === 'atm_status') {
                    $value = ($value === 'Active' || $value === 'Maintenance') ? $value : 'Active';
                }
                // For unique_id, keep as is (allow empty)
                $data[$field] = $value;
            }

            if (empty($data['name']) || empty($data['city'])) {
                $errors[] = "Skipped row: Name and City are required.";
                continue;
            }

            // Check existence by unique_id or name+city
            $exists = null;
            if (!empty($data['unique_id'])) {
                $exists = $this->model->where('unique_id', $data['unique_id'])->first();
            }
            if (!$exists) {
                $exists = $this->model->where('name', $data['name'])->where('city', $data['city'])->first();
            }

            if ($exists) {
                // Don't overwrite existing unique_id if it's already set and we didn't provide a new one
                if (empty($data['unique_id'])) {
                    unset($data['unique_id']);
                }
                $this->model->update($exists['id'], $data);
                $inserted++;
            } else {
                $this->model->insert($data);
                $inserted++;
            }
        }

        fclose($handle);

        log_activity('Imported', 'atm_locations', null, ['inserted' => $inserted, 'updated' => $updated]);
        $message = "$inserted ATM locations processed successfully.";
        if (!empty($errors)) {
            $message .= ' Some rows skipped: ' . implode('; ', array_slice($errors, 0, 5));
        }
        return redirect()->to('/admin/atm-locations')->with('message', $message);
    }

    public function sampleCsv()
    {
        $filename = 'atm_locations_sample.csv';
        $handle = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        fputcsv($handle, ['name', 'city', 'area', 'pin', 'hours', 'atm_status', 'sort_order', 'status', 'unique_id']);
        fputcsv($handle, ['Head Office ATM', 'Jalgaon', 'Station Road', '425001', '24x7', 'Active', '1', 'Active', 'ATM-JPCB-001']);
        fputcsv($handle, ['Market Yard ATM', 'Jalgaon', 'Market Yard', '425001', '24x7', 'Active', '2', 'Active', 'ATM-JPCB-002']);
        fputcsv($handle, ['Bhusawal ATM', 'Bhusawal', 'Station Road', '425201', '24x7', 'Active', '3', 'Active', 'ATM-JPCB-003']);
        fclose($handle);
        exit;
    }
}