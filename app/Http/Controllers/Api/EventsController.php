<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Http\Resources\EventResource;
use App\Http\Requests\StoreEventsRequest;
use App\Http\Controllers\Controller;

/**
 * 
 */
class EventsController extends Controller
{
    public function index()
    {
        return EventResource::collection(Event::oldest('schedule_date')->get());
    }

    /**
     * Stores the request. Everytime new events are added, previous ones must be deleted.
     *
     * @param  App\Http\Requests\StoreEventsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventsRequest $request)
    {
        $data = $request->validated();
        // Entire steps can be put inside a DB transaction.
        Event::truncate();
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
