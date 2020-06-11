<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'content' => 'notOverDays',
        'due_date' => '2030-01-01',
    ];
});
