@extends('admin.layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="card-header">
                <div class="head-label d-flex justify-content-between">
                    <h5 class="card-title mb-0">Edit Social Account</h5>
                    <a href="{{ route('admin.socialMedia') }}" class="btn rounded-pill btn-label-danger btn-sm">
                        <span><i class="fa-solid fa-backward"></i>
                            <span class="d-none d-sm-inline-block">Back</span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="container">
                <form class="pt-0 row g-2" method="POST" action="{{ route('admin.socialMedia.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="preId" value="{{ $info->id }}">
                    <div class="col-sm-3 mb-2">
                        <label class="form-label" for="basicFullname">Social Account</label>
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2"
                                class="input-group-text {{ $errors->has('social_account') ? 'is-invalid' : '' }}"><i
                                    class="bx bx-file"></i></span>
                            <select name="social_account" class="form-select" id="social_account">
                                <option value="facebook" @selected($info->social_media_icon=='facebook')>Facebook</option>
                                <option value="youtube" @selected($info->social_media_icon=='youtube')>Youtube</option>
                                <option value="twitter" @selected($info->social_media_icon=='twitter')>Twitter</option>
                                <option value="linkedin" @selected($info->social_media_icon=='linkedin')>Linkedin</option>
                                <option value="instagram" @selected($info->social_media_icon=='instagram')>Instagram</option>
                                <option value="whatsapp" @selected($info->social_media_icon=='whatsapp')>Whatsapp</option>
                                <option value="telegram" @selected($info->social_media_icon=='telegram')>Telegram</option>
                                <option value="pinterest" @selected($info->social_media_icon=='pinterest')>Pinterest</option>
                            </select>
                        </div>
                        @error('social_account')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="email-username" data-validator="notEmpty">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div class="col-sm-{{ $info->social_media_icon=='whatsapp'?4:12 }} mb-2">
                        <x-admin.form.label asterisk="true" for="basicFullname" :title="$info->social_media_icon=='whatsapp'?'Whatsapp Number':'Link'"/>
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2"
                                class="input-group-text {{ $errors->has('link') ? 'is-invalid' : '' }}"><i
                                    class="bx bx-file"></i></span>
                            <input type="text" id="basicFullname" name="link"
                                class="form-control dt-full-name {{ $errors->has('link') ? 'is-invalid' : '' }}" value="{{ old('link',$info->link) }}"
                                placeholder="{{ $info->social_media_icon=='whatsapp'?'Whatsapp Number':'Link' }} Here..." />
                        </div>
                        @error('link')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="email-username" data-validator="notEmpty">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>
                    <x-admin.form.save-button>Update & Proceed</x-admin.form.save-button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('metatitle', 'Edit Counters  : ' . \Content::ProjectName())
@push('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush
@push('js')
<script src="https://cdn.tiny.cloud/1/{{ env('TINY_EDITOR_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin">
</script>
<script src="{{ asset('admin/js/editor.js') }}"></script>
<script src="{{ asset('admin/js/table.js') }}"></script>
@endpush