@extends('layouts.app')
@section('content')
    @php
        $breadcrumb = ['Categories' => route('categories')];
        foreach ($explode as $key => $expl) {
            $serInfo = \App\Models\Category::whereAlias($expl)->active()->first();
            if ($serInfo) {
                $breadcrumb = array_merge($breadcrumb, [
                    $serInfo->title => route('category', ['category' => $serInfo->fullURL()]),
                ]);
            }
        }
    @endphp
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb" />
                <h1 class="Heading h2">{{ $category->title }}</h1>
                <div class="row mt-4 row-gap-4">
                    @foreach ($category->childs()->active()->get() as $categor)
                        <div class="col-lg-4 col-md-6">
                            @livewire('category-box', ['category' => $categor], key('CAT-' . $categor->id))
                        </div>
                    @endforeach
                </div>
                <div class="CmsPage mt-4">{!! $category->description !!}</div>
                @if ($faqs->isNotEmpty())
                    <div class="FAQsD mt-4">
                        <h2 class="">{{ $category->title }} FAQs</h2>
                        @foreach ($faqs as $faq)
                            <details name="accordion" {{$loop->index==0?'open':''}}>
                                <summary>{{$faq->title}}</summary>
                                <div class="text">
                                    {!! $faq->description !!}
                                </div>
                            </details>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => 'categoires',
        'img' => $category->image,
        'title' => $category->meta_title ?? $category->title,
        'keywords' => $category->meta_keywords ?? $category->title,
        'description' => $category->meta_description ?? $category->title,
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
@endpush
