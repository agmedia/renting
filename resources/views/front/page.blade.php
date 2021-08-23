@extends('front.layouts.app')

@section('content')

    <!-- Page Title-->
    <div class="page-title-overlap bg-dark pt-4" style="background-image: url({{ asset('media/img/indexslika.jpg') }});-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $page->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-4">
        <h1>{{ $page->title }}</h1>
    </div>

@endsection
