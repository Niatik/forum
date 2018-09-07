<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('threads/create')
            ->assertRedirect('/login');

        $this->post('threads')
            ->assertRedirect('/login');

        //$this->expectException('Illuminate\Auth\AuthenticationException');

        //$thread = make('App\Thread');

        //$this->post('/threads', $thread->toArray());
    }

    /** @test */
    function guests_cannot_see_the_create_thread_page()
    {
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
}
