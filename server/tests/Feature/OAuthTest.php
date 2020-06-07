<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;
use Socialite;
use Mockery;
use Auth;

class OAuthTest extends TestCase
{
    /** @test */
    public function 認証画面の表示ができる()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    /** @test */
    public function Twitterログインに成功しに登録できる()
    {
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');

        $abstractUser = Mockery::mock('Laravel\Socialite\One\User');
        $abstractUser->shouldReceive('getId')
            ->andReturn('1111111')
            ->shouldReceive('getNickname')
            ->andReturn('test')
            ->shouldReceive('getName')
            ->andReturn('testuser')
            ->shouldReceive('getAvatar')
            ->andReturn('https://api.adorable.io/avatars/285/abott@adorable.png');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);
        Socialite::shouldReceive('driver')->with('twitter')->andReturn($provider);

        $this->get(route('callback'))
            ->assertStatus(302)
            ->assertRedirect('/');
        
        $this->assertDatabaseHas('users', [
            'uid' => $abstractUser->getId(),
            'name' => $abstractUser->getName(),
            'nickname' => $abstractUser->getNickname(),
            'avatar' => $abstractUser->getAvatar(),
        ]);
        $this->assertAuthenticated();
    }
}
