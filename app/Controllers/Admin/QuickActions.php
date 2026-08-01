<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QuickActionModel;

class QuickActions extends BaseController
{
    protected $quickActionModel;

    public function __construct()
    {
        $this->quickActionModel = new QuickActionModel();
    }

    // List all quick actions
    public function index()
    {
        $quickActions = $this->quickActionModel->orderBy('id', 'ASC')->findAll();
        return view('admin/quick_actions/index', ['quickActions' => $quickActions]);
    }

    // Show create form
    public function create()
    {
        return view('admin/quick_actions/form');
    }

    // Store new quick action
    public function store()
    {
        $rules = [
            'title'       => 'required|max_length[100]',
            'description' => 'permit_empty|max_length[150]',
            'icon'        => 'required|max_length[100]',
            'link'        => 'required|max_length[255]',
            'image'       => 'permit_empty|max_length[255]',
            'is_alert'    => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle image upload
        $imagePath = $this->request->getPost('image');
        $img = $this->request->getFile('image_file');

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Create directory if not exists
            $uploadPath = FCPATH . 'uploads/quick-actions';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = 'quick_action_' . time() . '_' . $img->getRandomName();
            $img->move($uploadPath, $newName);
            $imagePath = 'uploads/quick-actions/' . $newName;
        }

        $this->quickActionModel->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
            'link'        => $this->request->getPost('link'),
            'image'       => $imagePath,
            'is_alert'    => $this->request->getPost('is_alert') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        $id = $this->quickActionModel->getInsertID();
        log_activity('Created', 'quick-actions', $id);
        
        return redirect()->to('/admin/quick-actions')->with('message', 'Quick action added successfully.');
    }

    // Show edit form
    public function edit($id)
{
    $quickAction = $this->quickActionModel->find($id);
    if (!$quickAction) {
        return redirect()->to('/admin/quick-actions')->with('error', 'Quick action not found.');
    }
    return view('admin/quick_actions/form', ['quickAction' => $quickAction]); // Use 'quickAction'
}

    // Update quick action
    public function update($id)
    {
        $rules = [
            'title'       => 'required|max_length[100]',
            'description' => 'permit_empty|max_length[150]',
            'icon'        => 'required|max_length[100]',
            'link'        => 'required|max_length[255]',
            'image'       => 'permit_empty|max_length[255]',
            'is_alert'    => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get existing quick action to delete old image if needed
        $existingAction = $this->quickActionModel->find($id);
        
        // Handle image upload
        $imagePath = $this->request->getPost('image');
        $img = $this->request->getFile('image_file');

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Delete old image if exists
            if (!empty($existingAction['image']) && file_exists(FCPATH . $existingAction['image'])) {
                unlink(FCPATH . $existingAction['image']);
            }

            // Create directory if not exists
            $uploadPath = FCPATH . 'uploads/quick-actions';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = 'quick_action_' . time() . '_' . $img->getRandomName();
            $img->move($uploadPath, $newName);
            $imagePath = 'uploads/quick-actions/' . $newName;
        } elseif (empty($imagePath) && !empty($existingAction['image'])) {
            // Keep existing image if no new upload and no manual path provided
            $imagePath = $existingAction['image'];
        }

        $this->quickActionModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
            'link'        => $this->request->getPost('link'),
            'image'       => $imagePath,
            'is_alert'    => $this->request->getPost('is_alert') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Updated', 'quick-actions', $id);
        
        return redirect()->to('/admin/quick-actions')->with('message', 'Quick action updated successfully.');
    }

    // Delete quick action
    public function delete($id)
    {
        // Get the quick action to delete its image
        $quickAction = $this->quickActionModel->find($id);
        
        // Delete associated image if exists
        if ($quickAction && !empty($quickAction['image']) && file_exists(FCPATH . $quickAction['image'])) {
            unlink(FCPATH . $quickAction['image']);
        }
        
        // Delete the record
        $this->quickActionModel->delete($id);
        log_activity('Deleted', 'quick-actions', $id);
        
        return redirect()->to('/admin/quick-actions')->with('message', 'Quick action deleted successfully.');
    }
}