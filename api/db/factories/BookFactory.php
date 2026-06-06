<?php

namespace Api\Factories;

class BookFactory extends Factory
{
    protected function definition(): array
    {
        // Pick a random existing author — must run after AuthorSeeder
        $authorId = (int) $this->db
            ->query('SELECT id FROM authors ORDER BY RAND() LIMIT 1')
            ->fetchColumn();

        return [
            'title'     => rtrim($this->faker->sentence(rand(2, 5)), '.'),
            'author_id' => $authorId,
        ];
    }

    protected function tableName(): string
    {
        return 'books';
    }
}