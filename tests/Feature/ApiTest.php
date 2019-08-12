<?php

namespace Tests\Feature;

use App\Models\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * For testing api that should return all events from db.
     * 
     * @return void
     */
    public function testCanGetAllEvents()
    {
        factory(Event::class, 5)->create();
        $response = $this->json('GET', '/api/events');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ;
    }

    /**
     * Test we can save events
     *
     * @return void
     */
    public function testCanSaveNewEvents()
    {
        factory(Event::class)->create(['name' => 'Existing Event']);

        $response = $this->json('POST', '/api/events', [
            ['name' => 'Event 1', 'date' => '2019-08-20'],
            ['name' => 'Event 2', 'date' => '2019-08-22'],
        ]);

        $response
            ->assertStatus(201);

        $this->assertDatabaseHas('events', ['name' => 'Event 1', 'schedule_date' => '2019-08-20']);
        $this->assertDatabaseHas('events', ['name' => 'Event 2', 'schedule_date' => '2019-08-22']);
        
        // And this existing event should have been deleted
        $this->assertDatabaseMissing('events', ['name' => 'Existing Event']);
    }

    /**
     * Test we do get validation error.
     * 
     * @return void
     */
    public function testCannotSaveWithIncompleteData()
    {
        $response = $this->json('POST', '/api/events', [
            ['name' => 'Event 1', 'date' => '2019-08-20'],
            ['name' => 'Event 2'],
        ]);

        $response
            ->assertStatus(422); // Laravel response for validation error
    }
}
