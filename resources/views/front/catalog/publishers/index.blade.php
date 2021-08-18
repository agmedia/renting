@extends('front.layouts.app')

@section('content')

    <section class="position-relative  bg-size-cover bg-position-center-x position-relative py-3 mb-3" style="background-image: url({{ asset('media/img/indexslika.jpg') }})">
        <div class="container position-relative zindex-5 py-4 my-3">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="text-light text-center">Lista nakladnika</h1>
                    <p class="pb-0 text-light text-center mb-0">Pretraživanje prema početnom slovu imena nakladnika</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Topics grid-->
    <section class="container py-3 mb-5">
        <div class="row align-items-center py-md-3">
            <div class="col-lg-10 col-md-12 offset-lg-1 py-4 text-center">

                @foreach ($letters as $item)
                    <a href="{{ route('catalog.route.publisher', ['publisher' => null, 'letter' => $item['value']]) }}"
                       class="btn btn-secondary btn-icon m-2 @if( ! $item['active']) disabled @endif @if($item['value'] == $letter) bg-fourth disabled @endif">
                        <h3 class="h4 text-dark py-0 mb-0 px-1">{{ $item['value'] }}</h3>
                    </a>
                @endforeach

            </div>
        </div>

        <div class="row py-md-3">
            <div class="col-lg-12 text-center mb-5">
                <h1>{{ $letter }}</h1>
                <hr>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <ul class="list-group">
                    @foreach ($publishers as $publisher)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('catalog.route.publisher', ['publisher' => $publisher]) }}">
                                <span>{{ $publisher->title }}</span>
                            </a>
                            <span class="badge rounded-pill bg-secondary">{{ $publisher->products()->count() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

@endsection
