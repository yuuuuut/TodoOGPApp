<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
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
                    ->assertSeeLink('ログイン');
        });
    }

    /*
    public function ログインしてる場合のリンク表示()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->type('#username_or_email', env('USERNAME'))
                    ->type('#password', env('PASSWORD'))
                    ->click('#allow')
                    ->visit(route('callback'))
                    ->assertSeeLink('Home')
                    ->assertSeeLink('マイページ');
        });
    }

    public function 期日内の場合期日内と表示される()
    {
        $this->browse(function (Browser $browser) {
            $user = $this->User作成();
            $browser->loginAs($user)->visit('/')
                    ->clickLink('マイページ')
                    ->type('content', 'Todotest')
                    ->type('due_date', '0401-20-30')
                    ->click('.todo__createButton')
                    ->assertSee('Todotest');
        });
    }
    */
}
