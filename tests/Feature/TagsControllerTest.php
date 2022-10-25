<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagsControllerTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * @test
     */
    public function itListsTags()
    {
        $response = $this->get('/api/tags');
        $response->assertStatus(200);
        $this->assertNotNull($response->json('data'));
    }

}
