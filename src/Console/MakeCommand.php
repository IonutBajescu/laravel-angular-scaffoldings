<?php

namespace Ionut\LaravelAngularScaffoldings\Console;


use Illuminate\Console\Command;
use Illuminate\View\Engines\CompilerEngine;

class MakeCommand extends Command
{
    protected $signature = 'make:angular {state} {--only-state} {--A|abstract} {--template=1} {--state=1} {--controller=1}';

    protected $templates = [
        '.html' => 'template',
        '.controller.js' => 'controller',
        '.state.js' => 'state'
    ];

    public function handle()
    {
        if ($this->option('only-state')){
            $this->input->setOption('template', 0);
            $this->input->setOption('controller', 0);
            $this->input->setOption('abstract', 1);
        }

        $state = $this->argument('state');
        $abstractOption = $this->option('abstract');
        $templateOption = $this->option('template');
        $controllerOption = $this->option('controller');
        $statePieces = explode('.', $state);
        $path = 'src/application/'.str_replace('.', '/', $state);
        $absolutePath = public_path($path);
        $controller = implode(array_map(function($piece) {
                return ucfirst(camel_case($piece));
            }, $statePieces)) . 'Ctrl';
        $name = end($statePieces);

        $variables = compact('name', 'state', 'absolutePath', 'path', 'controller', 'abstractOption', 'templateOption', 'controllerOption');

        if (!file_exists($absolutePath) && $this->confirm('The folder does not exist, shall I create it?')) {
            mkdir($absolutePath);
        }

        $this->make('.html', $variables);
        $this->make('.controller.js', $variables);
        $this->make('.state.js', $variables);
    }

    public function make($suffix, $variables)
    {

        if ($this->option($this->templates[$suffix])) {
            /** @var CompilerEngine $engine */
            $engine = app('view.engine.resolver')->resolve('blade');

            $filepath = $variables['absolutePath'] . '/' .$variables['name']  . $suffix;

            if (file_exists($filepath)) {
                $this->error("Abort, the {$suffix} file already exists. {$filepath}");
                return;
            }

            file_put_contents(
                $filepath,
                $engine->get($this->getPath($suffix), $variables)
            );

            $this->info("Created {$filepath}");
        }

    }

    private function getPath($suffix)
    {
        return __DIR__.'/../templates/' . $this->templates[$suffix] . '.blade.php';
    }
}