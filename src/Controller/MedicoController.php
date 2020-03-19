<?php

namespace App\Controller;

use App\Helper\MedicoFactoryInterface;
use App\Repository\EspecialidadeRepository;
use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicoController extends BaseController
{
    public function __construct(EntityManagerInterface $entityManager, MedicoRepository $medicoRepository, MedicoFactoryInterface $factory, EspecialidadeRepository $especialidadeRepository)
    {
        parent::__construct($entityManager, $medicoRepository, $factory);
    }

    /**
     * @Route("/especialidade/{especialidadeId}/medico", methods={"GET"})
     */
    public function speciality(int $especialidadeId) : Response
    {
        $medicos = $this->repository->findBy(['especialidade' => $especialidadeId]);

        $responseCode = ($medicos) ? Response::HTTP_OK : Response::HTTP_NO_CONTENT;

        return new JsonResponse($medicos, $responseCode);
    }
}
