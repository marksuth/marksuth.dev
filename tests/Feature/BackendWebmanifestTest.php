<?php

it('can access backend webmanifest without authentication', function () {
    $response = $this->get('/backend/backend.webmanifest');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/manifest+json');
    $response->assertJsonStructure([
        'name',
        'short_name',
        'icons',
        'theme_color',
        'background_color',
        'display',
        'start_url',
        'shortcuts',
    ]);
});
