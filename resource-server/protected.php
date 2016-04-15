<?php

require __DIR__ . '/../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$accesstoken = 'abc123456';

$authorizationHeader = $request->headers->get('Authorization');

if (!$authorizationHeader
    || substr($authorizationHeader, 0, 7) !== 'Bearer '
    || substr($authorizationHeader, 7) !== $accesstoken
) {
    $response = new \Symfony\Component\HttpFoundation\Response('Unauthorized', 401);
    $response->send();
}

$reponse = new \Symfony\Component\HttpFoundation\JsonResponse([
    'id' => 1,
    'name' => 'name',
    'email' => 'email@domain.com',
]);

$reponse->send();
