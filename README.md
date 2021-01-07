## Livewire-editorjs
Este paquete es inspirado en el paquete [maxeckel/livewire-editorjs](https://github.com/maxeckel/livewire-editorjs)
## Requisitos
Este paquete utiliza
[Livewire v2](https://laravel-livewire.com/docs/2.x/quickstart)
[AlpineJS](https://github.com/alpinejs/alpine)
## Instalación

    composer require samdeimos/livewire-editorjs
publicar archivo de configuración y assets

    php artisan vendor:publish --tag=livewire-editorjs
es necesario incluir `@livewireEditorjsScripts` antes de la etiqueta `</body>`

    <body>
	    <...>
	    @livewireEditorjsScripts
    </body>
    </html>
## Uso
Para el uso de este paquete únicamente se necesita hacer uso del Traits `WithEditorjs.php` y `WithEditorjs.php` para la carga de imagenes, en el componente que queramos usar un editor y en la vista de nuestro componente de livewire se inserta el componente de blade de editorjs

    <x-editorjs  wire:model="body"  :readOnly="false">
	    <x-slot  name="plugins">
		    list:List,
		    header: Header,
		    inlineCode: InlineCode,
		    underline: Underline,
		    raw: RawTool,
		    delimiter: Delimiter,
		    code: CodeTool,
	    </x-slot>
    </x-editorjs>

**Ejemplo de componente crear**
la variables que pasemos por `wire:model` es donde se va a almacenar el contenido de editorjs en formato string.

*component livewire*

	<?php
	namespace App\Http\Livewire\Post;

	use App\Models\Post;
	use Livewire\Component;
	use Livewire\WithFileUploads;
	use SamDeimos\LivewireEditorjs\Http\Livewire\WithEditorjs;

	class  Create  extends  Component
	}
	    use WithFileUploads, WithEditorjs;

	    public $body;

	    public function updatedBody()
	    {
	        $post = Post::create([
	            'title' => 'test',
	            'body' => $this->body,
	        ]);

	        return redirect()->route('post.edit', $post->id);
	    }

	    public function render()
	    {
	        return view('livewire.post.create');
	    }
    }
*vista component livewire*

    <div>
	    <x-slot name="header">
	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ __('Post') }}
	        </h2>
	    </x-slot>

	    <x-card>
	        <x-editorjs wire:model="body" :readOnly="false">
	            <x-slot name="plugins">
	                list:List,
	                header: Header,
	                inlineCode: InlineCode,
	                underline: Underline,
	                raw: RawTool,
	                delimiter: Delimiter,
	                code: CodeTool,
	            </x-slot>
	        </x-editorjs>
	    </x-card>
    </div>

**Ejemplo de componente editar**
para editar se llama la función `$this->setBody()` la cual recibe por parámetro el contenido a editar

*component livewire*

    <?php

    namespace App\Http\Livewire\Post;

    use App\Models\Post;
    use Livewire\Component;
    use Livewire\WithFileUploads;
    use SamDeimos\LivewireEditorjs\Http\Livewire\WithEditorjs;

    class Edit extends Component
    {
        use WithFileUploads, WithEditorjs;

        public $post;
        public $body;

        public function mount($id)
        {
            $this->post = Post::findOrFail($id);
            $this->setBody($this->post->body);
        }

        public function updatedBody()
        {
            $this->post->fill([
                'title' => '2',
                'body' => $this->body
            ])->save();
        }

        public function render()
        {
            return view('livewire.post.edit');
        }
    }

*vista component livewire*

    <div>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Post') }}
            </h2>
        </x-slot>

        <x-card>
            <x-editorjs wire:model="body">
                <x-slot name="plugins">
                    list:List,
                    header: Header,
                    warning: Warning,
                    inlineCode: InlineCode,
                    underline: Underline,
                    maker: Maker,
                    raw: RawTool,
                    delimiter: Delimiter,
                    code: CodeTool,
                </x-slot>
            </x-editorjs>
        </x-card>
    </div>
## NOTA
para poder hacer uso de los plugins deben ser instalados previamente he incluidos el `app.js`

    window.ImageTool = require("@editorjs/image");
    window.List = require("@editorjs/list");
    window.Header = require("@editorjs/header");
    window.Warning = require("@editorjs/warning");
    window.InlineCode = require("@editorjs/inline-code");
    window.Underline = require("@editorjs/underline");
    window.Maker = require("@editorjs/marker");
    window.RawTool = require("@editorjs/raw");
    window.Delimiter = require("@editorjs/delimiter");
    window.CodeTool = require("@editorjs/code");

A forma personal, pienso que al momento de crear paquetes no es correcto el ofrecer un componente terminado el cual debe ser usado, para generar un paquete para livewire mas flexible prefiero hacer el uso de Traits y componentes blade.
