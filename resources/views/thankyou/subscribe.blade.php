@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="[
                    'Thank You for Subscribing!' => url()->current(),
                ]" />
                <h1 class="Heading h2 mb-4">Thank You for Subscribing!</h1>
                <div class="CmsPage mt-2">
                    <p class="mb-0">You're all set — welcome to the community!</p>
                    <p>We're excited to have you on board. From now on, you’ll receive the latest updates, exclusive
                        content, and special offers straight to your inbox.</p>
                    <p class="mb-0"><b>👉 What’s next?</b></p>
                    <ul>
                        <li>Be sure to whitelist our email address so you don’t miss anything.</li>
                        <li>Follow us on Facebook, Instagram for more updates.</li>
                    </ul>
                    <p>Thanks again for joining us!</p>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => 'Thank You for Subscribing!',
        'keywords' => '',
        'description' => '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
@endpush
