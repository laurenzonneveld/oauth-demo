<?php

require __DIR__ . '/../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$clientId = 'foo';
$clientSecret = 'bar';

if ($request->get('error_code') || !$request->get('code')) {
    $response = new \Symfony\Component\HttpFoundation\RedirectResponse('index.php?failed=1');
    $response->send();
}

$guzzleClient = new \GuzzleHttp\Client();

/**
 * Authorization server redirected the client browser and we now have an authorization code
 * With this authorization code and our application id and secret we can request an accesstoken
 */
try {
    $accesstokenResponse = $guzzleClient->post('//' . $request->getHost() . '/authorization-server/accesstoken.php', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'code' => $request->get('code'),
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]
    ]);
} catch (GuzzleHttp\Exception\ClientException $e) {
    // Authorization code might be expired, request a new one (/login)
    exit;
} catch (GuzzleHttp\Exception\ServerException $e) {
    // Authorization server has issues, redirect and display a message that oauth is unavailable for this provider
    exit;
}

$accesstoken = json_decode($accesstokenResponse->getBody());

/**
 * We have an accesstoken
 * We can now access the protected resource
 */
try {
    $apiResponse = $guzzleClient->get('//' . $request->getHost() . '/resource-server/protected.php', [
        'headers' => [
            'Authorization' => 'Bearer ' . $accesstoken->token
        ]
    ]);
} catch (GuzzleHttp\Exception\ClientException $e) {
    // Accesstoken is probably expired
    exit;
} catch (GuzzleHttp\Exception\ServerException $e) {
    // Resource server has issues
    exit;
}

$data = json_decode($apiResponse->getBody(), true);

ob_start();
require 'profile.phtml';
$html = ob_get_contents();
ob_end_clean();

$response = new \Symfony\Component\HttpFoundation\Response($html, 200);
$response->send();