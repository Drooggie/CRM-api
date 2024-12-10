<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
        make:routes 
        {route_name} 
        {path} 
        {folder} 
        {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected string $route_name;
    protected string $folder;
    protected string $prefix;
    protected string $type;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->type = $this->argument('type');
        $this->folder = $this->argument('folder');
        $this->route_name = $this->argument('route_name');

        $this->setStubs();
    }

    public function setStubs(): void
    {
        $path = base_path($this->argument('path'));
        $filePath = $path . '/' . $this->type . '.php';

        $replacement = $this->setReplacement();

        $content = strtr(
            File::get(base_path('/app/stubs/routes.php.stub')),
            $replacement
        );

        $this->createFiles($path, $filePath, $content);
    }

    public function setPrefix(): void
    {
        if ($this->type === 'web') {

            $this->prefix = Str::lower($this->folder . '/' . $this->route_name . '/');
        } elseif ($this->type === 'api') {

            $this->prefix = 'api/v1/' . Str::lower($this->folder . '/' . $this->route_name . '/');
        }
    }

    public function setReplacement(): array
    {
        $this->setPrefix();

        return [
            'StubFolderName' => $this->folder,
            'StubControllerName' => $this->route_name . 'Controller',
            'StubRoutePrefix' => $this->prefix,
            'StubLowerModelName' => Str::lower($this->route_name),
            'StubUpperModelName' => $this->route_name,
        ];
    }

    public function createFiles($path, $filePath, $content): void
    {
        if (File::exists($filePath)) {

            $this->fail('Routes already exists');
        }

        if (!File::exists($path)) {

            File::makeDirectory($path, 0755, true);
        }


        File::put($filePath, $content);

        $this->components->info("Routes [.$filePath.] successfully created");
    }
}
