{{-- <details class="border p-2 rounded-1 my-2">
    @if ($category->childs()->active()->count() == 0)
        <div class="col-md-3">
            <div class="form-check form-check-primary">
                <input class="form-check-input" wire:model="selectedpermission" type="checkbox"
                    id="permission-{{ $category->id }}" value="{{ $category->id }}">
                <label class="form-check-label" for="permission-{{ $category->id }}">{{ $category->title }}</label>
            </div>
        </div>
    @endif

    @if ($category->childs()->active()->count() > 0)
        <summary>{{ $category->title }}</summary>
        <div className="mt-2">
            @foreach ($category->childs()->active()->get() as $cate)
                <x-admin.category-tree :category="$cate" />
            @endforeach
        </div>
    @endif
</details> --}}

@php
    $childs = $category->childs()->active()->get();
@endphp

<div class="border p-2 mb-2 rounded-2">
    <label for="category-{{ $category->id }}" data-bs-target="#collapseExample-{{ $category->id }}" role="button"
        aria-expanded="false" aria-controls="collapseExample" data-bs-toggle="collapse"
        class="d-flex justify-content-between CollapseCat collapsed">
        <div>
            @if (count($childs) > 0)
                <i class="bx bxs-right-arrow small"></i>
                {{ $category->title }}
            @else
                <div class="form-check form-check-primary">
                    <input class="form-check-input" wire:model="categories" type="checkbox"
                        id="permission-{{ $category->id }}" value="{{ $category->id }}">
                    <label class="form-check-label" for="permission-{{ $category->id }}">{{ $category->title }}</label>
                </div>
            @endif
        </div>
    </label>

    @if (count($childs) > 0)
        <div class="collapse  {{ in_array($category->id, $prepermission) ? 'show' : '' }}"
            id="collapseExample-{{ $category->id }}">
            <div class="pt-2 mt-2 border-top">
                <div class="row">
                    @foreach ($childs ?? [] as $child)
                        @php
                            $childArr = $child->childs()->active()->get();
                        @endphp
                        @if (count($childArr ?? []) == 0)
                            <div class="col-md-12">
                                <div class="form-check form-check-primary">
                                    <input class="form-check-input" wire:model="categories" type="checkbox"
                                        id="permission-{{ $child->id }}" value="{{ $child->id }}">
                                    <label class="form-check-label"
                                        for="permission-{{ $child->id }}">{{ $child->title }}</label>
                                </div>
                            </div>
                        @endif


                        @if (count($childArr ?? []) > 0)
                            <div class="col-12 mt-2">
                                <x-admin.category-tree :category="$child" :prepermission="$prepermission" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
