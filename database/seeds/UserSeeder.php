<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=150000;$i++) {
            $user = new User([
                'email' => "user_$i@sendlane.com",
                'first_name' => "fname_$i",
                'last_name' => "lname_$i"
            ]);

            $user->save();
            unset($user);
        }
    }
}
