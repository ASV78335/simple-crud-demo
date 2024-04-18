<?php

namespace App\Person\Application;

use App\Person\Domain\Person;
use App\Person\Domain\PersonRepositoryInterface;
use App\Shared\Domain\BusinessLogicException;
use Exception;

class PersonCreateCommandHandler
{
    public function __construct(private readonly PersonRepositoryInterface $personRepository)
    {
    }

    public function create(PersonCreateCommand $command): PersonItem
    {
        try {
            $person = Person::fromCreateRequest($command);
            $this->personRepository->save($person);
        }
        catch (Exception) {
            throw new BusinessLogicException('Error while saving');
        }

        return $person->toResponseItem();
    }
}
