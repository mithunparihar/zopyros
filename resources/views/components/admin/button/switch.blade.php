<label class="switch switch-primary {{ $disabled?'sws-bounce sws-top':'' }}" data-title="This action cannot be undone.">
    <input type="checkbox" data-publish="{{ $url }}" data-type="{{ $dataType ?? 'publish' }}" @checked($checked) value="{{ $value }}"
        class="switch-input  publish"  @disabled($disabled) />
    <span class="switch-toggle-slider">
        <span class="switch-on">
            <i class="bx bx-check"></i>
        </span>
        <span class="switch-off">
            <i class="bx bx-x"></i>
        </span>
    </span>
</label>
