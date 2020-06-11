<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Socialite;
use Mockery;
use Auth;
use App\Models\User;
use App\Models\Todo;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログインしている場合()
    {
        $user = $this->User作成();
        $todo = factory(Todo::class, 'default')->create(['user_id' => $user->id]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get("todos/$todo->id");
        $response->assertStatus(200);

        $response = $this->get("todos/$todo->id/ogp.png");
        $response->assertStatus(200);

        $response = $this->get("users/$user->nickname");
        $response->assertStatus(200);
    }

    /** @test */
    public function ログインしてない場合()
    {
        $user = $this->User作成();
        $todo = factory(Todo::class, 'default')->create(['user_id' => $user->id]);
        $this->assertTrue(Auth::check());
        $response = $this->post(route('logout'));
        $this->assertFalse(Auth::check());

        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get("todos/$todo->id");
        $response->assertStatus(302)
            ->assertRedirect('login/twitter');

        $response = $this->get("todos/$todo->id/ogp.png");
        $response->assertStatus(302)
            ->assertRedirect('login/twitter');

        $response = $this->get("users/$user->nickname");
        $response->assertStatus(302)
            ->assertRedirect('login/twitter');
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
        //dd($user);
        return $user;
    }
}
