<?php

use Faker\Generator as Faker;
use Orqlog\YacampaignDrawLaravel\Domain\Repository\DrawCampaignRepository;

$factory->define(DrawCampaignRepository::class, function (Faker $faker) {
    $now = new \DateTime();
    return [
        'title' => $faker->name,
        'description' => 'The campaign description',
        'start_at' => $now,
        'end_at' => $now->add(New \DateInterval('PT2H')),
    ];
});
