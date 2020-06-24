<?php

trait DbConfigTrait
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'laralearn');
        $app['config']->set('database.connections.laralearn', [
            'driver'   => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'lara_drawcampaign',
            'username' =>  'laralearn',
            'password' => '123456',
        ]);
    }

    protected function getMigrationPath()
    {
       return __DIR__ . '/../../src/resources/database/migrations';
    }

    protected function getFactoryPath()
    {
       return __DIR__ . '/../../src/resources/database/factories';
    }
}
