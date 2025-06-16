<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('attendance' , function ($table){
    $table->id();
    $table->integer('student_id');
    $table->integer('class_id');
    $table->integer('subject_id');
    $table->datetime('date');
    $table->enum('status' , ['present','absent','late']);
    $table->timestamps();
});

?>