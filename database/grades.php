<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('grades' , function ($table){
    $table->id();
    $table->integer('student_id');
    $table->integer('subject_id');
    $table->decimal('grade' , 5,2);
    $table->datetime('exam_date')->nullable();
    $table->timestamps();
});


?>