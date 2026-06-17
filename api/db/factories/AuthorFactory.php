<?php

namespace Api\Factories;

class AuthorFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name'  => $this->faker->lastName(),
        ];
    }

    protected function tableName(): string
    {
        return 'authors';
    }
}