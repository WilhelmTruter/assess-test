<?php

namespace Api\Seeders;

use PDO;

abstract class Seeder
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    abstract public function run(): void;
}