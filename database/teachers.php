<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('teachers' , function ($table){
    $table->id();
    $table->integer('user_id');
    $table->string('subject_specialty' , 50);
    $table->date('date_of_birth');
    $table->enum('gender' , ['male','female']);
    $table->timestamps();
});

?>