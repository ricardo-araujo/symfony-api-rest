<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EspecialidadeRepository")
 */
class Especialidade implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $descricao;

    public function __construct($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getDescricao() : ?string
    {
        return $this->descricao;
    }

    public function setDescricao($descricao) : void
    {
        $this->descricao = $descricao;
    }

    public function jsonSerialize()
    {
        return [
            'id'        => $this->id,
            'descricao' => $this->descricao,
            '_links'    => [
                [
                    'rel'  => 'self',
                    'path' => sprintf('/especialidade/%s', $this->id)
                ],
                [
                    'rel'  => 'medico',
                    'path' => sprintf('/especialidade/%s/medico', $this->id)
                ]
            ],
        ];
    }
}
