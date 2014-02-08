<?php

use Behat\Behat\Context\BehatContext;

class HookContext extends BehatContext
{
    // public function __construct(array $parameters)
    // {
    // 	// do subcontext initialization
    // }

    /**
     * @static
     * @beforeSuite
     */
    public static function bootstrapLaravel()
    {
        $unitTesting     = true;
        $testEnvironment = 'testing';

        $app = require_once __DIR__ . '/../../../../bootstrap/start.php';

        Mail::pretend(true);
    }

    /**
     * @static
     * @beforeSuite
     */
    public static function migrateSeedDB()
    {
        echo "\n\033[36m|  " . strtr('Migrating Database...', array("\n" => "\n|  ")) . "\033[0m\n\n";
        Artisan::call('migrate');

        echo "\n\033[36m|  " . strtr('Seeding Database...', array("\n" => "\n|  ")) . "\033[0m\n\n";
        Artisan::call('db:seed');

        echo "\n\033[36m|  " . strtr('Done...', array("\n" => "\n|  ")) . "\033[0m\n\n";
        echo "\n\033[36m|  " . strtr('Starting tests...', array("\n" => "\n|  ")) . "\033[0m\n\n";
    }

    /**
     * @beforeScenario @databaseModification
     */
    public function reseedDB()
    {
        $this->printDebug('Reseeding Database...');
        Artisan::call('db:seed');
    }
}
