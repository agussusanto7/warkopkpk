<?php

namespace App\Http\Controllers;

use App\Models\SiteImage;
use App\Models\Milestone;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $aboutHeaderImage = SiteImage::getImage('about_header');
        $aboutStoryImage = SiteImage::getImage('about_story');
        $milestones = Milestone::orderBy('year')->get();

        return view('about', compact('aboutHeaderImage', 'aboutStoryImage', 'milestones'));
    }
}
