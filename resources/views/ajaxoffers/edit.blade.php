<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        {{-- Bootstrap css --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                /* display: flex; */
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            form{
                margin: 20px;
            }
        </style>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li class="nav-item">
                                <a class="nav-link" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>

        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    {{-- Add Your Offer --}}
                    {{ __('messages.Edit Offer') }}
                </div>
            </div>

            @if (Session::has('success'))
            <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
            @endif

            <form method="POST" action="{{ route('offers-update', $offer -> id) }}">
                {{-- <input name="_token" value="{{ csrf_token() }}"> --}}
                @csrf
                <div class="form-group">
                    <label for="offername"> {{ __('messages.offernameAR') }} </label>
                    <input type="text" class="form-control" id="offername" name="name_ar" value="{{ $offer -> name_ar }}">
                    @error('name_ar')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="offername"> {{ __('messages.offernameEN') }} </label>
                    <input type="text" class="form-control" id="offername" name="name_en"  value="{{ $offer -> name_en }}">
                    @error('name_en')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="offerprice" class="form-label">{{ __('messages.offerprice') }}</label>
                    <input type="text" class="form-control" id="offerprice" name="price"  value="{{ $offer -> price }}">
                    @error('price')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="offerdetails" class="form-label">{{ __('messages.offerdetailsAR') }}</label>
                    <input type="text" class="form-control" id="offerdetails" name="details_ar" value="{{ $offer -> details_ar }}">
                    @error('details_ar')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="offerdetails" class="form-label">{{ __('messages.offerdetailsEN') }}</label>
                    <input type="text" class="form-control" id="offerdetails" name="details_en" value="{{ $offer -> details_en }}">
                    @error('details_en')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.saveoffer') }}</button>
            </form>
        </div>
    </body>
</html>
