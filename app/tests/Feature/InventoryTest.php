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

    /** @test */
    public function invalid_type_of_vehicle_returns_an_error()
    {
        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);
        $response = $this->json('GET', "/api/inventory/anytype/{$inventory->external_id}/count", []);

        $response->assertStatus(422);
    }

    /** @test */
    public function invalid_vehicle_id_returns_an_error()
    {
        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);
        $response = $this->json('GET', "/api/inventory/vehicles/-13/count", []);

        $response->assertStatus(422);
    }


}
