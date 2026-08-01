<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AboutPageContentModel;

class AboutPageContent extends BaseController
{
    protected AboutPageContentModel $model;

    public function __construct()
    {
        $this->model = new AboutPageContentModel();
    }

    public function edit()
    {
        $content = $this->model->orderBy('id', 'asc')->first();

        if (!$content) {
            $this->model->insert([
                'hero_title' => 'The Jalgaon Peoples Co-operative Bank Ltd.',
                'hero_subtitle' => 'Multi-State Scheduled Co-operative Bank serving customers with trust, accessibility, and disciplined governance.',
                'intro_title' => 'A Legacy of Trust and Community Banking',
                'intro_description' => "The Jalgaon Peoples Co-operative Bank Ltd. has been a cornerstone of community banking in Maharashtra for over seven decades.\n\nAs a Multi-State Scheduled Co-operative Bank regulated by the Reserve Bank of India, we combine personalized service with the strength and confidence customers expect from a scheduled banking institution.",
                'mission_title' => 'Our Mission',
                'mission_description' => 'To provide safe, accessible, and innovative banking services to every section of society, fostering financial inclusion and sustainable growth in the communities we serve.',
                'vision_title' => 'Our Vision',
                'vision_description' => 'To be the most trusted and accessible co-operative bank, recognized for customer-centric innovation, transparent governance, and inclusive banking practices.',
                'status' => 1,
                'sort_order' => 0,
            ]);
            $content = $this->model->orderBy('id', 'asc')->first();
        }

        return view('admin/about_page_content/edit', ['content' => $content]);
    }

    public function update()
    {
        $content = $this->model->orderBy('id', 'asc')->first();
        $id = (int) ($content['id'] ?? 1);

        $rules = [
            'hero_title' => 'required|max_length[255]',
            'hero_subtitle' => 'permit_empty',
            'intro_title' => 'required|max_length[255]',
            'intro_description' => 'required',
            'mission_title' => 'required|max_length[255]',
            'mission_description' => 'required',
            'vision_title' => 'required|max_length[255]',
            'vision_description' => 'required',
            'hero_image' => 'permit_empty|is_image[hero_image]|max_size[hero_image,5120]',
            'seo_title' => 'permit_empty|max_length[255]',
            'seo_description' => 'permit_empty',
            'status' => 'permit_empty|integer',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = $content['hero_image'] ?? '';
        $image = $this->request->getFile('hero_image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            if (!empty($imageName) && !preg_match('~^https?://~i', $imageName) && is_file(FCPATH . $imageName)) {
                unlink(FCPATH . $imageName);
            }

            $uploadPath = FCPATH . 'uploads/about/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $image->getRandomName();
            $image->move($uploadPath, $newName);
            $imageName = 'uploads/about/' . $newName;
        }

        $data = [
            'hero_title' => $this->request->getPost('hero_title'),
            'hero_subtitle' => $this->request->getPost('hero_subtitle'),
            'intro_title' => $this->request->getPost('intro_title'),
            'intro_description' => $this->request->getPost('intro_description'),
            'mission_title' => $this->request->getPost('mission_title'),
            'mission_description' => $this->request->getPost('mission_description'),
            'vision_title' => $this->request->getPost('vision_title'),
            'vision_description' => $this->request->getPost('vision_description'),
            'hero_image' => $imageName,
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'status' => $this->request->getPost('status') ?? 1,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
        ];

        if ($content) {
            $this->model->update($id, $data);
        } else {
            $this->model->insert($data);
            $id = (int) $this->model->getInsertID();
        }

        log_activity('Updated', 'about_page_content', $id);
        return redirect()->to('/admin/about-page-content/edit')->with('message', 'About page content updated successfully.');
    }
}
