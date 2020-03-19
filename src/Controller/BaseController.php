<?php

namespace App\Controller;

use App\Helper\EntityFactoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected ObjectRepository $repository;
    protected EntityFactoryInterface $factory;

    public function __construct(EntityManagerInterface $entityManager, ObjectRepository $repository, EntityFactoryInterface $factory)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function index(Request $request) : Response
    {
        $sortCriteria = $request->query->get('sort');

        $entities = $this->repository->findBy([], $sortCriteria);

        return new JsonResponse($entities);
    }

    public function show(int $id) : Response
    {
        $entity = $this->repository->find($id);

        $responseCode = ($entity) ? Response::HTTP_OK : Response::HTTP_NO_CONTENT;

        return new JsonResponse($entity, $responseCode);
    }

    public function create(Request $request) : Response
    {
        $entity = $this->factory->create($request->getContent());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return new JsonResponse($entity, Response::HTTP_CREATED);
    }

    public function update(int $id, Request $request) : Response
    {
        $entity = $this->repository->find($id);

        if (! $entity) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->factory->update($entity, $request->getContent());

        $this->entityManager->flush();

        return new JsonResponse($entity);
    }

    public function delete(int $id)
    {
        $entity = $this->repository->find($id);

        if (! $entity) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
