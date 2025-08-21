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
    public function terms()
    {
        return view('terms');
    }
    public function privacy()
    {
        return view('privacy');
    }
    public function contact()
    {
        $contact = \App\Models\Contact::find(1);
        return view('contact', compact('contact'));
    }
    public function career($alias = null)
    {
        if ($alias) {
            $list = \App\Models\Career::active()->whereAlias($alias)->firstOrFail();
            return view('career.info', compact('list'));
        }
        $lists = \App\Models\Career::active()->latest()->paginate(40);
        return view('career.list', compact('lists'));
    }
    public function faqs($category = null)
    {
        $lists = \App\Models\Faq::active();
        if ($category) {
            $lists = $lists->whereHas('categoryInfo', function ($qry) use ($category) {
                $qry->whereAlias($category)->active();
            });
            $category = \App\Models\FaqCategory::whereAlias($category)->active()->firstOrFail();
        }
        $lists      = $lists->latest()->paginate(20);
        $categories = \App\Models\FaqCategory::orderBy('title')->active()->get();
        return view('faqs', compact('lists', 'categories', 'category'));
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
            $blog            = \App\Models\Blog::active()->whereSlug($alias)->firstOrFail();
            $categories      = \App\Models\BlogCategory::whereHas('blogs')->active()->get();
            $previous        = \App\Models\Blog::where('post_date', '<', $blog->post_date)->active()->latest('post_date')->first();
            $next            = \App\Models\Blog::where('post_date', '>', $blog->post_date)->active()->latest('post_date')->first();
            $latest          = \App\Models\Blog::whereNot('slug', $alias)->active()->latest('post_date')->get();
            $tableofcontents = $blog->tableofcontent()->orderBy('sequence')->whereIsPublish(1)->get();

            return view('blog.info', compact('blog', 'previous', 'next', 'latest', 'tableofcontents', 'categories'));
        }
        $blogs = \App\Models\Blog::active()->latest()->paginate(80);
        return view('blog.lists', compact('blogs'));
    }

    public function blogcategory($category)
    {
        $categoryAlias = $category;
        $lists         = \App\Models\BlogCategory::whereSlug($categoryAlias)->active()->firstOrFail();
        $blogs         = \App\Models\Blog::where('category_id', $lists->id)->active()->paginate(40);
        return view('blog.category', compact('lists', 'blogs'));
    }

}
