<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Socialite;
use Mockery;
use App\Models\User;
use App\Models\Todo;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function Todoの作成ができる()
    {
        $user = $this->User作成();
        $data = [
            'uid'      => $user->uid,
            'user_id'  => $user->id,
            'content'  => 'test',
            'due_date' => '2000-04-01',
        ];
        $this->withoutExceptionHandling();
        $this->assertDatabaseMissing('todos', $data);
        $response = $this->post(route('todos.store'), $data);
        $response->assertStatus(302)
            ->assertRedirect("/users/$user->nickname");
        $this->assertEquals(1, Todo::count());
    }

    public function User作成()
    {
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');

        $Muser = Mockery::mock('Laravel\Socialite\One\User');
        $Muser->shouldReceive('getId')
            ->andReturn('1111111')
            ->shouldReceive('getNickname')
            ->andReturn('test')
            ->shouldReceive('getName')
            ->andReturn('testuser')
            ->shouldReceive('getAvatar')
            ->andReturn('https://api.adorable.io/avatars/285/abott@adorable.png');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($Muser);
        Socialite::shouldReceive('driver')->with('twitter')->andReturn($provider);

        $this->get(route('callback'))
            ->assertStatus(302)
            ->assertRedirect('/');
        $user = User::where('name', 'testuser')->first();
        return $user;
    }
}
