<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => 'Event: ' . $faker->name,
        'schedule_date' => $faker->dateTimeInInterval($startDate = '+5 days', $interval = '+1 day', $timezone = null) 
    ];
});
