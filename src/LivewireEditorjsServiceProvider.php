<?php

namespace SamDeimos\LivewireEditorjs;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use SamDeimos\LivewireEditorjs\View\Components\Editorjs;

class LivewireEditorjsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'livewire-editorjs');

        $this->registerPublishables();
        $this->registerDirectives();

        Blade::component('editorjs', Editorjs::class);

        // Blade::component('livewire-editorjs::components.editorjs', Editorjs::class);

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'livewire-editorjs');

        // Register the main class to use with the facade
        $this->app->singleton('livewire-editorjs', function () {
            return new LivewireEditorjs;
        });
    }

    private function registerPublishables()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('livewire-editorjs.php'),
            __DIR__.'/../dist' => public_path('vendor/livewire-editorjs'),
        ], 'livewire-editorjs');

    }

    private function registerDirectives()
    {
        Blade::directive('livewireEditorjsScripts', function () {
            $scriptsUrl = asset('/vendor/livewire-editorjs/editorjs.js');

            return <<<EOF
                <script src="$scriptsUrl"></script>
            EOF;
        });
    }
}
