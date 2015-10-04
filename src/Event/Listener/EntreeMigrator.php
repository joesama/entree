<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Contracts\Container\Container;

class EntreeMigrator
{

    /**
     * Application instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    /**
     * Migrator instance.
     *
     * @var \Illuminate\Database\Migrations\Migrator
     */
    protected $migrator;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->app->make('migration.repository');
        $this->migrator = $this->app->make('migrator');
    }

    /**
     * Handle the event.
     *
     * @param  orchestra.install.schema  $event
     * @return void
     */
    public function handle()
    {
        $files      = $this->app->make('files');
        $entreePath = realpath(__DIR__.'/../../../');
        $migrationPath = "{$entreePath}/migrations/";

        if ($files->isDirectory($migrationPath)) {
            $this->migrator->run($migrationPath);
        }
    }



}
