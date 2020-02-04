<?php
/**
 * seeders plugin for Craft CMS 3.x
 *
 * Create custom seeder classes in Craft3. 
 *
 * @link      https://codezone.io
 * @copyright Copyright (c) 2020 CodeZone
 */

namespace CodeZone\seeders\console\controllers;

use CodeZone\seeders\exceptions\SeederException;
use CodeZone\seeders\Seeders;
use craft\console\Controller;

/**
 * Default Command
 *
 * The first line of this class docblock is displayed as the description
 * of the Console Command in ./craft help
 *
 * Craft can be invoked via commandline console by using the `./craft` command
 * from the project root.
 *
 * Console Commands are just controllers that are invoked to handle console
 * actions. The segment routing is plugin-name/controller-name/action-name
 *
 * The actionIndex() method is what is executed if no sub-commands are supplied, e.g.:
 *
 * ./craft seeders/default
 *
 * Actions must be in 'kebab-case' so actionDoSomething() maps to 'do-something',
 * and would be invoked via:
 *
 * ./craft seeders/default/do-something
 *
 * @author    CodeZone
 * @package   Seeders
 * @since     0.0.0
 */
class RunController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Run a seeder class to populate your database.
     *
     * @return mixed
     */
    public function actionSeeder($seeder = null)
    {
        if (!$seeder && $default = Seeders::$plugin->getSettings()->default) {
            $seeder = $default;
        }

        if (!$seeder) {
            return $this->stderr('A seeder class or handle must be provided if no default seeder is configured.' . PHP_EOL);
        }

        try {
            $seeder = Seeders::$plugin->seeders->factory($seeder);
        } catch (SeederException $seederException) {
            return $this->stderr($seederException->getMessage() . PHP_EOL);
        }

        $this->stdout("Running the seeder: " . get_class($seeder) . PHP_EOL);

        //try {
            $seeder->run();
            $this->stdout('Seed complete.' . PHP_EOL);
        //} catch (\Exception $exception) {
            //$this->stderr('Error running seeder: ' . $exception->getMessage() . PHP_EOL);
        //}
    }
}
