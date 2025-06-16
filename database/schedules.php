<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('schedules' , function ($table){
    $table->id();
    $table->integer('class_id');
    $table->integer('subject_id');
    $table->integer('teacher_id');
    $table->enum('day_of_week' , ['Monday','Tuesday','Wednesday','Thursday','Friday']);
    $table->datetime('start_time')->nullable();
    $table->datetime('end_time')->nullable();
    $table->timestamps();
});

?>