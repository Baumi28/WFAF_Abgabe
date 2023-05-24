<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Entry zu User hinzufügen
        $user1 = new \App\Models\User();
        $user1->firstName = "Tobias";
        $user1->lastName = "Kothbauer";
        $user1->email = "Kothbauer@gmail.com";
        $user1->password = bcrypt('secret');
        $user1->save();

        $user2 = new \App\Models\User();
        $user2->firstName = "Maxi";
        $user2->lastName = "Baumi";
        $user2->email = "Baumi@gmail.com";
        $user2->password = bcrypt('secret');
        $user2->save();

        $user3 = new \App\Models\User();
        $user3->firstName = "Franz";
        $user3->lastName = "Maier";
        $user3->email = "Maier@gmail.com";
        $user3->password = bcrypt('secret');
        $user3->save();
    }
}
