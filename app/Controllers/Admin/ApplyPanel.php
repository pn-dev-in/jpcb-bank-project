<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ApplyPanelSettingModel;
use App\Models\ApplyPanelItemModel;

class ApplyPanel extends BaseController
{
    protected $settingModel;
    protected $itemModel;

    public function __construct()
    {
        $this->settingModel = new ApplyPanelSettingModel();
        $this->itemModel = new ApplyPanelItemModel();
    }

    // Settings Index
    public function index()
    {
        $settings = $this->settingModel->getSettings();
        $items = $this->itemModel->orderBy('sort_order', 'asc')->findAll();
        
        return view('admin/apply_panel/index', [
            'settings' => $settings,
            'items' => $items,
            'colors' => $this->itemModel->getColors()
        ]);
    }

    // Update Settings
    public function updateSettings()
    {
        $rules = [
            'panel_title' => 'required|max_length[100]',
            'panel_subtitle' => 'permit_empty|max_length[255]',
            'footer_text' => 'required|max_length[255]',
            'footer_link' => 'required|max_length[255]',
            'button_text' => 'required|max_length[100]',
            'position' => 'required|in_list[left,right]',
            'is_enabled' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->settingModel->update(1, [
            'panel_title' => $this->request->getPost('panel_title'),
            'panel_subtitle' => $this->request->getPost('panel_subtitle'),
            'footer_text' => $this->request->getPost('footer_text'),
            'footer_link' => $this->request->getPost('footer_link'),
            'button_text' => $this->request->getPost('button_text'),
            'position' => $this->request->getPost('position'),
            'is_enabled' => $this->request->getPost('is_enabled') ?? 0
        ]);

        log_activity('Updated', 'apply_panel_settings', 1);
        return redirect()->to('/admin/apply-panel')->with('message', 'Settings updated successfully.');
    }

    // Create Item
    public function createItem()
    {
        $rules = [
            'icon' => 'required|max_length[50]',
            'label' => 'required|max_length[100]',
            'link' => 'required|max_length[255]',
            'color' => 'required|in_list[green,teal,gold,blue,purple,red,orange,pink]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->itemModel->insert([
            'icon' => $this->request->getPost('icon'),
            'label' => $this->request->getPost('label'),
            'link' => $this->request->getPost('link'),
            'color' => $this->request->getPost('color'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1
        ]);

        log_activity('Created', 'apply_panel_items', $id);
        return redirect()->to('/admin/apply-panel')->with('message', 'Item added successfully.');
    }

    // Update Item
    public function updateItem($id)
    {
        $rules = [
            'icon' => 'required|max_length[50]',
            'label' => 'required|max_length[100]',
            'link' => 'required|max_length[255]',
            'color' => 'required|in_list[green,teal,gold,blue,purple,red,orange,pink]',
            'sort_order' => 'permit_empty|integer',
            'status' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->itemModel->update($id, [
            'icon' => $this->request->getPost('icon'),
            'label' => $this->request->getPost('label'),
            'link' => $this->request->getPost('link'),
            'color' => $this->request->getPost('color'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'status' => $this->request->getPost('status') ?? 1
        ]);

        log_activity('Updated', 'apply_panel_items', $id);
        return redirect()->to('/admin/apply-panel')->with('message', 'Item updated successfully.');
    }

    // Delete Item
    public function deleteItem($id)
    {
        $this->itemModel->delete($id);
        log_activity('Deleted', 'apply_panel_items', $id);
        return redirect()->to('/admin/apply-panel')->with('message', 'Item deleted successfully.');
    }
}