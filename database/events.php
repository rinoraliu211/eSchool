<?php

require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('events' , function ($table){
    $table->id();
    $table->string('title', 100);
    $table->text('description')->nullable();
    $table->datetime('event_date')->nullable();
    $table->timestamps();
});

?>