<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AboutHeritageSettingModel;
use App\Models\AboutHeritageBadgeModel;

class AboutHeritage extends BaseController
{
    protected $settingModel;
    protected $badgeModel;

    public function __construct()
    {
        $this->settingModel = new AboutHeritageSettingModel();
        $this->badgeModel = new AboutHeritageBadgeModel();
    }

    /**
     * Main admin page – displays settings form and badges table.
     */
    public function index()
    {
        $settings = $this->settingModel->getSettings();
        $badges = $this->badgeModel->getAllBadges();

        // Get available icons list for reference (optional)
        $commonIcons = [
            'landmark', 'heart-handshake', 'shield-check', 'sprout',
            'award', 'users', 'clock', 'calendar', 'star', 'zap'
        ];

        return view('admin/about_heritage/index', [
            'settings' => $settings,
            'badges' => $badges,
            'commonIcons' => $commonIcons
        ]);
    }

    /**
     * Update the global heritage settings.
     */
    public function updateSettings()
    {
        $rules = [
            'eyebrow'            => 'permit_empty|max_length[100]',
            'title'              => 'permit_empty|max_length[255]',
            'subheading_left'    => 'permit_empty|max_length[255]',
            'heading_left'       => 'permit_empty|max_length[255]',
            'intro_paragraph'    => 'permit_empty',
            'founding_paragraph' => 'permit_empty',
            'expandable_paragraphs' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle image upload if provided
        $imageFile = $this->request->getFile('image_file');
        $imagePath = $this->request->getPost('image');

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Create directory if needed
            $uploadPath = FCPATH . 'uploads/heritage';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = 'heritage_' . time() . '_' . $imageFile->getRandomName();
            $imageFile->move($uploadPath, $newName);
            $imagePath = 'uploads/heritage/' . $newName;
        }

        $data = [
            'eyebrow'            => $this->request->getPost('eyebrow'),
            'title'              => $this->request->getPost('title'),
            'subheading_left'    => $this->request->getPost('subheading_left'),
            'heading_left'       => $this->request->getPost('heading_left'),
            'intro_paragraph'    => $this->request->getPost('intro_paragraph'),
            'founding_paragraph' => $this->request->getPost('founding_paragraph'),
            'expandable_paragraphs' => $this->request->getPost('expandable_paragraphs'),
        ];
        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        $this->settingModel->update(1, $data);
        log_activity('Updated', 'about_heritage_settings', 1);
        return redirect()->to('/admin/about-heritage')->with('message', 'Heritage settings updated.');
    }

    /**
     * Create a new heritage badge.
     */
    public function createBadge()
    {
        $rules = [
            'icon'        => 'required|max_length[50]',
            'label'       => 'required|max_length[100]',
            'description' => 'required|max_length[255]',
            'color_theme' => 'required|in_list[primary,secondary,accent,primary-light]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->badgeModel->insert([
            'icon'        => $this->request->getPost('icon'),
            'label'       => $this->request->getPost('label'),
            'description' => $this->request->getPost('description'),
            'color_theme' => $this->request->getPost('color_theme'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Created', 'about_heritage_badges', $id);
        return redirect()->to('/admin/about-heritage')->with('message', 'Badge added successfully.');
    }

    /**
     * Update an existing badge.
     */
    public function updateBadge($id)
    {
        $rules = [
            'icon'        => 'required|max_length[50]',
            'label'       => 'required|max_length[100]',
            'description' => 'required|max_length[255]',
            'color_theme' => 'required|in_list[primary,secondary,accent,primary-light]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->badgeModel->update($id, [
            'icon'        => $this->request->getPost('icon'),
            'label'       => $this->request->getPost('label'),
            'description' => $this->request->getPost('description'),
            'color_theme' => $this->request->getPost('color_theme'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        log_activity('Updated', 'about_heritage_badges', $id);
        return redirect()->to('/admin/about-heritage')->with('message', 'Badge updated successfully.');
    }

    /**
     * Delete a badge.
     */
    public function deleteBadge($id)
    {
        $this->badgeModel->delete($id);
        log_activity('Deleted', 'about_heritage_badges', $id);
        return redirect()->to('/admin/about-heritage')->with('message', 'Badge deleted successfully.');
    }
}