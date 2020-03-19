<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicoRepository")
 */
class Medico implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $crm;

    /**
     * @ORM\Column(type="string")
     */
    private string $nome;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Especialidade")
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidade;

    public function __construct($crm, $nome, $especialidade)
    {
        $this->crm = $crm;
        $this->nome = $nome;
        $this->especialidade = $especialidade;
    }

    public function getCrm() : ?int
    {
        return $this->crm;
    }

    public function setCrm($crm) : void
    {
        $this->crm = $crm;
    }

    public function getNome() : ?string
    {
        return $this->nome;
    }

    public function setNome($nome) : void
    {
        $this->nome = $nome;
    }

    public function getEspecialidade()
    {
        return $this->especialidade;
    }

    public function setEspecialidade($especialidade) : void
    {
        $this->especialidade = $especialidade;
    }

    public function jsonSerialize()
    {
        return [
            'id'               => $this->id,
            'crm'              => $this->crm,
            'nome'             => $this->nome,
            'especialidade_id' => $this->especialidade->getId(),
            '_links'           => [
                [
                    'rel'  => 'self',
                    'path' => sprintf('/medico/%s', $this->id),
                ],
                [
                    'rel'  => 'especialidade',
                    'path' => sprintf('/especialidade/%s', $this->especialidade->getId()),
                ],
            ],
        ];
    }
}
