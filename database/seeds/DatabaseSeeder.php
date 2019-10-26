<?php

use App\Subscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([//(UsersTableSeeder::class);
        // // $this->call(DocumentsTableSeeder::class);
        // TasksTableSeeder::class,
        // ]); 
        factory(App\User::class, 10)->create()->each(function ($user){
            $name = explode(" ",$user->name);
            $user->profile()->create(['first_name' => $name[0], 'last_name' => $name[1]]);

            $subscriber = new Subscription;
            $subscriber->subscribeToPlan(1 , $user->id, 12);
        });

        // factory(App\Project::class, 50)->create()->each(function ($project) {
        //     $estimate = $project->estimate()->save(factory(App\Estimate::class)->make());
        //     $client = factory(App\Client::class, 1)->create(['user_id' => $project->user_id]);
        //     $project->update(['estimate_id' =>$estimate->id, 'client_id' => $project->id]);
        // });
        
        factory(App\Estimate::class, 50)->create()->each(function ($estimate) {
            $client = factory(App\Client::class, 3)->create(['user_id' => $estimate->user_id])
            ->each(function ($client) use($estimate){
                $project = $estimate->project()->save(factory(App\Project::class)->make());
                $project->update(['client_id' => $client->id]);
            });
        });

        // factory(App\Estimate::class, 100)->create();

        factory(App\Task::class, 100)->create();
    }
}
