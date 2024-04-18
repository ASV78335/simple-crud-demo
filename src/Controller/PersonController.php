<?php

namespace App\Controller;

use App\Person\Application\GetPersonQueryHandler;
use App\Person\Application\PersonCreateCommand;
use App\Person\Application\PersonCreateCommandHandler;
use App\Person\Application\PersonDeleteCommandHandler;
use App\Person\Application\PersonUpdateCommand;
use App\Person\Application\PersonUpdateCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class PersonController extends AbstractController
{
    public function __construct(
        private readonly GetPersonQueryHandler $getQueryHandler,
        private readonly PersonCreateCommandHandler $createCommandHandler,
        private readonly PersonUpdateCommandHandler $updateCommandHandler,
        private readonly PersonDeleteCommandHandler $deleteCommandHandler
    )
    {
    }


    #[Route('/api/v1/person/{uuid}', methods: ['GET'])]
    public function get(Uuid $uuid): Response
    {
        return $this->json($this->getQueryHandler->get($uuid));
    }


    #[Route('/api/v1/person', methods: ['POST'])]
    public function create(PersonCreateCommand $request): Response
    {
        $result = $this->createCommandHandler->create($request);
        return $this->json($result);
    }


    #[Route('/api/v1/person/{uuid}', methods: ['POST'])]
    public function update(Uuid $uuid, PersonUpdateCommand $request): Response
    {
        $result = $this->updateCommandHandler->update($request, $uuid);
        return $this->json($result);
    }


    #[Route('/api/v1/person/{uuid}', methods: ['DELETE'])]
    public function delete(Uuid $uuid): Response
    {
        $this->deleteCommandHandler->delete($uuid);
        return $this->json(null);
    }
}
