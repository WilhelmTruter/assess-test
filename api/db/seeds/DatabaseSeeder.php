<?php

namespace Api\Seeders;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->truncate();

        $this->call(CurrencySeeder::class);
        $this->call(AuthorSeeder::class);
        $this->call(BookSeeder::class);
    }

    private function truncate(): void
    {
        // Disable FK checks so tables can be truncated in any order
        $this->db->exec('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->exec('TRUNCATE TABLE book_pricing');
        $this->db->exec('TRUNCATE TABLE books');
        $this->db->exec('TRUNCATE TABLE authors');
        $this->db->exec('TRUNCATE TABLE currencies');
        $this->db->exec('SET FOREIGN_KEY_CHECKS = 1');

        echo "  Tables truncated\n";
    }

    private function call(string $seederClass): void
    {
        echo "  Seeding: {$seederClass}... ";
        (new $seederClass($this->db))->run();
        echo "done\n";
    }
}