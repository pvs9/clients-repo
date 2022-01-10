<?php

use App\Models\Client;
use Illuminate\Support\Arr;

it('receives paginated client list', function () {
    Client::factory()->count(15)->create();
    $response = $this->get('/api/clients');

    $response->assertStatus(200);

    $clients = $response->json('data');
    $meta = $response->json('meta');

    expect($clients)
        ->toBeArray()
        ->toHaveCount(10);

    expect($meta)
        ->toHaveKeys(['current_page', 'total'])
        ->toHaveKey('current_page', 1)
        ->toHaveKey('total', 15);
});

it('receives correct page of paginated client list', function () {
    Client::factory()->count(15)->create();
    $response = $this->get('/api/clients?page=2');

    $response->assertStatus(200);

    $clients = $response->json('data');

    expect($clients)
        ->toBeArray()
        ->toHaveCount(5);
});

it('sorts paginated client list', function ($field) {
    Client::factory()->count(10)->create();

    $response = $this->get(sprintf('/api/clients?sort_by=%s', $field));
    $response->assertStatus(200);

    $clients = $response->json('data');
    $ids = Arr::pluck($clients, $field);
    $sortedIds = array_values(Arr::sort($ids));

    expect($ids)
        ->toMatchArray($sortedIds);
})->with([
    'id', 'name', 'updated_at', 'manager.name'
]);

it('searches clients by query in paginated client list', function ($field) {
    $clients = Client::factory()->count(10)->create();
    /** @var Client $client */
    $client = $clients->random();

    $response = $this->get(sprintf('/api/clients?query=%s', $client->{$field}));
    $response->assertStatus(200);

    $responseClients = $response->json('data');

    expect($responseClients)
        ->toBeArray()
        ->toHaveCount(1);

    expect($responseClients[0])
        ->toHaveKey('id', $client->id);
})->with([
    'id', 'name'
]);
