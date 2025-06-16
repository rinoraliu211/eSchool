<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('users', function ($table) {

    $table->id();
    $table->string('first_name', 30);
    $table->string('last_name', 30);
    $table->string('email')->unique();
    $table->string('password', 50);
    $table->enum('role', ['admin','teacher','student'])->default('student');
    $table->timestamps();
});

?>