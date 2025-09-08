<a href="{{route('category',['category'=>$category->fullURL()])}}" class="{{ $className }} shadow-none card ProBlock ProCatS">
    <div class="card-header">
        <div class="proimg">
            <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg" imagepath="categories" width="500" alt="{{ str_replace(' ', '-', $category->title) }}"
                height="300" :image="$category->image" />
        </div>
    </div>
    <div class="card-body">
        <h3 class="h4 m-0" title="Category Name">{{ $category->title }}</h3>
        <span class="btn btn-o-white border-0">Discover {{ $category->title }}</span>
    </div>
</a>
