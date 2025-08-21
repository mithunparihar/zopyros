@extends('layouts.app')
@section('content')
    <main>
        <section class="pt-4 Home">
            <div class="container">
                <x-breadcrumb :lists="$breadcrumb = [
                    'Career' => route('career'),
                    $list->title => url()->current(),
                ]" />
                <h1 class="Heading h2">{{ $list->title }}</h1>
                <div class="p-3 JobBox mb-4 border border-dark mt-4">
                    <ul class="Jobpost">
                        <li><svg viewBox="0 0 20 25">
                                <path
                                    d="M19,9c0,8-9,15-9,15S1,17,1,10A9,9,0,0,1,19,9ZM10,5a5,5,0,1,1-5,5A5,5,0,0,1,10,5Z" />
                            </svg> <span>{{ $list->location }}</span></li>
                        <li><svg viewBox="0 0 20 28">
                                <path
                                    d="M10,9c12-0,12,18,0,18C-2,27-2,9,10,9ZM5,4V7M15,4V7M10,1V7m2,9a2,2,0,1,0-4,0c0,3,4,1,4,4a2,2,0,1,1-4,0m2-8v1m0,10v1" />
                            </svg> {{ $list->salary }}</li>
                        <li>{{ $list->job_type }}</li>
                    </ul>
                </div>
                {!! $list->description !!}
                <a href="#ApplyPopup" data-bs-toggle="modal" data-bs-target="#ApplyPopup" class="btn btn-thm btn-lg">Apply for
                    this job</a>
            </div>
        </section>
        <section>
            <div class="container">
                <h2 class="Heading h2">Other Job</h2>
                <div class="row row-gap-4 mt-4">
                    <?php for($j=1; $j<=2;$j++) {?>
                    <div class="col-md-6">
                        <a href="career-details.php" class="card CareerBox">
                            <div class="card-header">
                                <div class="JobTitle">
                                    <h3 class="h5 fw-semibold m-0">Web Developer</h3>
                                    <small class="text-seconadry"><i>IT department</i></small>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="small">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                <ul class="Jobpost">
                                    <li><svg viewBox="0 0 20 25">
                                            <path
                                                d="M19,9c0,8-9,15-9,15S1,17,1,10A9,9,0,0,1,19,9ZM10,5a5,5,0,1,1-5,5A5,5,0,0,1,10,5Z" />
                                        </svg> <span>Delhi</span></li>
                                    <li><svg viewBox="0 0 20 28">
                                            <path
                                                d="M10,9c12-0,12,18,0,18C-2,27-2,9,10,9ZM5,4V7M15,4V7M10,1V7m2,9a2,2,0,1,0-4,0c0,3,4,1,4,4a2,2,0,1,1-4,0m2-8v1m0,10v1" />
                                        </svg> 75k - 90k / Year</li>
                                    <li>Full Time</li>
                                </ul>
                            </div>
                        </a>
                    </div>
                    <?php }?>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('css')
    <x-meta :options="[
        'imgpath' => '',
        'img' => '',
        'title' => $list->meta_title ?? $list->title,
        'keywords' => $list->meta_keywords ?? $list->title,
        'description' => $list->meta_description ?? $list->title,
        'breadcrumb' => $breadcrumb ?? '',
    ]" />
    <link rel="stylesheet" href="{{ \App\Enums\Url::CSS }}pages.min.css" fetchpriority="high">
@endpush
@push('js')
    <div class="modal fade" id="ApplyPopup" tabindex="-1" aria-labelledby="ApplyPopupLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content resume" enctype="multipart/form-data">
                <div class="modal-header p-0 border-0"><button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button></div>
                <div class="modal-body px-xl-4 grey d-flex flex-column gap-3 contact">
                    <h3 class="fs-3 text-center m-0">Web Developer</h3>
                    <div class="row row-gap-4">
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control inputTextBox" id="name" name="name"
                                    value="" placeholder="Name">
                                <label for="name" class="form-label">Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="Email" name="email" value=""
                                    placeholder="Email ID">
                                <label for="Email" class="form-label">Email</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="Phone" maxlength="15"
                                    oninput="maxLengthCheck(this)" name="phone" value="" placeholder="Phone No.">
                                <label for="Phone" class="form-label">Phone No.</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <select class="form-control form-select" aria-label=".form-select-lg example"
                                    name="experience">
                                    <option disabled="" selected="" class="d-none">Select Experience</option>
                                    <option value="0-1">0-1 Year</option>
                                    <option value="1-2">1-2 Year</option>
                                    <option value="2-5">2-5 Year</option>
                                    <option value="5-8">5-8 Year</option>
                                    <option value="8+">8+ Year</option>
                                </select>
                                <label for="experience" class="form-label">Experience</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input type="file" class="form-control" id="upResume" name="resume">
                                <!-- <label class="input-group-text" for="upResume">Upload <span>&nbsp;Resume</span></label> -->
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" name="message" id="Comments"></textarea>
                                <label for="Comments">Comments</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-black m-0">Send Now <svg viewBox="0 0 13 12">
                                <line x1="1" y1="6" x2="12" y2="6" />
                                <polyline points="7 1 12 6 7 11" />
                            </svg></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
