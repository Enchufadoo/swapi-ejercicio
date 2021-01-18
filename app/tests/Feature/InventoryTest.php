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
        $this->assertEquals(3,$response->decodeResponseJson()['count']);
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

    /** @test */
    public function can_set_the_ammount_of_vehicles()
    {
        $this->withoutExceptionHandling();
        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);

        $response = $this->json('POST', "/api/inventory/{$inventory->type}/{$inventory->external_id}/amount", [
            'amount' => 23
        ]);

        $response->assertStatus(200);
        $this->assertEquals(23, $inventory->fresh()->count);
    }

    /** @test */
    public function setting_an_incorrect_ammount_of_vehicles_returns_an_error()
    {
        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);

        $response = $this->json('POST', "/api/inventory/{$inventory->type}/{$inventory->external_id}/amount", [
            'amount' => -1
        ]);

        $response->assertStatus(422);
        $this->assertEquals(3, $inventory->fresh()->count);
    }

    /** @test */
    public function can_increment_the_number_of_vehicles()
    {
        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);

        $response = $this->json('POST', "/api/inventory/{$inventory->type}/{$inventory->external_id}/amount/increment", [
            'amount' => 10
        ]);

        $response->assertStatus(200);
        $this->assertEquals(13, $inventory->fresh()->count);
    }

    /** @test */
    public function the_increment_of_the_number_of_vehicles_must_be_at_least_one()
    {
        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);

        $response = $this->json('POST', "/api/inventory/{$inventory->type}/{$inventory->external_id}/amount/increment", [
            'amount' => 0
        ]);

        $response->assertStatus(422);
        $this->assertEquals(3, $inventory->fresh()->count);
    }

    /** @test */
    public function can_decrement_the_number_of_vehicles()
    {
        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);

        $response = $this->json('POST', "/api/inventory/{$inventory->type}/{$inventory->external_id}/amount/decrement", [
            'amount' => 2
        ]);

        $response->assertStatus(200);
        $this->assertEquals(1, $inventory->fresh()->count);
    }

    /** @test */
    public function cant_decrement_more_than_the_number_of_current_available_vehicles()
    {
        $inventory = Inventory::factory()->create(['external_id' => 4, 'count' => 3, 'type' => 'vehicles']);

        $response = $this->json('POST', "/api/inventory/{$inventory->type}/{$inventory->external_id}/amount/decrement", [
            'amount' => 20
        ]);

        $response->assertStatus(500);
        $this->assertEquals(3, $inventory->fresh()->count);
    }


}
