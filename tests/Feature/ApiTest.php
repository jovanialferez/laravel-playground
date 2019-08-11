<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test we got all events
     *
     * @return void
     */
    public function testCanSaveNewEvents()
    {
        $response = $this->json('POST', '/api/events', [
            ['name' => 'Event 1', 'date' => '2019-08-20'],
            ['name' => 'Event 2', 'date' => '2019-08-22'],
        ]);

        $response
            ->assertStatus(201);

        $this->assertDatabaseHas('events', ['name' => 'Event 1', 'schedule_date' => '2019-08-20']);
        $this->assertDatabaseHas('events', ['name' => 'Event 2', 'schedule_date' => '2019-08-22']);
    }
}
