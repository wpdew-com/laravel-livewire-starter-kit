<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Page;
use Livewire\WithPagination;

class PageComponent extends Component
{
    use WithPagination;

    public $title, $slug, $description, $content, $pageId, $showForm = false;
    public $isEditMode = false;
    public $pageIdToEdit = null;
    public $pageIdToDelete = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.pages.page-component', [
            'pages' => Page::paginate(10)
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditMode = true;
        $this->showForm = true;
    }

    public function storePage()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            //'content' => 'required|string',
            'slug' => $this->isEditMode
                ? 'required|string|unique:pages,slug,' . $this->pageId
                : 'required|string|unique:pages,slug',
            'description' => 'required|string'
        ]);

        $page = $this->isEditMode ? Page::findOrFail($this->pageId) : new Page();
        $page->title = $this->title;
        $page->content = $this->content;
        $page->description = $this->description;
        $page->foto = '';
        $page->slug = $this->slug;
        $page->save();

        session()->flash('message', $this->isEditMode ? __('pages.The page has been updated.') : __('pages.The page was created successfully.'));

        $this->dispatch('flashMessage', __('pages.The page has been updated.'));

        $this->resetForm();
        $this->showForm = false;

        if (!$this->isEditMode) {
            $this->resetPage(); // Обновляет пагинацию, чтобы увидеть новую страницу
        }
    }



    public function store()
    {
        $this->validate();

        Page::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', __('pages.The page was created successfully.'));

        $this->resetPage(); // Обновляет пагинацию, чтобы увидеть новую страницу
        $this->resetForm();
    }


    public function edit($id)
    {


        $page = Page::findOrFail($id);
        $this->pageId = $page->id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->description = $page->description;
        $this->content = $page->content;
        $this->isEditMode = true;
        $this->showForm = true;
        $this->dispatch('editorUpdated', $this->content);


    }

    public function update()
    {
        $this->validate();
        Page::findOrFail($this->pageId)->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        session()->flash('message', __('pages.The page has been updated.'));
        $this->showForm = false;
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->pageIdToDelete = $id;
    }

    public function deletePage()
    {
        if ($this->pageIdToDelete) {
            Page::findOrFail($this->pageIdToDelete)->delete();
            session()->flash('message', __('pages.Page removed.'));
            $this->pageIdToDelete = null;
        }
    }

    //showForm
    public function showForms()
    {
        $this->isEditMode = false;
        $this->dispatch('clearEditor');
        $this->dispatch('openEditor');
        $this->showForm = true;
    }

    public function resetForm()
    {
        $this->title = '';
        $this->content = '';
        $this->pageId = null;
        $this->isEditMode = false;
        $this->showForm = false;
        $this->dispatch('clearEditor');
    }

}
