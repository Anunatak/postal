<?php namespace Anunatak\Postal\Command;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Anunatak\Postal\Parser;
use DB;

class ParseCommand extends Command
{
    /**
     * Name of the command.
     * 
     * @param string
     */
    protected $name = 'postal:update';
    
    /**
     * Necessary to let people know, in case the name wasn't clear enough.
     * 
     * @param string
     */
    protected $description = 'Update the database';
    
    /**
     * Setup the application container as we'll need this for running migrations.
     */
    public function __construct(Container $app) {
        parent::__construct();
        $this->app = $app;
    }

    /**
    * Get the console command options.
    *
    * @return array
    */
    protected function getOptions() {
        return array(
            array('force', 'f', InputOption::VALUE_NONE,
            'Forces the update', null),
        );
    }
    
    /**
     * Run the package migrations.
     */
    public function handle() {

        $force = false;

        if( $this->option('force') ) {
            $this->info('Forcing update...');
            $force = true;
        }

        $parser = new \Anunatak\Postal\Parser($force);

        if( is_array($parser->data) ) {

            // first truncate table
            $this->info('Truncating table...');
            DB::table('postal')->truncate();

            // insert all rows
            $this->info('Inserting postal codes into table...');
            DB::table('postal')->insert($parser->data);

            // all done
            $this->info('All done!');

        }
        
    }
}