<a href="{{ route('blog', ['alias' => $blog->slug]) }}"
    class="{{ $className }} shadow-none card ProBlock border-0 ProBlog">
    <div class="card-header">
        <div class="proimg">
            <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg" imagepath="blog" width="500"
                height="300" :image="$blog->image" />
        </div>
    </div>
    <div class="card-body px-0">
        <small>{{ \CommanFunction::dateformat($blog->post_date) }}</small>
        <h3 class="h4 m-0 text-u" title="{{ $blog->name }}">{{ $blog->name }}
        </h3>
    </div>
</a>
