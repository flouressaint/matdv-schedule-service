<?php

namespace App\Controller;

use App\Model\CreateHometaskRequest;
use App\Model\UpdateHometaskRequest;
use App\Service\HometaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/hometask')]
class HometaskController extends AbstractController
{
    public function __construct(
        private readonly HometaskService $hometaskService
    ) {
    }

    #[Route('/{id}', name: 'hometask_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json($this->hometaskService->getHometask($id));
    }

    #[Route('', name: 'hometask_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateHometaskRequest $request): JsonResponse
    {
        return $this->json($this->hometaskService->createHometask($request));
    }

    #[Route('/{id}', name: 'hometask_update', methods: ['PUT'])]
    public function edit(int $id, #[MapRequestPayload] UpdateHometaskRequest $request): JsonResponse
    {
        $this->hometaskService->updateHometask($id, $request);

        return $this->json(null);
    }

    #[Route('/{id}', name: 'hometask_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->hometaskService->deleteHometask($id);

        return $this->json(null);
    }
}