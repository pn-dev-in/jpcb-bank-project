<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiteTranslationModel;

class SiteTranslations extends BaseController
{
    protected SiteTranslationModel $model;

    public function __construct()
    {
        $this->model = new SiteTranslationModel();
    }

    public function index()
    {
        $language = $this->request->getGet('language') ?: 'hi';
        $query = trim((string) $this->request->getGet('q'));

        $builder = $this->model->where('language', $language)->orderBy('sort_order', 'asc')->orderBy('source_text', 'asc');
        if ($query !== '') {
            $builder->groupStart()
                ->like('source_text', $query)
                ->orLike('translation', $query)
                ->orLike('context', $query)
                ->groupEnd();
        }

        return view('admin/site_translations/index', [
            'items' => $builder->findAll(),
            'language' => $language,
            'query' => $query,
            'languages' => site_languages(),
        ]);
    }

    public function create()
    {
        return view('admin/site_translations/form', [
            'languages' => site_languages(),
        ]);
    }

    public function store()
    {
        $rules = [
            'source_text' => 'required',
            'language' => 'required|in_list[hi,mr]',
            'translation' => 'required',
            'context' => 'permit_empty|max_length[120]',
            'status' => 'permit_empty|integer',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $sourceText = trim((string) $this->request->getPost('source_text'));
        $language = (string) $this->request->getPost('language');
        $textKey = sha1($sourceText);

        $this->model->insert([
            'text_key' => $textKey,
            'source_text' => $sourceText,
            'language' => $language,
            'translation' => $this->request->getPost('translation'),
            'context' => $this->request->getPost('context'),
            'status' => $this->request->getPost('status') ?? 1,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
        ]);

        return redirect()->to('/admin/site-translations?language=' . $language)->with('message', 'Translation added.');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/site-translations')->with('error', 'Translation not found.');
        }

        return view('admin/site_translations/form', [
            'item' => $item,
            'languages' => site_languages(),
        ]);
    }

    public function update($id)
    {
        $rules = [
            'translation' => 'required',
            'context' => 'permit_empty|max_length[120]',
            'status' => 'permit_empty|integer',
            'sort_order' => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $item = $this->model->find($id);
        if (!$item) {
            return redirect()->to('/admin/site-translations')->with('error', 'Translation not found.');
        }

        $this->model->update($id, [
            'translation' => $this->request->getPost('translation'),
            'context' => $this->request->getPost('context'),
            'status' => $this->request->getPost('status') ?? 1,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
        ]);

        return redirect()->to('/admin/site-translations?language=' . $item['language'])->with('message', 'Translation updated.');
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        $language = $item['language'] ?? 'hi';
        $this->model->delete($id);

        return redirect()->to('/admin/site-translations?language=' . $language)->with('message', 'Translation deleted.');
    }
}
