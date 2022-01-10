<?php

namespace App\Services\Client;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ClientListBuilder
{
    protected Builder $query;

    protected function getQuery(): Builder
    {
        return $this->query;
    }

    protected function setQuery(): static
    {
        $this->query = Client::query();

        return $this;
    }

    protected function applySearch(string $search): static
    {
        $isNumber = is_numeric($search);

        $this->getQuery()
            ->where(function (Builder $query) use ($isNumber, $search) {
                $query
                    ->where('name', 'ilike', "%{$search}%")
                    ->orWhereHas('manager', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%");
                    })
                    ->when($isNumber, function ($query) use ($search) {
                        return $query->orWhere('id', $search);
                    });
            });

        return $this;
    }

    protected function applySorting(string $sortBy): static
    {
        $sortByManager = $sortBy === 'manager.name';

        if ($sortByManager) {
            $this->getQuery()
                ->join('users', 'users.id', '=', 'clients.manager_id')
                ->orderBy('users.name');
        } else {
            $this->getQuery()
                ->orderBy($sortBy);
        }

        return $this;
    }

    protected function loadNecessaryRelations(): static
    {
        $this->getQuery()
            ->with('manager');

        return $this;
    }

    public function getClients(array $filters = []): LengthAwarePaginator
    {
        $this->setQuery()
            ->loadNecessaryRelations();

        if (isset($filters['sort_by'])) {
            $this->applySorting($filters['sort_by']);
        }

        if (isset($filters['query'])) {
            $this->applySearch($filters['query']);
        }

        return $this->getQuery()
            ->paginate(10);
    }
}
