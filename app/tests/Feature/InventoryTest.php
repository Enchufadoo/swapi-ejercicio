<?php

namespace Tests\Feature;

use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_retrieve_the_number_of_items_in_the_inventory_for_a_vehicle_or_starship()
    {
        $this->withoutExceptionHandling();

        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);

        $response = $this->json('GET', "/api/inventory/{$inventory->type}/{$inventory->external_id}/count", []);
        $response->assertStatus(200);
        $this->assertEquals($response->decodeResponseJson()['count'], 3);
    }
}
