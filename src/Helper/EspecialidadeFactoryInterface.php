<?php

namespace App\Helper;

use App\Entity\Especialidade;
use App\Exception\EntityFactoryException;

final class EspecialidadeFactoryInterface implements EntityFactoryInterface
{
    public function create(string $content)
    {
        $jsonContent = json_decode($content);

        $this->checkProperties($jsonContent);

        return new Especialidade($jsonContent->descricao);
    }

    public function update($entity, string $content)
    {
        $jsonContent = json_decode($content);

        $this->checkProperties($jsonContent);

        $entity->setDescricao($jsonContent->descricao);
    }

    public function checkProperties(object $json)
    {
        if (! property_exists($json, 'descricao')) {
            throw new EntityFactoryException('description should be informed!');
        }
    }
}
