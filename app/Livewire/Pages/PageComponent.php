<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Page;
use Livewire\WithPagination;

class PageComponent extends Component
{
    use WithPagination;

    public $title, $content, $pageId;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.pages.page-component', [
            'pages' => Page::paginate(10) // Передаём переменную в шаблон
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditMode = true;
    }

    public function store()
    {
        $this->validate();
        Page::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        session()->flash('message', 'Страница создана успешно.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $this->pageId = $page->id;
        $this->title = $page->title;
        $this->content = $page->content;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();
        Page::findOrFail($this->pageId)->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        session()->flash('message', 'Страница обновлена.');
        $this->resetForm();
    }

    public function delete($id)
    {
        Page::findOrFail($id)->delete();
        session()->flash('message', 'Страница удалена.');
    }

    public function resetForm()
    {
        $this->title = '';
        $this->content = '';
        $this->pageId = null;
        $this->isEditMode = false;
    }
}
