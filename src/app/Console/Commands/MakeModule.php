<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module 
        {name} 
        {folder}
        {--all}
        {--api} 
        {--controller} 
        {--model}
        {--migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate module files (model, migration, controller, etc.) for a given module';

    protected string $universal_name;
    protected string $migration_name;
    protected string $folder;
    protected string $base_path;

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->setNames();

        if ($this->option('all')) $this->createAll();

        if ($this->option('api')) $this->createApi();

        if ($this->option('model')) $this->createModel();

        if ($this->option('migration')) $this->createMigration();

        if ($this->option('controller')) $this->createController();
    }

    public function setNames()
    {
        $name = Str::of($this->argument('name'))->studly();

        $this->folder = $this->argument('folder');

        $this->universal_name = Str::singular($name);

        $this->migration_name = 'create_' . Str::plural($name) . '_table';

        $this->base_path = "App\\Modules\\" . $this->folder . "\\";
    }

    public function createAll()
    {
        $this->createApi();
        $this->createModel();
        $this->createMigration();
        $this->createController();
    }

    public function createApi()
    {
        //
    }

    public function createModel()
    {
        $this->call('make:model', [
            "name" =>  $this->base_path . "Models\\" . $this->universal_name,
        ]);
    }

    public function createMigration()
    {
        $this->call("make:migration", [
            "name" => $this->migration_name,
            "--create" => $this->universal_name,
            "--base_path" => 'app/Modules/' . $this->folder . '/migrations',
        ]);
    }

    public function createController()
    {
        $this->call('make:controller', [
            "name" =>  $this->base_path . "Controllers\\" . $this->universal_name . 'Controller',
        ]);
    }
}
