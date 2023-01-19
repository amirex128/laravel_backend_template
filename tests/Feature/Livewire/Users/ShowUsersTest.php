<?php

namespace Livewire\Users;

use App\Http\Livewire\Users\ShowUser;
use Livewire\Livewire;
use Tests\TestCase;

class ShowUsersTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ShowUser::class);

        $component->assertStatus(200);
    }
}
