<?php

namespace Livewire\Users;

use App\Http\Livewire\Users\EditUser;
use Livewire\Livewire;
use Tests\TestCase;

class EditUsersTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(EditUser::class);

        $component->assertStatus(200);
    }
}
