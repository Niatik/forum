<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }
    

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have the authenticated user
        $this->be($user = create('App\User'));
        // And an existing thread
        $thread = create('App\Thread');
        // When the user adds a reply to the thread
        $reply = make('App\Reply');
        $this->post($thread->path().'/replies', $reply->toArray());
        // Then their reply should be visible on the page.
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
