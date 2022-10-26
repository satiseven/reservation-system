<?php

namespace Tests\Feature;

use App\Models\Office;
use App\Models\Reservation;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfficeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature Pagination Office.
     *
     * @test
     */
    public function itCreateAnOffice()
    {
        $user = User::factory()->createQuietly();
        $this->actingAs($user);
        $tag = Tag::factory()->create(['name' => 'this is my tag']);
        $response = $this->postJson('/api/offices', [
            'user_id' => $user->id,
            'title' => 'deneme basligi',
            'description' => 'deneme description',
            'lat' => '41.01678462062215',
            'lng' => '28.94016767414268',
            'address_line_1' => 'fatih istanbul',
            'approval_status' => Office::APPROVAL_APPROVED,
            'hidden' => false,
            'price_per_day' => 1000,
            'monthly_discount' => 0,
            'tags' => [
                $tag->id,
            ],
        ]);

        $response->assertOk();
    }

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
        Office::factory(3)->for($user)->create();
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
        $response = $this->get('/api/offices?visitor_id='.$user->id);
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
        $tag = Tag::factory()->create(['name' => 'bathroom one']);
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
        Office::factory()->create([
            'lat' => "40.998074593742096",
            'lng' => "28.84494777940843",
            'title' => 'Market Bibi',
        ]);

        Office::factory()->create([
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
