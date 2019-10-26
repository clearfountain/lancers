<?php

namespace App\Console\Commands;

use App\State;
use App\Country;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AddDataToCountriesAndStatesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countriesandstates:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add the countries and states data in the database';

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
        $path = base_path() . "/resources/json/countries.json";
        $file = File::get($path);
        $countries =  json_decode($file, true );

        echo "emptying tables \n";
        // Country::truncate();
        // State::truncate();



        $c = [];
        $s = [];
        $now = Carbon::now();
        foreach ($countries['countries'] as $country_id => $country) {
           $c[] = [
                'name' => $country['country'],
                'created_at' => $now,
                'updated_at' => $now
           ];

           foreach ($country['states'] as $state) {
               $s[] = [
                    'name' => $state,
                    'country_id' => $country_id + 1,
                    'created_at' => $now,
                    'updated_at' => $now
               ];
           }
        }

        echo "Inserting values \n";
        foreach($c as $country){
            Country::updateOrCreate(['name'=>$country['name']], $country);
        }
        foreach($s as $state){
            State::updateOrCreate(['name'=>$state['name'], 'country_id'=>$state['country_id']], $state);
        }

        // Country::insert($c);
        // State::insert($s);

        echo "done ✓";
    }
}
