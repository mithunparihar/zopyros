<div>
    <div class="tabtype">
        <a href="#Hsearch" data-bs-toggle="collapse" aria-expanded="false" aria-controls="Hsearch" title="Close"
            class="IconImg Dsearch collapsed">
            <svg viewBox="0 0 8 8" id="closeBtn">
                <path d="M1,7,7,1M7,7,1,1" />
            </svg>
        </a>
        <input type="text" name="q" id="SearchB" class="form-control" value="{{ request('q') }}"
            placeholder="Search..." autocomplete="off">
    </div>
    @if (count($results ?? []) > 0)
        <div class="SearchList">
            <ul class="p-0 m-0">
                @foreach ($results as $result)
                    @php
                        $url = '';
                        $type = '';
                        if ($result->source == 'products') {
                            $product = \App\Models\Product::find($result->id);
                            $image = $product->images[0]->image;

                            $url = route('category', [
                                'category' => $product->alias,
                            ]);
                            $type = '';
                            $folder = 'product';
                        }
                        if ($result->source == 'categories') {
                            $category = \App\Models\Category::find($result->id);
                            $url = route('category', ['category' => $category->fullURL()]);
                            $type = 'In Category';
                            $folder = 'categories';
                            $image = $category->image;
                        }
                    @endphp
                    <li class="border-bottom py-2"><a href="{{ $url }}"
                            class="d-flex gap-lg-3 gap-2 lh-n align-items-center">
                            <x-image-preview fetchpriority="low" loading="lazy" class="defaultimg"
                                imagepath="{{ $folder ?? '' }}" style="width: 50px;height:auto" width="500"
                                height="300" :image="$image ?? ''" />
                            <div>
                                <span>{{ $result->title }}</span>
                                @if (!empty($type))
                                    <small class="text-secondary">{{ $type }}</small>
                                @endif
                            </div>
                        </a></li>
                @endforeach
            </ul>
        </div>
    @endif
</div>


@push('js')
    <script>
        let time;

        let SearchB = document.getElementById('SearchB');
        SearchB.addEventListener('input', function(event) {
            let query = event.target.value;
            clearTimeout(time);
            time = setTimeout(() => {
                Livewire.dispatch('autoSearchData', {
                    query: query
                });
            }, 300);
        });
    </script>
@endpush
