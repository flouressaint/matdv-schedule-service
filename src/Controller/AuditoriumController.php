<?php

namespace App\Controller;

use App\Service\AuditoriumService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}
