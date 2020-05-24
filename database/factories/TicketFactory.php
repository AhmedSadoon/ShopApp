<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence,
        'message'=>$faker->paragraph(6),
        'ticket_type_id'=>$faker->numberBetween(1,4),
        'user_id' =>$faker->numberBetween(1,500),
        'order_id' =>$faker->numberBetween(1,50),
        'status'=>$faker->randomElement(['panding','closed','waiting']),

    ];
});
