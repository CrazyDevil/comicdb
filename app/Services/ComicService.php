<?php

namespace App\Services;

use App\Jobs\CreateComic;
use App\Jobs\DeleteComic;
use App\Jobs\UpdateComic;
use App\Models\Comic;
use App\Models\Series;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ComicService
{
    public function createComic(Series $series, array $data)
    {
        $data = array_merge($data, [
            'title' => $series->title . ' #' . $data['issue_number'],
        ]);

        CreateComic::dispatch($series, $data);
    }

    public function updateComic(Comic $comic, array $data)
    {
        UpdateComic::dispatch($comic, $data);
    }

    public function deleteComic(Comic $comic)
    {
        DeleteComic::dispatch($comic);
    }

    public function getComicsList(Series $series): LengthAwarePaginator
    {
        return QueryBuilder::for(Comic::class)
            ->allowedSorts([
                'title',
                'issue_number',
            ])
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('format'),
            ])
            ->with('series', 'series.publisher')
            ->when($series->id, function ($query) use ($series) {
                return $query->where('series_id', $series->id);
            })
            ->jsonPaginate()
            ->appends(request()->query());
    }
}
