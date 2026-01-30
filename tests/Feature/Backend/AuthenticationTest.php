<?php

it('redirects unauthenticated users from /backend to /login', function () {
    $response = $this->get('/backend');

    $response->assertRedirect('/login');
});
