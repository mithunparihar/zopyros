@if ($products->isNotEmpty())
    @foreach ($products as $product)
        <div class="ProList-item col-lg-4 col-sm-6">
            @livewire('product-box', ['product' => $product], key('PRD-'.$product->id))
        </div>
    @endforeach
    <div class="pagination d-flex justify-content-center">
        {{ $products->onEachSide(0)->withQueryString()->links() }}
    </div>
@else
    <div class="col-12 border-top border-bottom py-3 text-center">
        <p class="mb-0">We couldn't find any results matching your request.</p>
    </div>
@endif
