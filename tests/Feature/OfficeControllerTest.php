<?php

namespace Tests\Feature;

use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */

    public function itOfficeLists()
    {
        Office::factory(3)->create();
        $response = $this->get('/api/offices');
        $response->assertOk();
    }
}
