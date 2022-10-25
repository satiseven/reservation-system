<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficeControllerTest extends TestCase
{
//    use RefreshDatabase;

    /**
     * A basic feature Pagination Office.
     *
     * @test
     */

    public function itListsAllOfficesInPaginatedWay()
    {
        Office::factory(1)->create();
        $response = $this->get('/api/offices');
        $response->assertOk();
        $this->assertNotNull($response->json('links'));

    }

    /**
     *  List Only Office That Not Hidden And Approval.
     *
     * @test
     */
    public function itOnlyOfficesThatNotHiddenAndApproved()
    {
        Office::factory(2)->create();
        Office::factory(3)->create(['hidden' => true, 'approval_status' => Office::APPROVAL_PEDNGING]);
        $response = $this->get('/api/offices');
        $response->assertOk();
        // $response->assertJsonCount(3, 'data');
    }

    /**
     * Filter the Offices By Host Id
     *
     * @test
     */
    public function itFiltersByHostId()
    {
        Office::factory(3)->create();
        $user = User::factory()->create();
        $offices = Office::factory(3)->for($user)->create();
        $response = $this->get('/api/offices?host_id='.$user->id);
        $response->assertJsonCount(3, 'data');
        $response->assertOk();

    }

    /**
     * Filter the Offices By User Id
     *
     * @test
     */
    public function itFiltersByUserId()
    {

        $user = User::factory()->create();
        $office = Office::factory()->create();
        // Reservation::factory()->for(Office::factory())->create();
        Reservation::factory()->for($user)->for($office)->create();
        $response = $this->get('/api/offices?user_id='.$user->id);
        $response->assertOk()->dump();
    }

    /**
     * get Office with Tags and Images
     *
     * @test
     */
    public function itIncludesTagsAndUsers()
    {
        $user = User::factory()->create();
        $office = Office::factory()->for($user)->create();
        $tag = Tag::factory()->create();
        $office->tags()->attach($tag);
        $office->images()->create(['path' => 'main.png']);
        $response = $this->get('/api/offices');
        $response->assertOk();

    }

    /**
     * get Office with Tags and Images
     *
     * @test
     */
    public function itReturnsTheNumberOfActiveReservations()
    {
        $office = Office::factory()->create();
        Reservation::factory()->for($office)->create(['status' => Reservation::STATUS_ACTIVE]);
        Reservation::factory()->for($office)->create(['status' => Reservation::STATUS_CANCELED]);
        $response = $this->get('/api/offices');
        $response->assertOk();
//        $this->assertEquals(1, $response->json('data')[0]['reservations_count']);
    }

    /**
     * get Office with Tags and Images
     *
     * @test
     */
    public function itOrdersByDistanceWhenCoordinatesAreProvided()
    {
        //40.99847255085493, 28.846298723163642
        $office = Office::factory()->create([
            'lat' => "40.998074593742096",
            'lng' => "28.84494777940843",
            'title' => 'Market Bibi',
        ]);

        $office2 = Office::factory()->create([
            'lat' => "40.99750430607406",
            'lng' => "28.845767741972608",
            'title' => 'Sair Zihni',
        ]);
        $response = $this->get('/api/offices?lat=40.99870310962599&lng=28.846306728905457');
        $response->assertOk();
    }

    /**
     * Shows The Office with Id
     *
     * @test
     */
    public function itShowsTheOffice()
    {
        $office = Office::factory()->create();
        $response = $this->get('/api/offices/'.$office->id);
        $response->assertOk();
    }
}
