<?php

namespace App\Shared\Domain;

interface EntityRepositoryInterface
{
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null);

}
