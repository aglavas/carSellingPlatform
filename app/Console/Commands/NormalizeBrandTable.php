<?php

namespace App\Console\Commands;

use App\Brand;
use Illuminate\Console\Command;

class NormalizeBrandTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'normalize:brands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Normalize brand table (to upper)';

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
        $brandCollection = Brand::get();

        foreach ($brandCollection as $brand) {
            $brandName = $brand->name;

            $brandName = strtoupper(trim($brandName));

            $brand->name = $brandName;

            $brand->save();
        }

        $this->info('Completed');

        return true;
    }
}
