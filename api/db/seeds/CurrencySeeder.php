<?php

namespace Api\Seeders;

class CurrencySeeder extends Seeder
{
    private array $currencies = ['ZAR', 'USD', 'EUR', 'GBP', 'AUD'];

    public function run(): void
    {
        $stmt = $this->db->prepare('INSERT INTO currencies (iso) VALUES (:iso)');

        foreach ($this->currencies as $iso) {
            $stmt->execute([':iso' => $iso]);
        }
    }
}