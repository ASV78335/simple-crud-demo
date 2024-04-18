<?php

namespace App\Person\Application;

use App\Person\Domain\PersonRepositoryInterface;
use App\Shared\Domain\BusinessLogicException;
use Symfony\Component\Uid\Uuid;

class GetPersonQueryHandler
{
    public function __construct(private readonly PersonRepositoryInterface $personRepository)
    {
    }

    public function get(Uuid $uuid): PersonItem
    {
        $person = $this->personRepository->findOneBy(['id' => $uuid, 'deletedAt' => null]);
        if (!$person) throw new BusinessLogicException('Person not found');

        return $person->toResponseItem();
    }
}
