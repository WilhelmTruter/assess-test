<?php

namespace Api\Factories;

use Faker\Generator;
use PDO;

abstract class Factory
{
    protected PDO $db;
    protected Generator $faker;
    protected int $count = 1;
    protected array $overrides = [];

    public function __construct(PDO $db)
    {
        $this->db    = $db;
        $this->faker = \Faker\Factory::create('en_US');
    }

    // Define default attribute values for one record
    abstract protected function definition(): array;

    // The database table to insert into
    abstract protected function tableName(): string;

    // Set how many records to create
    public function count(int $count): self
    {
        $clone        = clone $this;
        $clone->count = $count;
        return $clone;
    }

    // Override specific attributes
    public function state(array $overrides): self
    {
        $clone            = clone $this;
        $clone->overrides = array_merge($this->overrides, $overrides);
        return $clone;
    }

    // Build record(s) without persisting
    public function make(): array
    {
        if ($this->count === 1) {
            return array_merge($this->definition(), $this->overrides);
        }

        $results = [];
        for ($i = 0; $i < $this->count; $i++) {
            $results[] = array_merge($this->definition(), $this->overrides);
        }
        return $results;
    }

    // Persist record(s) and return with IDs
    public function create(): array
    {
        if ($this->count === 1) {
            return $this->insert(
                array_merge($this->definition(), $this->overrides)
            );
        }

        $created = [];
        for ($i = 0; $i < $this->count; $i++) {
            $created[] = $this->insert(
                array_merge($this->definition(), $this->overrides)
            );
        }
        return $created;
    }

    private function insert(array $record): array
    {
        $columns      = implode(', ', array_keys($record));
        $placeholders = implode(', ', array_map(fn($k) => ':' . $k, array_keys($record)));

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->tableName()} ({$columns}) VALUES ({$placeholders})"
        );
        $stmt->execute($record);

        return array_merge($record, ['id' => (int) $this->db->lastInsertId()]);
    }
}