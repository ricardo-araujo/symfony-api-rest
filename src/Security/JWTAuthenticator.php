<?php

namespace App\Security;

use App\Repository\UserRepository;
use Exception;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JWTAuthenticator extends AbstractGuardAuthenticator
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function supports(Request $request)
    {
        return $request->getPathInfo() !== '/login';
    }

    public function getCredentials(Request $request)
    {
        try {

            $token = str_ireplace('Bearer ', '', $request->headers->get('Authorization'));

            return JWT::decode($token, 'test_key', ['HS256']);

        } catch (Exception $exception) {

            return false;

        }
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (! is_object($credentials) or ! property_exists($credentials, 'username')) {
            return null;
        }

        return $this->repository->findOneBy(['username' => $credentials->username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return is_object($credentials) and property_exists($credentials, 'username');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse('authentication failure!', Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
