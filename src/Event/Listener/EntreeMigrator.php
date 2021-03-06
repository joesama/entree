<?php

namespace Joesama\Entree\Event\Listener;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Migrations\Migrator;

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
     * @param orchestra.install.schema $event
     *
     * @return void
     */
    public function handle()
    {
        $files = $this->app->make('files');
        $entreePath = realpath(__DIR__.'/../../../');
        $migrationPath = "{$entreePath}/migrations/";

        if ($files->isDirectory($migrationPath)) {
            $this->migrator->run($migrationPath);
        }
    }
}
