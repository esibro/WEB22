<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); //primarykey
            $table->string('subject')->unique();
            $table->string('level');
            $table->text('description')->nullable();
            $table->string('state');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('student_id')->nullable();

            // fk user constraint
            //$table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('courses');
           }
}
