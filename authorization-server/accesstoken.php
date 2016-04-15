<?php

require __DIR__ . '/../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

/**
 * $client = $apiClientRepository->findByClientId($request->get('client_id'));
 */
$client = new \stdClass();
$client->name = 'Example';
$client->secret = 'bar';
$client->validRedirectUris = ['/client-application/confirm.php'];
$client->authorizationcode = 'foobar';

if (null === $client || $client->secret !== $request->get('client_secret')) {
    $response = new \Symfony\Component\HttpFoundation\Response('Invalid client', 403);
    $response->send();
}

switch ($request->get('grant_type')) {
    case 'authorization_code':
        /**
         * $authorizationcode = $apiClientRepository->findByClientId($request->get('code'));
         */
        $authorizationcode = new \stdClass();
        $authorizationcode->client = $client;

        if (null === $authorizationcode || $authorizationcode->client !== $client) {
            $response = new \Symfony\Component\HttpFoundation\Response('Invalid authorization code', 403);
            $response->send();
        }

        /**
         * Generate accesstoken for the client application with a limited lifetime
         */
        $accessToken = new stdClass();
        $accessToken->token = 'abc123456';
        $accessToken->expiresIn = 3600;

        $response = new \Symfony\Component\HttpFoundation\JsonResponse($accessToken);
        $response->send();
        break;
    default:
        $response = new \Symfony\Component\HttpFoundation\Response('Invalid grant type', 403);
        $response->send();
}




