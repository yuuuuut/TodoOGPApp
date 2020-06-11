<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
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
            'user_id'  => $user->id,
            'content'  => 'test',
            'due_date' => '2030-04-01',
        ];
        $this->withoutExceptionHandling();
        $this->assertDatabaseMissing('todos', $data);
        $response = $this->post(route('todos.store'), $data);
        $response->assertStatus(302)
            ->assertRedirect("/users/$user->nickname")
            ->assertSee('test');
        $this->assertEquals(1, Todo::count());
        $todo = Todo::where('user_id', $user->id)->first();
        return $todo;
    }

    /** @test */
    public function Todoの個別ページにアクセスできる()
    {
        $todo = $this->Todoの作成ができる();
        $response = $this->get("/todos/$todo->id");
        $response->assertStatus(200); 
    }

    /** @test */
    public function Due_dateが期限内だったら期限内と表示される()
    {
        $user = $this->User作成();
        $todo = factory(Todo::class, 'default')->create(['user_id' => $user->id]);
        $response = $this->get("/todos/$todo->id");
        $response->assertStatus(200)
            ->assertSee('期限内です');
    }

    /** @test */
    public function Due_dateが期限外だったら期限外と表示される()
    {
        $user = $this->User作成();
        $todo = factory(Todo::class, 'default')->create(['user_id' => $user->id, 'due_date' => '2020-01-01']);
        $response = $this->get("/todos/$todo->id");
        $response->assertStatus(200)
            ->assertSee('期限外です');
    }

    /** @test */
    public function OGP画像ページにアクセスできる()
    {
        $todo = $this->Todoの作成ができる();
        $response = $this->get("/todos/$todo->id/ogp.png");
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');
    }

    /** @test */
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
