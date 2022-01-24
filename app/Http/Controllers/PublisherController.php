<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequest;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Publisher management
 */
class PublisherController extends Controller
{
    /**
     * Fetch a list of all publishers
     *
     * This endpoint will return a list of all publishers. You can sort the list by publisher name or founded year. You
     * also have the ability to filter the list by publisher name, country, founded year of between two years.
     *
     *
     * @authenticated
     *
     * @header Accept application/json
     *
     * @queryParam sort The field to sort the list by. Example: name
     * @queryParam filter[name] string Filter by publisher name. Example: Marvel
     * @queryParam filter[country] string Filter by publisher country. Example: USA
     * @queryParam filter[founded-year] int Filter by publisher founded year. Example: 1940
     * @queryParam filter[founded-year-between] string Filter by publisher founded year in the given range. Example: 1940,1990
     * @queryParam page[number] int The page number (default 1). Example: 2
     * @queryParam page[size] int The page size (default 30). Example: 10
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Publisher 1",
     *       "founded-at": "1990",
     *       "website-url": "http://www.publisher1.com",
     *       "twitter-url": "http://www.twitter.com/publisher1",
     *       "address": "Address 1",
     *       "city": "City 1",
     *       "state": "State 1",
     *       "zip": "12345",
     *       "country": "DEU",
     *       "created-at": "2020-01-01T00:00:00+00:00",
     *       "updated-at": "2020-01-01T00:00:00+00:00"
     *     },
     *     {
     *       "id": 2,
     *       "name": "Publisher 2",
     *       "founded-at": "1990",
     *       "website-url": "http://www.publisher2.com",
     *       "twitter-url": "http://www.twitter.com/publisher2",
     *       "address": "Address 2",
     *       "city": "City 2",
     *       "state": "State 2",
     *       "zip": "12345",
     *       "country": "DEU",
     *       "created-at": "2020-01-01T00:00:00+00:00",
     *       "updated-at": "2020-01-01T00:00:00+00:00"
     *     },
     *   ],
     *   "links": {
     *     "first": "http://localhost/api/publishers?page%5Bnumber%5D=1",
     *     "last": "http://localhost/api/publishers?page%5Bnumber%5D=4",
     *     "prev": null,
     *     "next": "http://localhost/api/publishers?page%5Bnumber%5D=2"
     *   },
     *   "meta": {
     *      "current_page": 1,
     *      "from": 1,
     *      "last_page": 4,
     *      "links": [
     *        {
     *          "url": null,
     *          "label": "&laquo; Previous",
     *          "active": false
     *        },
     *        {
     *          "url": "http://localhost/api/publishers?sort=name&page%5Bnumber%5D=1",
     *          "label": "1",
     *          "active": true
     *        },
     *        {
     *          "url": "http://localhost/api/publishers?sort=name&page%5Bnumber%5D=2",
     *          "label": "2",
     *          "active": false
     *        },
     *        {
     *          "url": "http://localhost/api/publishers?sort=name&page%5Bnumber%5D=2",
     *          "label": "Next &raquo;",
     *          "active": false
     *        }
     *      ],
     *      "path": "http://localhost/api/publishers",
     *      "per_page": 30,
     *      "to": 30,
     *      "total": 100
     *    }
     * }
     *
     */
    public function index(): AnonymousResourceCollection
    {
        $publishers = QueryBuilder::for(Publisher::class)
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
            ->jsonPaginate()
            ->appends(request()->query());

        return PublisherResource::collection($publishers);
    }

    /**
     * Fetch a single publisher
     *
     * This endpoint will return a single publisher specified by the id.
     *
     * @authenticated
     *
     * @response {
     *   "data": {
     *     "id": 1,
     *     "name": "Publisher 1",
     *     "founded-at": "1990",
     *     "website-url": "http://www.publisher1.com",
     *     "twitter-url": "http://www.twitter.com/publisher1",
     *     "address": "Address 1",
     *     "city": "City 1",
     *     "state": "State 1",
     *     "zip": "12345",
     *     "country": "DEU",
     *     "created-at": "2020-01-01T00:00:00+00:00",
     *     "updated-at": "2020-01-01T00:00:00+00:00"
     *   }
     * }
     */
    public function show(Publisher $publisher): PublisherResource
    {
        return new PublisherResource($publisher);
    }

    /**
     * Create a new publisher
     *
     * This endpoint will create a new publisher.
     *
     * @authenticated
     *
     * @header Accept application/json
     *
     * @bodyParam name string required The name of the publisher.
     *
     * @response {
     *   "data": {
     *     "id": 1,
     *     "name": "Publisher 1",
     *     "founded-at": "1990",
     *     "website-url": "http://www.publisher1.com",
     *     "twitter-url": "http://www.twitter.com/publisher1",
     *     "address": "Address 1",
     *     "city": "City 1",
     *     "state": "State 1",
     *     "zip": "12345",
     *     "country": "DEU",
     *     "created-at": "2020-01-01T00:00:00+00:00",
     *     "updated-at": "2020-01-01T00:00:00+00:00"
     *   }
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "field": [
     *             "Error message"
     *         ]
     *     }
     * }
     */
    public function store(PublisherRequest $request): PublisherResource
    {
        $publisher = Publisher::create($request->validated());

        return new PublisherResource($publisher);
    }

    /**
     * Update an existing publisher
     *
     * This endpoint will update an existing publisher.
     *
     * @authenticated
     *
     * @header Accept application/json
     *
     * @response {
     *   "data": {
     *     "id": 1,
     *     "name": "Publisher 1",
     *     "founded-at": "1990",
     *     "website-url": "http://www.publisher1.com",
     *     "twitter-url": "http://www.twitter.com/publisher1",
     *     "address": "Address 1",
     *     "city": "City 1",
     *     "state": "State 1",
     *     "zip": "12345",
     *     "country": "DEU",
     *     "created-at": "2020-01-01T00:00:00+00:00",
     *     "updated-at": "2020-01-01T00:00:00+00:00"
     *   }
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "field": [
     *             "Error message"
     *         ]
     *     }
     * }
     */
    public function update(PublisherRequest $request, Publisher $publisher): PublisherResource
    {
        $publisher->update($request->validated());

        return new PublisherResource($publisher);
    }

    /**
     * Delete an existing publisher
     *
     * This endpoint will delete an existing publisher.
     *
     * @authenticated
     *
     * @header Accept application/json
     *
     * @response {
     *   "data": {
     *     "id": 1,
     *     "name": "Publisher 1",
     *     "founded-at": "1990",
     *     "website-url": "http://www.publisher1.com",
     *     "twitter-url": "http://www.twitter.com/publisher1",
     *     "address": "Address 1",
     *     "city": "City 1",
     *     "state": "State 1",
     *     "zip": "12345",
     *     "country": "DEU",
     *     "created-at": "2020-01-01T00:00:00+00:00",
     *     "updated-at": "2020-01-01T00:00:00+00:00"
     *   }
     * }
     *
     * @response 404 {
     *  "message": "Resource not found."
     * }
     *
     * @response 422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *   "name": [
     *      "Error message"
     *   ]
     * }
     */
    public function destroy(Publisher $publisher): PublisherResource
    {
        $publisher->delete();

        return new PublisherResource($publisher);
    }
}
