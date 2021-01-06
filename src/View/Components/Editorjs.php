<?php

namespace SamDeimos\LivewireEditorjs\View\Components;

use Illuminate\View\Component;

class Editorjs extends Component
{
    public $readOnly;

    public function __construct($readOnly = false)
    {
        $this->readOnly = json_encode($readOnly);
    }

    public function render()
    {
        return view('livewire-editorjs::components.editorjs');
    }
}
