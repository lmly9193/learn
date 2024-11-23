<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class TraitMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = $this->option('model') ? 'stubs/trait.model.stub' : 'stubs/trait.stub';
        return resource_path($stub);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "$rootNamespace\\Traits";
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['type', null, InputOption::VALUE_REQUIRED, 'Manually specify the trait stub file to use'],
            ['force', 'f', InputOption::VALUE_NONE, 'Create the trait even if the trait already exists'],
            ['model', 'm', InputOption::VALUE_NONE, 'Generate an trait for Model'],
        ];
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $trait = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace(['DummyTrait', '{{ trait }}', '{{trait}}'], $trait, $stub);
    }
}
