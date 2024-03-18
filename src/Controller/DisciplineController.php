<?php

namespace App\Controller;

use App\Model\DisciplineListResponse;
use App\Service\DisciplineService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/discipline')]
class DisciplineController extends AbstractController
{

    public function __construct(
        private readonly DisciplineService $disciplineService
    ) {
    }

    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new Model(type: DisciplineListResponse::class)
    )]
    #[Route('', name: 'discipline_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->disciplineService->getDisciplines());
    }

    // #[Route('', name: 'discipline_create', methods: ['POST'])]
    // public function create(Request $request): JsonResponse
    // {
    //     $discipline = new Discipline();
    //     $data       = $request->toArray();
    //     $name       = $data['name'];
    //     $discipline->setName($name);

    //     $this->em->persist($discipline);
    //     $this->em->flush();
    //     return $this->json([
    //         'id' => $discipline->getId(),
    //     ]);
    // }

    #[Route('/{id}', name: 'discipline_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(): JsonResponse
    {
        return $this->json([
            'message' => 'Discipline show one!',
            'path' => 'src/Controller/DisciplineController.php',
        ]);
    }

    #[Route('/{id}', name: 'discipline_edit', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function edit(): JsonResponse
    {
        return $this->json([
            'message' => 'Discipline edit!',
            'path' => 'src/Controller/DisciplineController.php',
        ]);
    }

    #[Route('/{id}', name: 'discipline_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(): JsonResponse
    {
        return $this->json([
            'message' => 'Discipline deleted!',
            'path' => 'src/Controller/DisciplineController.php',
        ]);
    }
}