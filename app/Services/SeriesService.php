<?php

namespace App\Services;

use App\Jobs\CreateSeries;
use App\Jobs\DeleteSeries;
use App\Jobs\UpdateSeries;
use App\Models\Publisher;
use App\Models\Series;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SeriesService
{
    private ComicService $comicService;

    public function __construct(ComicService $comicService)
    {
        $this->comicService = $comicService;
    }

    public function createSeries(Publisher $publisher, array $data)
    {
        CreateSeries::dispatch($publisher, $data);
    }

    public function updateSeries(Series $series, array $data)
    {
        UpdateSeries::dispatch($series, $data);

        if ($data['title'] && $series->title !== $data['title']) {
            $series->comics->each(function ($comic) use ($data) {
                $this->comicService->updateComic($comic, ['title' => $data['title'] . ' #' . $comic->issue_number]);
            });
        }
    }

    public function deleteSeries(Series $series)
    {
        DeleteSeries::dispatch($series);
    }

    public function getSeriesList(Publisher $publisher): LengthAwarePaginator
    {
        return QueryBuilder::for(Series::class)
            ->allowedSorts([
                'title',
                'start_year',
            ])
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('start_year'),
            ])
            ->with('publisher')
            ->when($publisher->id, function ($query) use ($publisher) {
                return $query->where('publisher_id', $publisher->id);
            })
            ->jsonPaginate()
            ->appends(request()->query());
    }
}
