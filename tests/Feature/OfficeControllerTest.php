<?php

namespace Tests\Feature;

use App\Models\Office;
use App\Models\Reservation;
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
}
