<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_mengembalikan_daftar_item_dalam_json(): void
    {
        Item::factory()->create(['name' => 'Bakwan', 'description' => 'Bakwan goreng']);

        $this->getJson('/api/items')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Bakwan')
            ->assertJsonPath('data.0.description', 'Bakwan goreng');
    }

    public function test_frontend_vue_di_laptop_boleh_mengakses_api(): void
    {
        $this->getJson('/api/items', ['Origin' => 'http://localhost:5173'])
            ->assertOk()
            ->assertHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
    }

    public function test_origin_asing_tidak_diberi_izin_cors(): void
    {
        $this->getJson('/api/items', ['Origin' => 'https://situs-asing.example'])
            ->assertOk()
            ->assertHeaderMissing('Access-Control-Allow-Origin');
    }
}
