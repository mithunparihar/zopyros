<a href="{{ route('category', ['category' => $product->alias.'/p/'.$colorInfo->alias,'pid'=>$lowestPrice->variant_id]) }}" class="shadow-none {{$className}} card ProBlock">
    <div class="card-header">
        <div class="proimg">
            <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg" imagepath="product" width="500"
                height="300" :image="$images[0]->image ?? ''" />
        </div>
    </div>
    <div class="card-body text-center">
        <h3 class="h4 m-0 text-u" title="{{ $product->title }}">{{ $product->title }}</h3>
        <span class="small">{{ $lowestPrice->sku ?? '' }}</span>
    </div>
</a>
