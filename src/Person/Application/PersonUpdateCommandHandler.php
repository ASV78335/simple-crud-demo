<?php

namespace App\Person\Application;

use App\Person\Domain\Person;
use App\Person\Domain\PersonRepositoryInterface;
use App\Shared\Domain\BusinessLogicException;
use Exception;
use Symfony\Component\Uid\Uuid;

class PersonUpdateCommandHandler
{
    public function __construct(private readonly PersonRepositoryInterface $personRepository)
    {
    }

    public function update(PersonUpdateCommand $command, Uuid $uuid): PersonItem
    {
        $person = $this->personRepository->findOneBy(['id' => $uuid, 'deletedAt' => null]);
        if (!$person) throw new BusinessLogicException('Person not found');

        try {
        $person = Person::fromUpdateRequest($person, $command);
        $this->personRepository->save($person);
        }
        catch (Exception) {
            throw new BusinessLogicException('Error while saving');
        }

        return $person->toResponseItem();
    }
}
