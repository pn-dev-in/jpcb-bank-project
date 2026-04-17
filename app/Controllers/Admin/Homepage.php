<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HomeHeroModel;
use App\Models\TrustCardModel;

class Homepage extends BaseController
{
    protected $heroModel;
    protected $trustCardModel;

    public function __construct()
    {
        $this->heroModel = new HomeHeroModel();
        $this->trustCardModel = new TrustCardModel();
    }

    // ------------------------- Hero Section (Edit) -------------------------
    public function editHero()
    {
        $hero = $this->heroModel->find(1);
        if (!$hero) {
            // fallback: create default row if missing
            $this->heroModel->insert([
                'badge_text' => 'Multi-State Scheduled Bank • Serving Since 1933',
                'heading_main' => 'Banking you can trust.',
                'heading_highlight' => 'Service that feels human.',
                'description' => 'Your trusted partner...',
                'button1_text' => 'Explore Products',
                'button1_link' => 'deposits',
                'button2_text' => 'Find Branch / ATM',
                'button2_link' => 'about/branches',
                'search_placeholder' => 'Search products, forms, rates, branch...'
            ]);
            $hero = $this->heroModel->find(1);
        }

        return view('admin/homepage/edit_hero', ['hero' => $hero]);
    }

    public function updateHero()
    {
        $rules = [
            'badge_text'          => 'required|max_length[255]',
            'heading_main'        => 'required|max_length[255]',
            'heading_highlight'   => 'required|max_length[255]',
            'description'         => 'required',
            'button1_text'        => 'required|max_length[100]',
            'button1_link'        => 'required|max_length[255]',
            'button2_text'        => 'required|max_length[100]',
            'button2_link'        => 'required|max_length[255]',
            'search_placeholder'  => 'required|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->heroModel->update(1, [
            'badge_text'         => $this->request->getPost('badge_text'),
            'heading_main'       => $this->request->getPost('heading_main'),
            'heading_highlight'  => $this->request->getPost('heading_highlight'),
            'description'        => $this->request->getPost('description'),
            'button1_text'       => $this->request->getPost('button1_text'),
            'button1_link'       => $this->request->getPost('button1_link'),
            'button2_text'       => $this->request->getPost('button2_text'),
            'button2_link'       => $this->request->getPost('button2_link'),
            'search_placeholder' => $this->request->getPost('search_placeholder'),
        ]);

        return redirect()->to('/admin/homepage/edit-hero')->with('message', 'Hero section updated successfully.');
    }

    // ------------------------- Trust Cards (CRUD) -------------------------
    public function trustCards()
    {
        $cards = $this->trustCardModel->orderBy('sort_order', 'asc')->findAll();
        return view('admin/homepage/trust_cards', ['cards' => $cards]);
    }

    public function createCard()
    {
        return view('admin/homepage/card_form');
    }

    public function storeCard()
    {
        $rules = [
            'icon_name'   => 'required|max_length[50]',
            'title'       => 'required|max_length[100]',
            'description' => 'required|max_length[255]',
            'link'        => 'permit_empty|max_length[255]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->trustCardModel->save([
            'icon_name'   => $this->request->getPost('icon_name'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'link'        => $this->request->getPost('link'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/homepage/trust-cards')->with('message', 'Trust card added.');
    }

    public function editCard($id)
    {
        $card = $this->trustCardModel->find($id);
        if (!$card) {
            return redirect()->to('/admin/homepage/trust-cards')->with('error', 'Card not found.');
        }
        return view('admin/homepage/card_form', ['card' => $card]);
    }

    public function updateCard($id)
    {
        $rules = [
            'icon_name'   => 'required|max_length[50]',
            'title'       => 'required|max_length[100]',
            'description' => 'required|max_length[255]',
            'link'        => 'permit_empty|max_length[255]',
            'sort_order'  => 'permit_empty|integer',
            'status'      => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->trustCardModel->update($id, [
            'icon_name'   => $this->request->getPost('icon_name'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'link'        => $this->request->getPost('link'),
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/homepage/trust-cards')->with('message', 'Trust card updated.');
    }

    public function deleteCard($id)
    {
        $this->trustCardModel->delete($id);
        return redirect()->to('/admin/homepage/trust-cards')->with('message', 'Card deleted.');
    }

    public function index()
{
    return view('admin/homepage/index');
}
}