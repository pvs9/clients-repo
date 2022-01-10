<?php

namespace App\Services\Client;

use App\Models\Client;

class ClientService
{
    public function updateClient(Client $client, array $data): Client
    {
        $client->fill($data);

        if (isset($data['manager_id'])) {
            $client->manager()->associate($data['manager_id']);
        }

        $client->save();

        return $client;
    }
}
