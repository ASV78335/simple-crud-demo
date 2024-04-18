<?php

namespace App\Person\Application;

use App\Person\Domain\PersonRepositoryInterface;
use App\Shared\Domain\BusinessLogicException;
use Exception;
use Symfony\Component\Uid\Uuid;

class PersonDeleteCommandHandler
{
    public function __construct(private readonly PersonRepositoryInterface $personRepository)
    {
    }

    public function delete(Uuid $uuid): void
    {
        $person = $this->personRepository->findOneBy(['id' => $uuid, 'deletedAt' => null]);
        if (!$person) throw new BusinessLogicException('Person not found');

        try {
        $person->makeDeleted();
        $this->personRepository->save($person);
        }
        catch (Exception) {
            throw new BusinessLogicException('Error while saving');
        }
    }
}
