<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PadletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $padlet1 = new \App\Models\Padlet();
        $padlet1->title = "Mein erstes Padlet";
        $padlet1->isPublic = 1;

        //Speichern in Datenbank
        $padlet1->save();

        $padlet2 = new \App\Models\Padlet();
        $padlet2->title = "Mein zweites Padlet";
        $padlet2->isPublic = 0;

        $padlet2->save();

        $entry1 = new \App\Models\Entry();
        $entry1->title = "Im Seeder erstellter Eintrag 1";
        $entry1->description = "Beschreibung Eintrag 1";

        /*
        //Ersten user erhalten
        $user = \App\Models\User::first(); // Hier muss der entsprechende Benutzer ausgewählt werden
        $entry1->user()->associate($user);
        $entry1->save();
*/


        //Entry zu Padlet hinzufügen


        $entry2 = new \App\Models\Entry();
        $entry2->title = "Im Seeder erstellter Eintrag 2";
        $entry2->description = "Beschreibung Eintrag 2";

        $padlet1->entries()->saveMany([$entry1, $entry2]);

        //Rating zu Entry hinzufügen
        $rating1 = new \App\Models\Rating();
        $rating1->rating = 5;

        $rating2 = new \App\Models\Rating();
        $rating2->rating = 3;

        //Comment zu Entry hinzufügen
        $comment1 = new \App\Models\Comment();
        $comment1->content = "Das ist der Text von Kommentar 1";

        $comment2 = new \App\Models\Comment();
        $comment2->content = "Das ist der Text von Kommentar 2";

        $entry1->ratings()->saveMany([$rating1, $rating2]);
        $entry1->comments()->saveMany([$comment1, $comment2]);

        $users = User::all()->pluck("id");
        $padlet1->users()->sync($users);
    }
}
