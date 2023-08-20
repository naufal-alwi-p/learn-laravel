@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/request" class="btn btn-primary mb-3" role="button"><i class="bi bi-list-ul"></i> Request Index</a>

    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">Retrieving The Request Path</h5>
            <p class="card-text">Request Path: <span class="badge text-bg-success">{{ $request_path }}</span></p>

            <hr>

            <h5 class="card-title">Inspecting The Request Path / Route</h5>
            <p class="card-text">Check Path is(): <span class="badge text-bg-success">{{ $is }}</span></p>
            <p class="card-text">Check Named Route is(): <span class="badge text-bg-success">{{ $routeIs }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving The Request URL</h5>
            <p class="card-text">URL: <span class="badge text-bg-success">{{ $url }}</span></p>
            <p class="card-text">Full URL: <span class="badge text-bg-success">{{ $fullUrl }}</span></p>
            <p class="card-text">Full URL With Query: <span class="badge text-bg-success">{{ $fullUrlWithQuery }}</span></p>
            <p class="card-text">Full URL Without Query: <span class="badge text-bg-success">{{ $fullUrlWithoutQuery }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving The Request Host</h5>
            <p class="card-text">Host: <span class="badge text-bg-success">{{ $host }}</span></p>
            <p class="card-text">HTTP Host: <span class="badge text-bg-success">{{ $httpHost }}</span></p>
            <p class="card-text">Scheme and HTTP Host: <span class="badge text-bg-success">{{ $schemeAndHttpHost }}</span></p>
            <p class="card-text">Scheme: <span class="badge text-bg-success">{{ $scheme }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving The Request Method</h5>
            <p class="card-text">HTTP Method: <span class="badge text-bg-success">{{ $method }}</span></p>
            <p class="card-text">Check HTTP Method: <span class="badge text-bg-success">{{ $isMethod }}</span></p>

            <hr>

            <h5 class="card-title">Request Headers</h5>
            <p class="card-text">Accespt Header: <span class="badge text-bg-success">{{ $headerAccept }}</span></p>
            <p class="card-text">Check Accept-Language Header: <span class="badge text-bg-success">{{ $hasHeaderAcceptLanguage }}</span></p>

            <hr>

            <h5 class="card-title">Request IP Address</h5>
            <p class="card-text">Client IP Address: <span class="badge text-bg-success">{{ $ipAddress }}</span></p>

            <hr>

            <h5 class="card-title">Content Negotiation</h5>
            <p class="card-text">Acceptable Content Type:
                <br>
                @foreach ($AcceptableContentType as $contentType)
                    <span class="badge text-bg-success">{{ $contentType }}</span>

                    @if (!$loop->last)
                        <br>
                    @endif
                @endforeach
            </p>
            <p class="card-text">Is Accepted Content: <span class="badge text-bg-success">{{ $isAccepted }}</span></p>
            <p class="card-text">Preferred Content Priority:
                <br>
                @foreach ($preferredContent as $content)
                    {{ $loop->iteration }}. <span class="badge text-bg-success">{{ $content }}</span>

                    @if (!$loop->last)
                        <br>
                    @endif
                @endforeach
            </p>
            <p class="card-text">Expect JSON: <span class="badge text-bg-success">{{ $expectJson }}</span></p>

            <hr>

            <h5 class="card-title">Another Request Method</h5>
            <p class="card-text">Is JSON: <span class="badge text-bg-success">{{ $isJson }}</span></p>
            <p class="card-text">Wants JSON: <span class="badge text-bg-success">{{ $wantsJson }}</span></p>
            <p class="card-text">Accepts JSON: <span class="badge text-bg-success">{{ $acceptsJson }}</span></p>
            <p class="card-text">Accepts HTML: <span class="badge text-bg-success">{{ $acceptsHtml }}</span></p>
            <p class="card-text">Format: <span class="badge text-bg-success">{{ $format }}</span></p>
            <p class="card-text">Root URL: <span class="badge text-bg-success">{{ $root }}</span></p>
            <p class="card-text">Decoded Path: <span class="badge text-bg-success">{{ $decodedPath }}</span></p>
            <p class="card-text">Segment Path:
                <br>
                @foreach ($segments as $segment)
                    <span class="badge text-bg-success">{{ $segment }}</span>
                    @if (!$loop->last)
                        <br>
                    @endif
                @endforeach
            </p>
            <p class="card-text">User Agent: <span class="badge text-bg-success">{{ $userAgent }}</span></p>
            <p class="card-text">Secure: <span class="badge text-bg-success">{{ $secure }}</span></p>
            <p class="card-text">AJAX: <span class="badge text-bg-success">{{ $ajax }}</span></p>
            <p class="card-text">PJAX: <span class="badge text-bg-success">{{ $pjax }}</span></p>
            <p class="card-text">Prefetch: <span class="badge text-bg-success">{{ $prefetch }}</span></p>

            <hr>

            <h5 class="card-title">$request->server()</h5>
            @foreach ($server as $key => $value)
                @if ($key === 'HTTP_COOKIE')
                    <p class="card-text">{{ $key }}: <span class="badge text-bg-success text-wrap text-start" style="width: 100%">{{ $value }}</span></p>
                @else
                    <p class="card-text">{{ $key }}: <span class="badge text-bg-success">{{ $value }}</span></p>
                @endif
            @endforeach
        </div>
    </div>
@endsection