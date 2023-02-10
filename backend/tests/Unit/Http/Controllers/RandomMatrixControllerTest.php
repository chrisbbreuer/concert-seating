<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\RandomMatrixController;
use App\Models\Guest;
use Illuminate\Http\Request;
use Tests\TestCase;

class RandomMatrixControllerTest extends TestCase
{
    /**
     * @var \App\Http\Controllers\RandomMatrixController
     */
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new RandomMatrixController();
    }

    /** @test */
    public function it_invokes_the_controller_and_returns_seated_guests()
    {
        $request = \Mockery::mock(Request::class);

        $guests = Guest::factory(100)->make()->toArray();
        $seatedGuests = $this->controller->seatGuests($guests);

        $this->assertIsArray($seatedGuests);
        $this->assertCount(10, $seatedGuests);
        foreach ($seatedGuests as $row) {
            $this->assertCount(10, $row);
        }
    }

    /** @test */
    public function it_seats_guests_in_a_matrix()
    {
        $guests = Guest::factory(100)->make()->toArray();

        $seatedGuests = $this->controller->seatGuests($guests);

        foreach ($seatedGuests as $row) {
            foreach ($row as $guest) {
                $this->assertArrayHasKey('id', $guest);
                $this->assertArrayHasKey('name', $guest);
                $this->assertArrayHasKey('package_id', $guest);
                $this->assertArrayHasKey('companion_slot', $guest);
            }
        }
    }
}
