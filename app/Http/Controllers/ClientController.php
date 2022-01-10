<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientListRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\Client\ClientListBuilder;
use App\Services\Client\ClientService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    public function list(ClientListRequest $request, ClientListBuilder $builder): AnonymousResourceCollection
    {
        $filters = $request->only(['query', 'sort_by']);
        $clients = $builder->getClients($filters);

        return ClientResource::collection($clients);
    }

    public function show(Client $client): ClientResource
    {
        return ClientResource::make($client);
    }

    public function update(Client $client, ClientUpdateRequest $request, ClientService $service): ClientResource
    {
        $data = $request->validated();
        $client = $service->updateClient($client, $data);

        return ClientResource::make($client);
    }

    public function delete(Client $client): Response
    {
        $client->delete();

        return response()->noContent(200);
    }
}
