<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\IndexUser;
use Livewire\Livewire;
use Tests\TestCase;

class IndexUsersTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(IndexUser::class);

        $component->assertStatus(200);
    }
}
