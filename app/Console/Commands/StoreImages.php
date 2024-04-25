<?php

namespace App\Console\Commands;

use App\Services\ImageStorageService;
use Illuminate\Console\Command;

class StoreImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:store-images {size}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store all Images in the Database to local disk using defined size';

    /**
     * Execute the console command.
     */
    public function handle(ImageStorageService $service)
    {
        $service->StoreAll($this->argument('size'));
    }
}
