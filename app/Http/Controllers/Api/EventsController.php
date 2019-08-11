<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
}
