<div wire:ignore x-data="{editor: null, oldBody: @entangle('oldBody')}" x-init="
console.log(oldBody)
    editor =  new EditorJS({
        holder: $refs.editor,
        autofocus: true,
        minHeight: 50,
        readOnly: {{ $readOnly }},
        tools: {
            image: {
                class: ImageTool,
                config: {
                    uploader: {
                        uploadByFile: (file) => {
                            return new Promise((resolve) => {
                                $wire.upload('images', file,
                                    (uploadedFilename) => {
                                        window.addEventListener('updatedImages', (event)=>{
                                            resolve({
                                                success: 1,
                                                file: {
                                                    url: event.detail.url
                                                }
                                            });
                                        });
                                    }
                                );
                            });
                        },

                        uploadByUrl: (url) => {
                            return $wire.loadImageFromUrl(url).then(result => {
                                return {
                                    success: 1,
                                    file: {
                                        url: result
                                    }
                                }
                            });
                        }
                    }
                }
            },
            {{ $plugins ?? ''}}
        },
        data: oldBody,
    });
    ">
    <div x-ref="editor"></div>


    <button x-on:click="
        editor.save().then((outputData)=>{
            console.log(JSON.stringify(outputData));
            $wire.set('{{ $attributes->wire('model')->value() }}', JSON.stringify(outputData))
        }).catch((error) => {
            console.log('Saving failed: ', error)
        });
    ">save</button>
</div>


