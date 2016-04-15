<?php

require __DIR__ . '/../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

/**
 * Client application owners have registered their application with the authorization server
 * Upon registration they have received a clientId and a client secret
 */
$clientId = 'foo';
$clientSecret = 'bar';

$params = [];
$params['client_id'] = $clientId;

// This is an absolute URL in real applications, since its cross domain
$params['redirect_uri'] = '/client-application/confirm.php';

// As client application we must define what we want
$params['scope'] = 'profile,email';

// Redirect the users browser to the authorization server
$response = new \Symfony\Component\HttpFoundation\RedirectResponse(
    '/authorization-server/authorizationcode.php?' . http_build_query($params)
);
$response->send();
