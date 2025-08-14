<div @if($attributes['ignore']) wire:ignore @endif >
    <textarea {{ $attributes->merge(['class' => 'form-control','id'=>'', 'placeholder' => '', 'accept' => '']) }} >{!! $slot !!}</textarea>
</div>
