<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:migrations {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes migrations and adds required data';

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
     * @return mixed
     */
    public function handle()
    {
        echo "🗂 Migrating the database afresh, this might take a little while \n";
        Artisan::call('migrate:fresh');
        echo "✔ Migrations complete \n";

        Artisan::call('subscriptions:table');
        Artisan::call('countriesandstates:table');
        Artisan::call('currencies:table');

        if($this->option('seed')){
            echo "⏳ Seeding the database.. \n";
            Artisan::call('db:seed');
            echo "✔ Database seeded sucessfully \n";
        }

        echo "🎉 Time to rock, your database is all set";
    }
}
