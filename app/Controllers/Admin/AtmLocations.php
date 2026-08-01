<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AtmLocationModel;
use PhpOffice\PhpSpreadsheet\Reader\Csv as CsvReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

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
            'name' => 'required|max_length[150]',
            'city' => 'required|max_length[100]',
            'area' => 'permit_empty|max_length[100]',
            'pin' => 'permit_empty|max_length[10]',
            'hours' => 'permit_empty|max_length[50]',
            'atm_status' => 'permit_empty|max_length[20]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer',
            'unique_id' => 'permit_empty|max_length[50]|is_unique[atm_locations.unique_id]',
            'latitude' => 'permit_empty|decimal',
            'longitude' => 'permit_empty|decimal',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'area' => $this->request->getPost('area'),
            'pin' => $this->request->getPost('pin'),
            'latitude' => $this->request->getPost('latitude') ?: null,
            'longitude' => $this->request->getPost('longitude') ?: null,
            'hours' => $this->request->getPost('hours') ?? '24x7',
            'location_type' => $this->request->getPost('location_type') ?? 'On Site',
            'atm_status' => $this->request->getPost('atm_status') ?? 'Active',
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1,
            'unique_id' => $this->request->getPost('unique_id'),
        ]);
        $id = $this->model->getInsertID();
        log_activity('Created', 'atm_locations', $id);
        return redirect()->to('/admin/atm-locations')->with('success', 'ATM location added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/atm-locations')->with('error', 'Not found.');
        }
        return view('admin/atm_locations/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required|max_length[150]',
            'city' => 'required|max_length[100]',
            'area' => 'permit_empty|max_length[100]',
            'pin' => 'permit_empty|max_length[10]',
            'hours' => 'permit_empty|max_length[50]',
            'atm_status' => 'permit_empty|max_length[20]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer',
            'unique_id' => "permit_empty|max_length[50]|is_unique[atm_locations.unique_id,id,{$id}]",
            'latitude' => 'permit_empty|decimal',
            'longitude' => 'permit_empty|decimal',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'area' => $this->request->getPost('area'),
            'pin' => $this->request->getPost('pin'),
            'latitude' => $this->request->getPost('latitude') ?: null,
            'longitude' => $this->request->getPost('longitude') ?: null,
            'hours' => $this->request->getPost('hours') ?? '24x7',
            'location_type' => $this->request->getPost('location_type') ?? 'On Site',
            'atm_status' => $this->request->getPost('atm_status') ?? 'Active',
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1,
            'unique_id' => $this->request->getPost('unique_id'),
        ]);
        log_activity('Updated', 'atm_locations', $id);
        return redirect()->to('/admin/atm-locations')->with('success', 'ATM location updated.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        log_activity('Deleted', 'atm_locations', $id);
        return redirect()->to('/admin/atm-locations')->with('success', 'ATM location deleted.');
    }

    public function import()
    {
        return view('admin/atm_locations/import');
    }

    public function processImport()
{
    $file = $this->request->getFile('import_file');
    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'Please upload a valid Excel file.');
    }

    $extension = strtolower($file->getExtension());
    if ($extension !== 'xlsx') {
        return redirect()->back()->with('error', 'Only .xlsx files are allowed.');
    }

    require_once ROOTPATH . 'vendor/autoload.php';
    $xlsx = \Shuchkin\SimpleXLSX::parse($file->getTempName());
    if (!$xlsx) {
        return redirect()->back()->with('error', 'Failed to parse Excel: ' . \Shuchkin\SimpleXLSX::parseError());
    }

    // 1. Read "ATM Details" sheet
    $atmSheet = $xlsx->rows(3);
    array_shift($atmSheet); array_shift($atmSheet); array_shift($atmSheet);
    $atmRows = [];
    foreach ($atmSheet as $row) {
        if (empty($row[1])) continue;
        $atmRows[] = [
            'branch_name'   => trim($row[1]),
            'atm_address'   => trim($row[2]),
            'location_type' => trim($row[3]),
        ];
    }

    // 2. Read "LAT AND LONGI" sheet
    $coordSheet = $xlsx->rows(1);
    array_shift($coordSheet);
    $coordMap = [];
    foreach ($coordSheet as $row) {
        $branchName = trim(strtoupper($row[1] ?? ''));
        if (!$branchName) continue;
        $latLon = explode(',', $row[2] ?? '');
        $coordMap[$branchName] = [
            'latitude'  => trim($latLon[0] ?? ''),
            'longitude' => trim($latLon[1] ?? ''),
            'city'      => trim($row[4] ?? ''),
            'pincode'   => trim($row[8] ?? ''),
        ];
    }

    $inserted = 0;
    $updated = 0;
    $errors = [];

    foreach ($atmRows as $idx => $atm) {
        $branchKey = strtoupper($atm['branch_name']);
        $coord = $coordMap[$branchKey] ?? [];

        $city = $coord['city'] ?? 'Jalgaon';
        if (empty($city)) $city = 'Jalgaon';

        // Prepare data WITHOUT unique_id
        $data = [
            'name'          => $atm['branch_name'],
            'address'       => $atm['atm_address'],
            'city'          => $city,
            'area'          => '',
            'pin'           => $coord['pincode'] ?? null,
            'latitude'      => !empty($coord['latitude']) ? (float)$coord['latitude'] : null,
            'longitude'     => !empty($coord['longitude']) ? (float)$coord['longitude'] : null,
            'hours'         => '24x7',
            'location_type' => ($atm['location_type'] === 'Off Site') ? 'Off Site' : 'On Site',
            'atm_status'    => 'Active',
            'sort_order'    => $idx,
            'status'        => 1,
            // unique_id is NOT set here
        ];

        // Check if record already exists (by name + city)
        $existing = $this->model->where('name', $data['name'])->where('city', $data['city'])->first();
        if ($existing) {
            // Update: remove unique_id from the data array to keep the existing one
            unset($data['unique_id']);
            $this->model->update($existing['id'], $data);
            $updated++;
        } else {
            // Insert new record – unique_id will be NULL (allowed by DB)
            $this->model->insert($data);
            $inserted++;
        }
    }

    log_activity('Imported', 'atm_locations', null);
    $message = "Import completed: $inserted inserted, $updated updated.";
    if (!empty($errors)) {
        $message .= ' Warnings: ' . implode('; ', array_slice($errors, 0, 5));
    }
    return redirect()->to('/admin/atm-locations')->with('success', $message);
}

    public function sampleCsv()
    {
        $filename = 'atm_locations_sample.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['name', 'address', 'city', 'area', 'pin', 'latitude', 'longitude', 'hours', 'location_type', 'atm_status', 'sort_order', 'status', 'unique_id']);
        fputcsv($handle, ['Head Office ATM', '152, Polan Peth, Dana Bazar', 'Jalgaon', 'Station Road', '425001', '21.014210', '75.569012', '24x7', 'On Site', 'Active', '1', 'Active', 'ATM-JPCB-001']);
        fputcsv($handle, ['Market Yard ATM', 'Near Krushi Utpanna Bazar Samiti', 'Jalgaon', 'Market Yard', '425001', '20.998515', '75.579816', '24x7', 'On Site', 'Active', '2', 'Active', 'ATM-JPCB-002']);
        fclose($handle);
        exit;
    }
}