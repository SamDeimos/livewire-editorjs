<?php
namespace SamDeimos\LivewireEditorjs\Http\Livewire;

use Illuminate\Support\Facades\Storage;

trait WithEditorjs
{
    public $images = [];
    public $oldBody = [];

    public function updatedImages()
    {
        $tmpFile = collect($this->images)->last();

        $storedFileName = $tmpFile->store('/', config('editorjs.default_upload_disk'));

        $this->dispatchBrowserEvent('updatedImages', [
            'url' => Storage::disk(config('editorjs.default_download_disk'))->url($storedFileName),
        ]);
    }

    public function loadImageFromUrl(string $url)
    {
        $name = basename($url);
        $content = file_get_contents($url);
        Storage::disk(config('editorjs.default_download_disk'))->put($name, $content);

        return Storage::disk(config('editorjs.default_download_disk'))->url($name);
    }

    public function setBody(String $content)
    {
        $this->oldBody = json_decode($content, true);
    }
}
