<?php

namespace App\Controller;

use App\Helper\EspecialidadeFactoryInterface;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;

class EspecialidadeController extends BaseController
{
    public function __construct(EntityManagerInterface $entityManager, EspecialidadeRepository $repository, EspecialidadeFactoryInterface $factory)
    {
        parent::__construct($entityManager, $repository, $factory);
    }
}
