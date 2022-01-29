<?php

namespace App\Services;

use App\Jobs\CreatePublisher;
use App\Jobs\DeletePublisher;
use App\Jobs\UpdatePublisher;
use App\Models\Publisher;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PublisherService
{
    public function createPublisher(array $data)
    {
        CreatePublisher::dispatch($data);
    }

    public function updatePublisher(Publisher $publisher, array $data)
    {
        UpdatePublisher::dispatch($publisher, $data);
    }

    public function deletePublisher(Publisher $publisher)
    {
        DeletePublisher::dispatch($publisher);
    }

    public function getPublishersList(): LengthAwarePaginator
    {
        return QueryBuilder::for(Publisher::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::exact('country'),
                AllowedFilter::scope('founded-year-between'),
                AllowedFilter::scope('founded-year'),
            ])
            ->allowedSorts([
                'name',
                'founded_year',
            ])
            ->with('series', 'series.comics')
            ->jsonPaginate()
            ->appends(request()->query());
    }
}
