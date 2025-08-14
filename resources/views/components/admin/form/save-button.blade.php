<div {{ $attributes->merge(['class' => 'col-sm-12']) }}>
    <button wire:loading.remove wire:target="{{ $attributes['target'] }}" class="btn rounded-pill btn-primary spbtn"><i
            class="fas fa-save me-1"></i> {!! $slot !!}</button>
    <span wire:loading class="span-disabled" wire:target="{{ $attributes['target'] }}">
        <button class="btn rounded-pill btn-primary plbtn" type="button" disabled>
            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
            Please wait...
        </button>
    </span>
</div>
