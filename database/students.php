<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('students', function ($table){
    $table->id();
    $table->integer('user_id');
    $table->integer('class_id');
    $table->enum('gender' , ['male','female']);
    $table->date('date_of_birth');
    $table->timestamps();
});
?>