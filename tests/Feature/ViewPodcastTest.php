<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Podium\Podcast;

class ViewPodcastTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_a_published_podcast()
    {
        // Arrange
        // Create a podcast
        $podcast = factory(Podcast::class)->states('published')->create();

        // Act
        // View the podcast
        $response = $this->get('/podcasts/'.$podcast->id);

        // Assert
        // See the podcast details
        $response->assertStatus(200);
        $response->assertSee($podcast->title);
        $response->assertSee($podcast->subtitle);
        $response->assertSee($podcast->description);
        $response->assertSee($podcast->author);
        $response->assertSee($podcast->author_email);
    }

    /** @test */
    public function user_cannot_view_an_unpublished_podcast()
    {
        $podcast = factory(Podcast::class)->states('unpublished')->create();

        // Act
        // View the podcast
        $response = $this->get('/podcasts/'.$podcast->id);

        // Assert
        // See the podcast details
        $response->assertStatus(404);
    }

}
