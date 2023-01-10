<?php

namespace App\Console\Commands;

use App\CartItem;
use App\Enquiry;
use App\Transaction;
use Illuminate\Console\Command;

class ResetTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:transactions:related:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate transactions, enquiries and cart items (after publish)';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CartItem::truncate();
        Enquiry::truncate();
        Transaction::truncate();

        $this->info('Done');
    }
}
