<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Carbon\Carbon;
use Socialite;
use Mockery;
use App\Models\User;
use App\Models\Todo;

class TodoRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function contentが空ではTodo作成できない()
    {
        $user = $this->User作成();
        $data = [
            'content' => ''
        ];
        $response = $this->post(route('todos.store'), $data);
        $response->assertSessionHasErrors(['content' => 'The content field is required.']);
        $this->assertEquals(0, Todo::count());
    }

    /** @test */
    public function contentが26文字ではTodo作成できない()
    {
        $user = $this->User作成();
        $data = [
            'content' => Str::random(26)
        ];
        $response = $this->post(route('todos.store'), $data);
        $response->assertSessionHasErrors(['content' => 'The content may not be greater than 25 characters.']);
        $this->assertEquals(0, Todo::count());
    }

    /** @test */
    public function due_dateが空ではTodo作成できない()
    {
        $user = $this->User作成();
        $data = [
            'due_date' => ''
        ];
        $response = $this->post(route('todos.store'), $data);
        $response->assertSessionHasErrors(['due_date' => 'The due date field is required.']);
        $this->assertEquals(0, Todo::count());
    }

    /** @test */
    public function due_dateが今日以前ではTodo作成できない()
    {
        $user = $this->User作成();
        $today = Carbon::now();
        $data = [
            'due_date' => $today->subDay()->format('Y-m-d')
        ];
        $response = $this->post(route('todos.store'), $data);
        $response->assertSessionHasErrors(['due_date' => 'The due date must be a date after or equal to today.']);
        $this->assertEquals(0, Todo::count());
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
