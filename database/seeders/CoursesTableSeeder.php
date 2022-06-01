<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = new Course();
        $course->subject = "Deutsch";
        $course->level = "Mittelstufe";
        $course->description = "Für alle Loser";
        $course->state= "available";
        $course->user_id = "1";

        $course->save();
        $date1 = new \App\Models\Timeslots;
        $date1->date = '2022-05-20 18:00:00';

        $date2 = new \App\Models\Timeslots;
        $date2->date = '2022-05-22 17:30:00';
        $course->timeslots()->saveMany([$date1,$date2]);

        $users= User::all()->pluck('id');
        $course->users()->sync($users);

        $course->save();

    }
}
