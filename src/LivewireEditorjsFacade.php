<?php

namespace SamDeimos\LivewireEditorjs;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SamDeimos\LivewireEditorjs\Skeleton\SkeletonClass
 */
class LivewireEditorjsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'livewire-editorjs';
    }
}
