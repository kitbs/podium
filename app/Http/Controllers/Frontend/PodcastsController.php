<?php

namespace Podium\Http\Controllers\Frontend;

use Podium\Podcast;
use Illuminate\Http\Request;
use Podium\Http\Controllers\Controller;

class PodcastsController extends Controller
{
    /**
     * Display a listing of the podcast.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified podcast.
     *
     * @param  \Podium\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function show(Podcast $podcast)
    {
        return view('podcasts.show', compact('podcast'));
    }

    /**
     * Display the cover image for the specified podcast.
     *
     * @param  \Podium\Podcast  $podcast
     * @param  string $ext
     * @return \Illuminate\Http\Response
     */
    public function cover(Podcast $podcast, $ext)
    {
        //
    }

}
