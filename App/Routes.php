<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/api/properties', '\Spotahome\App\Controllers\PropertyController:listAction')->setName('property-list');
