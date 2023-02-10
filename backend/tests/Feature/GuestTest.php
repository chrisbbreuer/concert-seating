<?php

test('It should successfully request from /random-matrix', function () {
    $response = $this->get('/api/random-matrix');

    $response->assertStatus(200);
});

test('It is expected to return array', function () {
    $response = $this->get('/api/random-matrix');

    expect($response->getData())->toBeArray(true);
});
