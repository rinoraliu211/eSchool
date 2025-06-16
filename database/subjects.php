<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('subjects' , function ($table){
    $table->id();
    $table->string('name' , 30);
    $table->string('code', 30);
    $table->integer('teacher_id');
    $table->timestamps();
});

?> 