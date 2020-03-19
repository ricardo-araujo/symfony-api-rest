<?php

namespace App\Helper;

use App\Entity\Medico;
use App\Exception\EntityFactoryException;
use App\Repository\EspecialidadeRepository;

final class MedicoFactoryInterface implements EntityFactoryInterface
{
    private EspecialidadeRepository $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {
        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function create(string $content)
    {
        $jsonContent = json_decode($content);

        $this->checkProperties($jsonContent);

        return new Medico($jsonContent->crm, $jsonContent->nome, $this->especialidadeRepository->find($jsonContent->especialidade_id));
    }

    public function update($entity, string $content)
    {
        $jsonContent = json_decode($content);

        $this->checkProperties($jsonContent);

        $entity->setCrm($jsonContent->crm);
        $entity->setNome($jsonContent->nome);
        $entity->setEspecialidade($this->especialidadeRepository->find($jsonContent->especialidade_id));
    }

    public function checkProperties(object $json)
    {
        if (! property_exists($json, 'crm')) {
            throw new EntityFactoryException('crm should be informed');
        }

        if (! property_exists($json, 'nome')) {
            throw new EntityFactoryException('name should be informed');
        }

        if (! property_exists($json, 'especialidade_id')) {
            throw new EntityFactoryException('especialidade_id should be informed');
        }
    }
}
