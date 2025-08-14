<title>{!! $title !!}</title>
<meta name="description" content="{!! $description !!}">
<meta name="keywords" content="{!! $keywords !!}">

<link rel="canonical" href="{{ url()->current() }}">
<meta id="subject" name="subject" content="{{ $title }}">
<meta id="document-type" name="document-type" content="public">
<meta id="Copyright" name="Copyright" content="Copyright@gvroofs">
<meta id="distribution" name="distribution" content="Global">
<meta id="robots" name="robots" content="INDEX,FOLLOW">
<meta id="audience" name="audience" content="All, Business">
<meta id="googlebot" name="googlebot"
    content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta id="bingbot" name="bingbot"
    content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="msnbot" content="index, follow">
<meta name="YahooSeeker" content="index, follow">
<meta id="country" name="country" content="UAE">
<meta id="city" name="city" content="Dubai, Ajman, Al-Ain, Abu Dhabi, Fujairah, Dubai, Sharjah">
<meta id="email" name="reply-to" content="info@gvroofs.com">
<meta name="allow-search" content="yes">
<meta name="revisit-after" content="daily">
<meta name="distribution" content="global">
<meta name="Rating" content="General">
<meta name="coverage" content="Worldwide">
<meta name="expires" content="never">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@gvroofs">
<meta name="twitter:creator" content="@gvroofs">
<meta name="twitter:title" content="{!! $title !!}">
<meta name="twitter:description" content="{!! $description !!}">
<meta name="twitter:image" content="{{ !empty($options['img']) ? \Image::showFile($options['imgpath'],500, $options['img']) : asset('frontend/img/logo.svg') }}">
<meta property="twitter:image:alt" content="{!! $title !!}">
<meta name="twitter:label2" content="Est. reading time">
<meta name="twitter:data2" content="11 minutes">
<meta name="twitter:label1" content="Written by">
<meta name="twitter:data1" content="gvroofs">

<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="{{ $options['metatype'] ?? 'website' }}">
<meta property="og:title" content="{!! $title !!}">
<meta property="og:description" content="{!! $description !!}">
<meta property="og:image" content="{{ !empty($options['img']) ? \Image::showFile($options['imgpath'],500, $options['img']) : asset('frontend/img/logo.svg') }}">
<meta property="og:image:alt" content="{!! $title !!}">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:site_name" content="gvroofs">
