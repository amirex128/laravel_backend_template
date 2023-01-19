<?php

namespace Tests\Feature\Livewire\Shops;

use App\Http\Livewire\Shops\IndexShop;
use Livewire\Livewire;
use Tests\TestCase;

class IndexShopTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(IndexShop::class);

        $component->assertStatus(200);
    }
}
