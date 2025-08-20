<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $sliders      = \App\Models\Banner::active()->latest()->get();
        $categories   = \App\Models\Category::parent(0)->active()->latest()->take(10)->get();
        $blogs        = \App\Models\Blog::active()->latest('post_date')->take(10)->get();
        $products     = \App\Models\Product::active()->latest()->take(10)->get();
        $testimonials = \App\Models\Testimonial::active()->latest()->take(10)->get();
        return view('home', compact('sliders', 'categories', 'blogs', 'products', 'testimonials'));
    }

    public function about()
    {
        $awards = \App\Models\Award::active()->latest()->take(20)->get();
        return view('about', compact('awards'));
    }

    public function awards()
    {
        $awards = \App\Models\Award::active()->latest()->get();
        return view('awards', compact('awards'));
    }
    public function testimonials()
    {
        $testimonials = \App\Models\Testimonial::active()->latest()->paginate(30);
        return view('testimonials', compact('testimonials'));
    }
    public function team()
    {
        $teams = \App\Models\Team::active()->latest()->paginate(80);
        return view('team', compact('teams'));
    }

    public function projects($alias = null)
    {
        if ($alias) {
            $project = \App\Models\Project::active()->whereSlug($alias)->firstOrFail();
            return view('project.info', compact('project'));
        }
        $projects = \App\Models\Project::active()->latest()->paginate(80);
        return view('project.lists', compact('projects'));
    }

    public function blog($alias = null)
    {
        if ($alias) {
            $blog = \App\Models\Blog::active()->whereSlug($alias)->firstOrFail();
            return view('blog.info', compact('blog'));
        }
        $blogs = \App\Models\Blog::active()->latest()->paginate(80);
        return view('blog.lists', compact('blogs'));
    }

}
