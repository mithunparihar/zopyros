<div>
    <div>
        @foreach ($lists as $list)
            <div class="d-flex mb-3">
                <div class="flex-shrink-0">
                    @if ($list->social_media_icon == 'facebook')
                        <img src="{{ asset('admin/assets/img/icons/brands/facebook.png') }}" alt="facebook" class="me-3"
                            height="30">
                    @endif
                    @if ($list->social_media_icon == 'linkedin')
                        <img src="{{ asset('admin/assets/img/icons/brands/linkedin.png') }}" alt="linkedin" class="me-3"
                            height="30">
                    @endif
                    @if ($list->social_media_icon == 'youtube')
                        <img src="{{ asset('admin/assets/img/icons/brands/youtube.png') }}" alt="youtube"
                            class="me-3" height="30">
                    @endif
                    @if ($list->social_media_icon == 'whatsapp')
                        <img src="{{ asset('admin/assets/img/icons/brands/whatsapp.png') }}" alt="whatsapp"
                            class="me-3" height="30">
                    @endif
                    @if ($list->social_media_icon == 'twitter')
                        <img src="{{ asset('admin/assets/img/icons/brands/twitter.png') }}" alt="twitter"
                            class="me-3" height="30">
                    @endif
                    @if ($list->social_media_icon == 'instagram')
                        <img src="{{ asset('admin/assets/img/icons/brands/instagram.png') }}" alt="instagram"
                            class="me-3" height="30">
                    @endif
                    @if ($list->social_media_icon == 'telegram')
                        <img src="{{ asset('admin/assets/img/icons/brands/telegram.png') }}" alt="telegram"
                            class="me-3" height="30">
                    @endif
                    @if ($list->social_media_icon == 'pinterest')
                        <img src="{{ asset('admin/assets/img/icons/brands/pinterest.svg') }}" alt="pinterest"
                            class="me-3" height="30">
                    @endif
                </div>
                <div class="flex-grow-1 row">
                    <div class="col-8 col-sm-7 mb-sm-0 mb-2">
                        <h6 class="mb-0">{{ ucwords($list->social_media_icon) }}</h6>
                        @if (!empty($list->link) && $list->social_media_icon != 'whatsapp')
                            <a href="{{ $list->link }}" target="_blank">{{ '@' . \Content::ProjectName() }}</a>
                        @elseif(!empty($list->link) && $list->social_media_icon == 'whatsapp')
                            <a href="https://api.whatsapp.com/send?phone=+{{ $list->link }}&text=Hi, I would like to get more information..!"
                                target="_blank">{{ '@' . \Content::ProjectName() }}</a>
                        @else
                            <small class="text-danger">Not Connected</small>
                        @endif
                    </div>
                    <div class="col-4 col-sm-5 text-end">
                        <label class="switch switch-primary me-0">
                            <input type="checkbox"
                                wire:click="DataStatus({{ $list->is_publish }},{{ $list->id }})"
                                value="{{ $list->is_publish }}" class="switch-input" @checked($list->is_publish)>
                            <span class="switch-toggle-slider">
                                <span class="switch-on">
                                    <i class="bx bx-check"></i>
                                </span>
                                <span class="switch-off">
                                    <i class="bx bx-x"></i>
                                </span>
                            </span>
                            <span class="switch-label"></span>
                        </label>
                        <a href="{{ route('admin.socialMedia.edit', ['info' => $list->id]) }}"
                            class="btn btn-icon btn-sm btn-label-secondary sws-dark sws-bounce sws-top" data-title="Edit">
                            <i class="bx bxs-pencil"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
