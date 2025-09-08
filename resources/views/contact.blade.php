@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Contact' => url()->current(),
                ]" />
                @if (!empty($contact->email) || !empty($contact->phone) || !empty($contact->address))
                    <div class="ConInfos Boxs py-4">
                        @if (!empty($contact->address))
                            <div>
                                @if (!empty($contact->title))
                                    <span class="icon"><svg viewBox="0 0 20 25">
                                            <path
                                                d="M19,9c0,8-9,15-9,15S1,17,1,10A9,9,0,0,1,19,9ZM10,5a5,5,0,1,1-5,5A5,5,0,0,1,10,5Z" />
                                        </svg> {{ $contact->title }} </span>
                                @endif
                                <div>
                                    <span class="small">{{ $contact->address ?? '' }} </span>
                                </div>
                            </div>
                        @endif

                        @if (!empty($contact->phone))
                            <div>
                                <span class="icon"><svg viewBox="0 0 24 25">
                                        <path
                                            d="M23,20,20,17a1,1,0,0,0-1.5,0,21,21,0,0,0-2,2,1,1,0,0,1-1,0c-4-2-7-6-8-8a2,2,0,0,1,0-2C8,8,8,8,9,7a1,1,0,0,0,0-1c-1-1-2-2-4-4a1,1,0,0,0-1-0C3,2,1,5,1,5c0,7,9,19,19,19,0,0,2-2,3-3A1,1,0,0,0,23,20Z" />
                                    </svg></span>
                                <div>
                                    @foreach (explode(',', $contact->phone) as $k => $contactNos)
                                        <a href="tel:91<?= $contactNos ?>">(+91)-<?= $contactNos ?></a>{{ $loop->last ? '' : ', ' }}
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (!empty($contact->email))
                            <div>
                                <span class="icon"><svg viewBox="0 0 26 18">
                                        <path
                                            d="M4,1H22a3,3,0,0,1,3,3V14a3,3,0,0,1-3,3H4a3,3,0,0,1-3-3V4A3,3,0,0,1,4,1ZM22,4l-9,7a1,1,0,0,1-1,0L4,4" />
                                    </svg></span>
                                <div>
                                    @foreach (explode(',', $contact->email) as $k => $email)
                                        <a href="mailto:<?= $email ?>"><?= $email ?></a>{{ $loop->last ? '' : ', ' }}
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                @endif

            </div>
        </section>
        @livewire('contact-box')
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => \Content::meta(3)->title ?? '',
        'keywords' => \Content::meta(3)->title ?? '',
        'description' => \Content::meta(3)->title ?? '',
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}index.min.css" fetchpriority="high">
@endpush
