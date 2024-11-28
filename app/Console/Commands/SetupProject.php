<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'setup-project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running migrate:fresh...');
        Artisan::call('migrate:fresh');
        
        $this->info('Running db:seed...');
        Artisan::call('db:seed');
        
        $this->info('Running ConfigurationSeeder...');
        Artisan::call('db:seed', ['--class' => 'ConfigurationSeeder']);
        
        $this->info('Running EventSeeder...');
        Artisan::call('db:seed', ['--class' => 'EventSeeder']);
        
        $this->info('Project Set Up Completed successfully!');

    }
}
