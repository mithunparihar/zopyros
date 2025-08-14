@php
    $imgArr = explode('.', $imageName);
    $ext = array_pop($imgArr);
    $width = $attributes['width'] ?? $widthName;

    $pathNameArr = explode('_',$pathName);
    $pathName = implode('/',$pathNameArr);

    $fullPath = public_path('storage/' . $pathName . '/' . $imageName);

@endphp

@if (file_exists($fullPath) && !empty($imageName))
    <img src="{{ route('image.resize', [
        'filename' => $imageName,
        'path' => str_replace('/','_',$pathName),
        'width' => $width,
    ]) }}"
        {{ $attributes->merge() }} loading="lazy" fetchpriority="low">

@else
    <img src="{{ asset('admin/img/no-img.jpg') }}" {{ $attributes->merge() }} loading="lazy" fetchpriority="low">
@endif
