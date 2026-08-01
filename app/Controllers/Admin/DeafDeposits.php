<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DeafDepositModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Csv as CsvReader;

class DeafDeposits extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeafDepositModel();
    }

    public function index()
    {
        $data['items'] = $this->model->orderBy('sort_order', 'asc')->findAll();
        return view('admin/deaf_deposits/index', $data);
    }

    public function create()
    {
        return view('admin/deaf_deposits/form');
    }

    public function store()
    {
        $rules = [
            'sr_no'      => 'required|integer',
            'udrn'       => 'required|is_unique[deaf_deposits.udrn]',
            'name'       => 'required|max_length[255]',
            'address'    => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'sr_no'      => $this->request->getPost('sr_no'),
            'udrn'       => $this->request->getPost('udrn'),
            'name'       => $this->request->getPost('name'),
            'address'    => $this->request->getPost('address'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        if ($id) {
            return redirect()->to('/admin/deaf-deposits')->with('success', 'DEAF deposit added.');
        }
        return redirect()->back()->withInput()->with('error', 'Failed to add.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) return redirect()->to('/admin/deaf-deposits')->with('error', 'Record not found.');
        return view('admin/deaf_deposits/form', ['item' => $item]);
    }

    public function update($id)
    {
        $rules = [
            'sr_no'      => 'required|integer',
            'udrn'       => "required|is_unique[deaf_deposits.udrn,id,{$id}]",
            'name'       => 'required|max_length[255]',
            'address'    => 'required',
            'sort_order' => 'permit_empty|integer',
            'status'     => 'permit_empty|integer',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updated = $this->model->update($id, [
            'sr_no'      => $this->request->getPost('sr_no'),
            'udrn'       => $this->request->getPost('udrn'),
            'name'       => $this->request->getPost('name'),
            'address'    => $this->request->getPost('address'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        if ($updated) {
            return redirect()->to('/admin/deaf-deposits')->with('success', 'DEAF deposit updated.');
        }
        return redirect()->back()->withInput()->with('error', 'Failed to update.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/deaf-deposits')->with('success', 'DEAF deposit deleted.');
    }
    

    public function import()
    {
        return view('admin/deaf_deposits/import');
    }

    public function processImport()
{
    $file = $this->request->getFile('import_file');
    
    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'Please upload a valid Excel or CSV file.');
    }

    $extension = strtolower($file->getExtension());
    
    if (!in_array($extension, ['xlsx', 'csv'])) {
        return redirect()->back()->with('error', 'Only .xlsx or .csv files are allowed.');
    }

    ini_set('memory_limit', '1024M');
    ini_set('max_execution_time', 300);

    require_once ROOTPATH . 'vendor/autoload.php';

    try {
        $db = \Config\Database::connect();
        
        // Get existing UDRNs
        $existing = $db->table('deaf_deposits')->select('udrn')->get()->getResultArray();
        $existingUdrns = array_column($existing, 'udrn');
        
        // Parse file
        if ($extension === 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getTempName());
            $rows = $spreadsheet->getActiveSheet()->toArray();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            $reader->setDelimiter(',');
            $spreadsheet = $reader->load($file->getTempName());
            $rows = $spreadsheet->getActiveSheet()->toArray();
        }
        
        array_shift($rows); // Remove header
        
        $inserted = 0;
        $skipped = 0;
        
        $db->transStart();
        
        foreach ($rows as $index => $row) {
            if (empty($row[0]) && empty($row[1])) {
                continue;
            }
            
            $sr_no = trim($row[0] ?? '');
            $udrn = trim($row[1] ?? '');
            $name = trim($row[2] ?? '');
            $address = trim($row[3] ?? '');
            
            if (empty($sr_no) || empty($udrn) || empty($name) || empty($address)) {
                $skipped++;
                continue;
            }
            
            if (in_array($udrn, $existingUdrns)) {
                $skipped++;
                continue;
            }
            
            $db->table('deaf_deposits')->insert([
                'sr_no' => $sr_no,
                'udrn' => $udrn,
                'name' => $name,
                'address' => $address,
                'sort_order' => $index,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
            $inserted++;
            $existingUdrns[] = $udrn;
            
            // Insert every 500 records to avoid memory issues
            if ($inserted % 500 == 0) {
                $db->transCommit();
                $db->transStart();
            }
        }
        
        $db->transComplete();

        log_activity('Imported', 'deaf_deposits', null);
        return redirect()->to('/admin/deaf-deposits')->with('success', "✅ Import completed: {$inserted} inserted, {$skipped} skipped.");
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed: ' . $e->getMessage());
    }
}


    public function sampleExcel()
    {
        // Create a sample Excel file for download
        require_once ROOTPATH . 'vendor/autoload.php';
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $sheet->setCellValue('A1', 'Sr No');
        $sheet->setCellValue('B1', 'UDRN');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Address');
        
        // Sample data
        $sheet->setCellValue('A2', 1);
        $sheet->setCellValue('B2', '51');
        $sheet->setCellValue('C2', 'MR MAHAJAN KISHOR VASANT');
        $sheet->setCellValue('D2', '178, MAROTI PETH, JALGAON.');
        
        $sheet->setCellValue('A3', 2);
        $sheet->setCellValue('B3', '133');
        $sheet->setCellValue('C3', 'M/S MAHAJAN SONA ASARAM');
        $sheet->setCellValue('D3', 'BHAWANI PETH, JALGAON');
        
        $sheet->setCellValue('A4', 3);
        $sheet->setCellValue('B4', '225');
        $sheet->setCellValue('C4', 'MRS BHOLE KAMALABAI KISAN');
        $sheet->setCellValue('D4', '11, VIVEKADAND NAGAR');
        
        // Auto size columns
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set headers for download
        $filename = 'deaf_deposits_sample.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function sampleCsv()
    {
        $filename = 'deaf_deposits_sample.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $handle = fopen('php://output', 'w');
        
        // Header row
        fputcsv($handle, ['Sr No', 'UDRN', 'Name', 'Address']);
        
        // Sample data rows
        fputcsv($handle, [1, '51', 'MR MAHAJAN KISHOR VASANT', '178, MAROTI PETH, JALGAON.']);
        fputcsv($handle, [2, '133', 'M/S MAHAJAN SONA ASARAM', 'BHAWANI PETH, JALGAON']);
        fputcsv($handle, [3, '225', 'MRS BHOLE KAMALABAI KISAN', '11, VIVEKADAND NAGAR']);
        fputcsv($handle, [4, '430', 'MRS CHAUDHARI DHANABAI HARI', 'A/P. ASODA T/D. JALGAON']);
        
        fclose($handle);
        exit;
    }
}