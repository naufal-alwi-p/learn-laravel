@extends('template.main')

@section('content')
    <h1 class="mt-5 mb-3">{{ $title }}</h1>
    <button type="button" class="btn btn-primary" onclick="reqJSONP()">Create Request</button>

    <div class="card my-3">
        <div class="card-body display-data">
            <p class="card-text">Kosong</p>
        </div>
    </div>

    <script>
        const display = document.querySelector(".display-data");

        function reqJSONP() {
            const element = document.createElement("script");
            element.src = "http://127.0.0.1:8000/belajar-laravel/response/jsonp-response?callback=processingJSONP";
            document.body.appendChild(element);
        }

        function processingJSONP(obj) {
            display.innerHTML = "";

            for(let key in obj) {
                display.innerHTML += `<p class="card-text">${key}: ${obj[key]}</p>`;
            }
        }
    </script>
@endsection