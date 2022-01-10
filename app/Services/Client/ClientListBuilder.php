<?php

namespace App\Services\Client;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

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
        $this->getQuery()
            ->where(function (Builder $query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('name', 'ilike', "%{$search}%")
                    ->orWhereHas('manager', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%");
                    });
            });

        return $this;
    }

    protected function applySorting(string $sortBy): static
    {
        $sortByRelation = Str::contains($sortBy, '.');

        if ($sortByRelation) {
            $parts = explode('.', $sortBy);
            $sortBy = sprintf('%s.%s', Str::snake(Str::pluralStudly($parts[0])), $parts[1]);
        }

        $this->getQuery()
            ->orderBy($sortBy);

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
