<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('class_student' , function ($table){
    $table->id();
    $table->integer('student_id');
    $table->integer('class_id');
    $table->timestamps();
});

?>