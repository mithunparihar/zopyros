@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="[
                    'Thank You for Getting in Touch!' => url()->current(),
                ]" />
                <h1 class="Heading h2 mb-4">Thank You for Getting in Touch!</h1>
                <div class="CmsPage mt-2">
                    <p class="mb-2">We’ve received your message and want to thank you for reaching out. One of our team
                        members will get back to you as soon as possible—usually within 48 hours.</p>
                    <p class="mb-0"><b>In the meantime, feel free to:</b></p>
                    <ul>
                        <li>Explore more about our categories <a href="{{ route('categories') }}" class="thm border-bottom">Click
                                Here</a></li>
                        <li>Read our latest insights on the blog <a href="{{ route('blog') }}" class="thm border-bottom">Click
                                Here</a></li>
                        <li>Follow us on Facebook, Instagram for updates</li>
                    </ul>
                    <p>We appreciate your interest and look forward to connecting with you!</p>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => 'Thank You for Getting in Touch!',
        'keywords' => '',
        'description' => '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
@endpush
