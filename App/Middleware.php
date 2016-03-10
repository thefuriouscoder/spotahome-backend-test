<?php
// Application middleware

// Adjust headers of response if content is json and enable CORS
$app->add(function(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $next) {
    $response = $next($request, $response);
    $body = $response->getBody();

    if(empty(json_decode($body))) return $response;

    $response = $response->withBody(
        new \Slim\Http\Body(fopen('php://temp', 'r+'))
    );
    $response->write($body);

    $response = $response->withAddedHeader('Content-Type','application/json');
    $response = $response->withAddedHeader('Access-Control-Allow-Origin', '*');
    $response = $response->withAddedHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-authentication, X-client');
    $response = $response->withAddedHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');

    return $response;

});

