<?php

declare(strict_types=1);

it('redirects unauthenticated users from /backend to /login', function () {
    $response = $this->get('/backend');

    $response->assertRedirect('/login');
});
