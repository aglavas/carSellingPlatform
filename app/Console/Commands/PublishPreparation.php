<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PublishPreparation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:preparation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepares production DB for major publish. (after publish)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Publish preparation command
     */
    public function handle()
    {
        //Ensure API users consistency

        $this->info('Ensure API users consistency.');
        $this->call('check:api:users:roles');
        $this->info('Ensuring API users consistency is completed.');

        //Set vehicle type to users

        $this->info('Set vehicle type to users.');
        $this->call('users:set:vehicle-type');
        $this->info('Set vehicle type to users is completed.');

        //Set stock type to users

        $this->info('Set stock type to users.');
        $this->call('users:set:stock-type');
        $this->info('Set stock type to users is completed.');

        //Normalize brand table

        $this->info('Normalize brand table.');
        $this->call('normalize:brands');
        $this->info('Normalize brand table is completed.');

        //Reset filter searches

        $this->info('Reset filter searches.');
        $this->call('reset:filter:searches');
        $this->info('Reset filter searches is completed.');

        //Reset transactions and related data (cart items, enquiries)

        $this->info('Reset transactions and related data.');
        $this->call('reset:transactions:related:data');
        $this->info('Reset transactions and related data is completed.');

        //Reset frontend notifications

        $this->info('Reset frontend notifications.');
        $this->call('reset:frontend:notifications');
        $this->info('Reset frontend notifications is completed.');

        //Set buyer role to users

        $this->info('Set buyer role.');
        $this->call('set:buyer:role');
        $this->info('Set buyer role is completed.');
    }
}
