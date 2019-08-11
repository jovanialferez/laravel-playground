<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Http\Requests\StoreEventsRequest;
use App\Http\Controllers\Controller;

/**
 * We will be assuming here that we only care about storing all event requests
 * and no need for returning current list nor updated list.
 */
class EventsController extends Controller
{
    /**
     * Stores the request.
     *
     * @param  App\Http\Requests\StoreEventsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventsRequest $request)
    {
        $data = $request->validated();
        // Could be done via a repository
        foreach ($data as $item) {
            Event::create([
                'name' => $item['name'],
                'schedule_date' => $item['date']
            ]);
        }
        
        return response()
            ->json(['success' => true])
            ->setStatusCode(201)
            ;
    }
}
