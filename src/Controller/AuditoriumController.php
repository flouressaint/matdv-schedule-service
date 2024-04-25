<?php

namespace App\Controller;

use App\Model\CreateAuditoriumRequest;
use App\Model\UpdateAuditoriumRequest;
use App\Service\AuditoriumService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/auditorium')]
class AuditoriumController extends AbstractController
{
    public function __construct(
        private readonly AuditoriumService $auditoriumService
    ) {
    }

    #[Route('', name: 'auditorium_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->auditoriumService->getAuditoriums());
    }

    #[Route('/{id}', name: 'auditorium_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json($this->auditoriumService->getAuditorium($id));
    }

    #[Route('', name: 'auditorium_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateAuditoriumRequest $request): JsonResponse
    {
        return $this->json($this->auditoriumService->createAuditorium($request));
    }

    #[Route('', name: 'auditorium_update', methods: ['UPDATE'])]
    public function edit(int $id, #[MapRequestPayload] UpdateAuditoriumRequest $request): JsonResponse
    {
        $this->auditoriumService->updateAuditorium($id, $request);

        return $this->json(null);
    }

    #[Route('/{id}', name: 'auditorium_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->auditoriumService->deleteAuditorium($id);

        return $this->json(null);
    }
}
