@if ($icons->isNotEmpty())
    <div class="icons {{ $className }}">
        @foreach ($icons as $icon)
            @if ($icon->social_media_icon == 'whatsapp')
                <a href="https://wa.me/<?= $icon->link ?>?text=Hi,&nbsp;I&nbsp;would&nbsp;like&nbsp;to&nbsp;get&nbsp;more&nbsp;information..!"
                    target="_blank" title="Whatsapp"><img loading="lazy" fetchpriority="low"
                        src="{{ \App\Enums\Url::IMG }}whatsapp-b.svg" alt="Whatsapp" width="20" height="20"></a>
            @else
                <a href="{{ $icon->link }}" target="_blank" title="{{ $icon->social_media_icon }}"><img loading="lazy"
                        fetchpriority="low" src="{{ \App\Enums\Url::IMG }}{{ $icon->social_media_icon }}-i.svg"
                        alt="{{ $icon->social_media_icon }}" width="20" height="20"></a>
            @endif
        @endforeach
    </div>
@endif
