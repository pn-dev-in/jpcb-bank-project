<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BranchModel;

class BranchController extends BaseController
{
    protected $branchModel;

    public function __construct()
    {
        $this->branchModel = new BranchModel();
    }

    public function index()
    {
        $data['branches'] = $this->branchModel->findAll() ?? [];
        return view('admin/branches/index', $data);
    }

    public function create()
    {
        return view('admin/branches/create');
    }

    public function store()
    {
        // Convert services (comma separated) to JSON
        $servicesInput = $this->request->getPost('services');
        $servicesArray = array_map('trim', explode(',', $servicesInput));
        $servicesJson = json_encode($servicesArray);

        $this->branchModel->save([
            'branch_name' => $this->request->getPost('branch_name'),
            'address' => $this->request->getPost('address'),
            'area' => $this->request->getPost('area'),
            'city' => $this->request->getPost('city'),
            'pincode' => $this->request->getPost('pincode'),
            'ifsc' => $this->request->getPost('ifsc'),
            'micr' => $this->request->getPost('micr'),
            'phone' => $this->request->getPost('phone'),
            'timings' => $this->request->getPost('timings'),
            'services' => $servicesJson,
            'has_atm' => $this->request->getPost('has_atm') ? 1 : 0,
            'status' => $this->request->getPost('status') ?? 1,
        ]);
        $id = $this->branchModel->getInsertID();
        log_activity('Created', 'branches', $id);
        return redirect()->to('/admin/branches')->with('message', 'Branch added successfully.');
    }

    public function edit($id)
    {
        $data['branch'] = $this->branchModel->find($id);
        if (!$data['branch']) {
            return redirect()->to('/admin/branches')->with('error', 'Branch not found.');
        }
        return view('admin/branches/edit', $data);
    }

    public function update($id)
    {
        $servicesInput = $this->request->getPost('services');
        $servicesArray = array_map('trim', explode(',', $servicesInput));
        $servicesJson = json_encode($servicesArray);

        $this->branchModel->update($id, [
            'branch_name' => $this->request->getPost('branch_name'),
            'address' => $this->request->getPost('address'),
            'area' => $this->request->getPost('area'),
            'city' => $this->request->getPost('city'),
            'pincode' => $this->request->getPost('pincode'),
            'ifsc' => $this->request->getPost('ifsc'),
            'micr' => $this->request->getPost('micr'),
            'phone' => $this->request->getPost('phone'),
            'timings' => $this->request->getPost('timings'),
            'services' => $servicesJson,
            'has_atm' => $this->request->getPost('has_atm') ? 1 : 0,
            'status' => $this->request->getPost('status') ?? 1,
        ]);
        log_activity('Updated', 'branches', $id);
        return redirect()->to('/admin/branches')->with('message', 'Branch updated successfully.');
    }

    public function delete($id)
    {
        $this->branchModel->delete($id);
        log_activity('Deleted', 'branches', $id);
        return redirect()->to('/admin/branches')->with('message', 'Branch deleted.');
    }

    public function import()
    {   
        if (!has_permission('branches.import')) {
        return redirect()->back()->with('error', 'You do not have permission to import branches.');
    }
        return view('admin/branches/import');
    }

    public function processImport()
    {   
        if (!has_permission('branches.import')) {
        return redirect()->back()->with('error', 'Permission denied.');
    }
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

        $rows = $xlsx->rows();
        $headers = array_map('strtolower', array_map('trim', $rows[0]));

        // Build a map that stores all indices for duplicate headers
        $headerMap = [];
        foreach ($headers as $idx => $col) {
            if (!isset($headerMap[$col])) {
                $headerMap[$col] = [];
            }
            $headerMap[$col][] = $idx;
        }

        // Check required columns
        $requiredCols = ['branch name', 'ifsc code', 'branch addresses'];
        foreach ($requiredCols as $col) {
            if (!isset($headerMap[$col])) {
                return redirect()->back()->with('error', "Missing required column: '$col'");
            }
        }

        // Get indices for the two timing columns (duplicate header)
        $timingStartIdx = null;
        $timingEndIdx = null;
        if (isset($headerMap['branch timing from'])) {
            $indices = $headerMap['branch timing from'];
            $timingStartIdx = $indices[0] ?? null;
            $timingEndIdx = $indices[1] ?? null;
        }

        // For other columns, use the first occurrence
        $colMap = [];
        foreach ($headers as $idx => $col) {
            if (!isset($colMap[$col])) {
                $colMap[$col] = $idx;
            }
        }

        $inserted = 0;
        $updated = 0;
        $errors = [];

        // Remove header row
        array_shift($rows);

        foreach ($rows as $rowIndex => $row) {
            if (empty(array_filter($row)))
                continue;

            // Combine timings
            $timingStart = ($timingStartIdx !== null) ? trim($row[$timingStartIdx] ?? '') : '';
            $timingEnd = ($timingEndIdx !== null) ? trim($row[$timingEndIdx] ?? '') : '';
            $timings = $timingStart . ' – ' . $timingEnd;
            if (trim($timings) === ' – ') {
                $timings = null;
            }

            $data = [
                'branch_name' => trim($row[$colMap['branch name']] ?? ''),
                'centre_name' => trim($row[$colMap['centre name']] ?? ''),
                'address' => trim($row[$colMap['branch addresses']] ?? ''),
                'city' => trim($row[$colMap['centre name']] ?? ''),
                'district' => trim($row[$colMap['district name']] ?? ''),
                'sub_district' => trim($row[$colMap['sub district name']] ?? ''),
                'pincode' => trim($row[$colMap['pincode']] ?? ''),
                'state' => trim($row[$colMap['state name']] ?? ''),
                'ifsc' => trim($row[$colMap['ifsc code']] ?? ''),
                'micr' => trim($row[$colMap['(micr ) code']] ?? ''),
                'branch_code' => trim($row[$colMap['branch code']] ?? ''),
                'bank_category' => trim($row[$colMap['bank branch catagory']] ?? ''),
                'latitude' => is_numeric(trim($row[$colMap['latitude']] ?? '')) ? (float) trim($row[$colMap['latitude']]) : null,
                'longitude' => is_numeric(trim($row[$colMap['longitude']] ?? '')) ? (float) trim($row[$colMap['longitude']]) : null,
                'phone' => trim($row[$colMap['telephone nos.']] ?? ''),
                'email' => trim($row[$colMap['email']] ?? ''),
                'timings' => $timings,
                'date_of_opening' => !empty($row[$colMap['date of opening']]) ? date('Y-m-d', strtotime($row[$colMap['date of opening']])) : null,
                'has_atm' => 0,
                'status' => 1,
                'services' => null,
            ];

            if (empty($data['branch_name']) || empty($data['ifsc'])) {
                $errors[] = "Row " . ($rowIndex + 2) . " skipped: Branch name or IFSC missing.";
                continue;
            }

            $existing = $this->branchModel->where('ifsc', $data['ifsc'])->first();
            if ($existing) {
                $this->branchModel->update($existing['id'], $data);
                $updated++;
            } else {
                $this->branchModel->insert($data);
                $inserted++;
            }
        }

        log_activity('Imported', 'branches', null);
        $message = "Import completed: $inserted inserted, $updated updated.";
        if (!empty($errors)) {
            $message .= ' Warnings: ' . implode('; ', array_slice($errors, 0, 5));
        }
        return redirect()->to('/admin/branches')->with('success', $message);
    }
}
