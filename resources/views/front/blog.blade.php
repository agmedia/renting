@extends('front.layouts.app')

@section('content')

    <!-- Page Title-->
    <div class=" bg-dark pt-4 pb-3" style="background-image: url({{ asset('media/img/indexslika.jpg') }});-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                                <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $blog->title }}</li>
                            </ol>
                        </nav>

            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="text-light">{{ $blog->title }}</h1>
        </div>
        </div>
    </div>



    <div class="container">



        <div class="mt-3 mb-5">
        {!! $blog->description !!}
        </div>

    </div>

@endsection
