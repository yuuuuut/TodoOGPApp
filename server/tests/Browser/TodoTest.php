<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Socialite;
use Mockery;
use App\Models\User;
use App\Models\Todo;

class TodoTest extends DuskTestCase
{
    use RefreshDatabase;

    /** @test */
    public function ホーム画面にTodoと表示されている()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Todo!!');
        });
    }

    /** @test */
    public function 未ログイン状態の場合ログインリンクが表示()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSeeLink('Login');
        });
    }

    /** @test */
    public function ログインしてる場合のリンク表示()
    {
        $user = $this->User作成();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)->visit('/')
                    ->assertSeeLink('Home')
                    ->assertSeeLink('マイページ');
        });
    }

    /** @test */
    public function Todoの作成ができる()
    {
        $user = $this->User作成();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)->visit("/")
                    ->type('content', 'Todotest')
                    ->type('due_date', '0401-20-30')
                    ->click('.todo__createButton')
                    ->assertSee('Todotest');
            $this->assertEquals(1, Todo::count());
        });
    }

    /** @test */
    public function Todo個別ページにアクセスできる()
    {
        $user = $this->User作成();
        $this->browse(function (Browser $browser) use ($user) {
            $this->Todoの作成ができる();
            $browser->clickLink('もっと見る')
                    ->assertSee('Todotest');
        });
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
        $user = User::where('nickname', 'test')->first();
        return $user;
    }
}
