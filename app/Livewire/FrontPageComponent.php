<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Page;

class FrontPageComponent extends Component
{
    public $slug;
    public $page;

    public function mount($slug = 'home')
    {
        $this->slug = $slug;
        $this->page = Page::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.front-page-component', [
            'page' => $this->page,
        ])->layout('layouts.app'); // Можно заменить на твой основной шаблон
    }
}
