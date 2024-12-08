<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
        {--routes=}
        {--all=}
        {--model}
        {--controller} 
        {--migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate module files (model, migration, controller, etc.) for a given module';

    protected string $universal_name;
    protected string $migration_name;
    protected string $route;
    protected string $folder;
    protected string $base_path;
    protected string $model_path;

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->setNames();

        if ($this->option('all')) $this->createAll();
        if ($this->option('model')) $this->createModel();
        if ($this->option('routes')) $this->createRoutes();
        if ($this->option('migration')) $this->createMigration();
        if ($this->option('controller')) $this->createController();
    }

    public function setNames()
    {
        $name = Str::of($this->argument('name'))->studly();

        $this->route = $this->setRouteName();
        $this->folder = $this->argument('folder');

        $this->universal_name = Str::singular($name);

        $this->base_path = "App\\Modules\\" . $this->folder . "\\";

        $this->model_path = $this->base_path . "Models\\" . $this->universal_name;

        $this->migration_name = sprintf('create_%s_table', Str::plural($this->universal_name));
    }

    public function setRouteName()
    {
        if ($this->option('all')) return $this->option('all');

        if ($this->option('routes')) return $this->option('routes');
    }

    public function createAll()
    {
        $this->createModel();
        $this->createRoutes();
        $this->createPolicies();
        $this->createMigration();
        $this->createController();
    }

    public function createModel()
    {
        $this->call('make:model', [
            "name" =>  $this->model_path,
        ]);
    }

    public function createRoutes()
    {
        if (!in_array($this->route, ['web', 'api'])) {

            $this->fail("Bad routes type. Only 'web' and 'api' available.");
        }

        $this->call("make:routes", [
            "route_name" => $this->universal_name,
            "path" => 'app/Modules/' . $this->folder . '/routes',
            "folder" => $this->argument('folder'),
            "type" => $this->route,
        ]);
    }

    public function createPolicies()
    {
        $this->call('make:policy', [
            "name" => $this->base_path . "Policies\\" . $this->universal_name . 'Policy',
            "--model" => $this->model_path,
        ]);
    }

    public function createMigration()
    {

        $path_to_migrations = base_path('app/Modules/' . $this->folder . '/migrations/.' . $this->universal_name . 'Created');

        if (File::exists($path_to_migrations)) {
            $this->fail("Migrations already exists.");
        }

        $this->call("make:migration", [
            "name" => $this->migration_name,
            "--create" => $this->universal_name,
            "--path" => 'app/Modules/' . $this->folder . '/migrations',
        ]);

        File::put($path_to_migrations, '');
    }

    public function createController()
    {
        $this->call('make:controller', [
            "name" =>  $this->base_path . "Controllers\\" . $this->universal_name . 'Controller',
            "--model" => $this->model_path
        ]);
    }
}
