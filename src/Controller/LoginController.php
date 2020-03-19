<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    private UserRepository $repository;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    public function login(Request $request)
    {
        $jsonContent = json_decode($request->getContent());

        if (in_array(null, [@$jsonContent->username, @$jsonContent->password])) {
            return new JsonResponse('username and password must be informed!', Response::HTTP_BAD_REQUEST);
        }

        $entity = $this->repository->findOneBy(['username' => $jsonContent->username]);

        if (! $entity) {
            return new JsonResponse('user not found!', Response::HTTP_NOT_FOUND);
        }

        if (! $this->encoder->isPasswordValid($entity, $jsonContent->password)) {
            return new JsonResponse('invalid password!', Response::HTTP_UNAUTHORIZED);
        }

        $jwt = JWT::encode(['username' => $entity->getUsername()], 'test_key');

        return new JsonResponse(['access_token' => $jwt]);
    }
}
