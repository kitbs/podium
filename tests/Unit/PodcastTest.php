<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Podium\Podcast;
use Carbon\Carbon;

class PodcastTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function podcasts_with_a_published_at_date_are_published()
    {
        $published1 = factory(Podcast::class)->states('published')->create();
        $published2 = factory(Podcast::class)->states('published')->create();
        $unpublished1 = factory(Podcast::class)->states('unpublished')->create();
        $unpublished2 = factory(Podcast::class)->states('unpublished')->create();

        $this->assertTrue($published1->is_published);
        $this->assertTrue($published2->is_published);
        $this->assertFalse($unpublished1->is_published);
        $this->assertFalse($unpublished2->is_published);

        $publishedPodcasts = Podcast::get();

        $this->assertTrue($publishedPodcasts->contains($published1));
        $this->assertTrue($publishedPodcasts->contains($published2));
        $this->assertFalse($publishedPodcasts->contains($unpublished1));
        $this->assertFalse($publishedPodcasts->contains($unpublished2));
    }

    /** @test */
    public function podcasts_without_a_published_date_are_unpublished()
    {
        factory(Podcast::class, 3)->states('published')->create();
        factory(Podcast::class, 4)->states('unpublished')->create();

        $this->assertEquals(3, Podcast::count());
        $this->assertEquals(3, Podcast::withoutUnpublished()->count());
        $this->assertEquals(4, Podcast::onlyUnpublished()->count());
        $this->assertEquals(7, Podcast::withUnpublished()->count());

    }

    /** @test */
    public function podcasts_are_ordered_by_published_date()
    {
        $i = 1;

        factory(Podcast::class, 10)->states('unpublished')->create()->each(function($podcast) use (&$i) {
            $podcast->publish_at = Carbon::parse('-'.$i.' months');
            $podcast->save();
            $i++;
        });

        $earliestDate = Podcast::min('publish_at');
        $latestDate = Podcast::max('publish_at');

        $podcasts = Podcast::orderByPublished()->pluck('publish_at');

        $this->assertEquals($earliestDate, $podcasts->last());
        $this->assertEquals($latestDate, $podcasts->first());
    }

    /** @test */
    public function podcast_can_be_published()
    {
        $podcast = factory(Podcast::class)->states('unpublished')->create();

        $this->assertFalse($podcast->is_published);

        $podcast->publish();

        $this->assertTrue($podcast->is_published);

        $podcast->refresh();
        
        $this->assertTrue($podcast->is_published);
    }
}
