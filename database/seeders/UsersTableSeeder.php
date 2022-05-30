<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user = new User();
        $user->firstname = 'Esma';
        $user->lastname = 'Gürsoy';
        $user->email = 'esmaguersoy@gmail.com';
        $user->password = bcrypt('password123');
        $user->description = 'Professionelle Lerntrainerin';
        $user->isTeacher = true;
        $user->save();

        $user1 = new User();
        $user1->firstname = 'Hannelore';
        $user1->lastname = 'Siedl';
        $user1->email = 'hanneloresiedl@gmail.com';
        $user1->password = bcrypt('password1234');
        $user1->description = 'Lehramt Studentin Mathematik';
        $user1->isTeacher = true;
        $user1->save();
    }
}
