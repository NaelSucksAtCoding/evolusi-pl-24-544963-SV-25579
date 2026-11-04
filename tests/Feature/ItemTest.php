<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_utama_menampilkan_daftar_item(): void
    {
        Item::factory()->create(['name' => 'Nasi Goreng']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Nasi Goreng');
    }

    public function test_item_baru_dapat_ditambahkan(): void
    {
        $this->post('/items', ['name' => 'Bakwan', 'description' => 'Bakwan goreng'])
            ->assertRedirect(route('items.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('items', ['name' => 'Bakwan', 'description' => 'Bakwan goreng']);
    }

    public function test_nama_item_wajib_diisi(): void
    {
        $this->post('/items', ['name' => '', 'description' => 'Tanpa nama'])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('items', 0);
    }

    public function test_item_dapat_diperbarui(): void
    {
        $item = Item::factory()->create(['name' => 'Lama']);

        $this->put("/items/{$item->id}", ['name' => 'Baru', 'description' => null])
            ->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('items', ['id' => $item->id, 'name' => 'Baru']);
    }

    public function test_item_dapat_dihapus(): void
    {
        $item = Item::factory()->create();

        $this->delete("/items/{$item->id}")
            ->assertRedirect(route('items.index'));

        $this->assertModelMissing($item);
    }
}
