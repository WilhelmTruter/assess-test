<?php

namespace Api\Factories;

class BookPricingFactory extends Factory
{
    protected function definition(): array
    {
        // Pick a random existing currency — must run after CurrencySeeder
        $currencyId = (int) $this->db
            ->query('SELECT id FROM currencies ORDER BY RAND() LIMIT 1')
            ->fetchColumn();

        return [
            'book_id'     => 0,   // always overridden via state()
            'currency_id' => $currencyId,
            'price'       => $this->faker->randomFloat(2, 5, 200),
        ];
    }

    protected function tableName(): string
    {
        return 'book_pricing';
    }
}