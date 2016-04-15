<?php

require __DIR__ . '/../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

/**
 * $client = $apiClientRepository->findByClientId($request->get('client_id'));
 */
$client = new \stdClass();
$client->name = 'Example';
$client->validRedirectUris = ['/client-application/confirm.php'];
$client->authorizationcode = 'foobar';

if (null === $client) {
    $response = new \Symfony\Component\HttpFoundation\Response('Invalid client', 403);
    $response->send();
}

if (!in_array($request->get('redirect_uri'), $client->validRedirectUris)) {
    $response = new \Symfony\Component\HttpFoundation\Response('Invalid redirect uri', 403);
    $response->send();
}

$params = [];
$params['code'] = $client->authorizationcode;
$redirectAccept = $request->get('redirect_uri') . '?' . http_build_query($params);

$params = [];
$params['error_code'] = 1;
$redirectRefuse = $request->get('redirect_uri') . '?' . http_build_query($params);

// Valid request user may authorize
ob_start();
require 'authorize.phtml';
$html = ob_get_contents();
ob_end_clean();

$response = new \Symfony\Component\HttpFoundation\Response($html, 200);
$response->send();
