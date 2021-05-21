@extends('front.layouts.app')

@section('content')

    <!-- Page Title-->
    <div class="page-title-overlap bg-dark pt-4" style="background-image: url('media/img/indexslika.jpg');-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>
                        <li class="breadcrumb-item text-nowrap"><a href="#">Knjige</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Vukovi jedu pse</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-light mb-0">Martin Cruz Smith: Vukovi jedu pse</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Gallery + details-->
        <div class="bg-light shadow-lg rounded-3 px-4 py-3 mb-5">
            <div class="px-lg-3">
                <div class="row">
                    <!-- Product gallery-->
                    <div class="col-lg-7 pe-lg-0 pt-lg-4">
                        <div class="product-gallery">
                            <div class="product-gallery-preview ">
                                <div class="product-gallery-preview-item active" id="first"><img class="image-zoom" src="media/img/knjiga-detalj.jpg"  alt="Product image">

                                </div>
                                <div class="product-gallery-preview-item" id="second"><img class="image-zoom" src="media/img/knjiga-detalj.jpg"  alt="Product image">

                                </div>
                                <div class="product-gallery-preview-item" id="third"><img class="image-zoom" src="media/img/knjiga-detalj.jpg"  alt="Product image">

                                </div>
                                <div class="product-gallery-preview-item" id="fourth"><img class="image-zoom" src="media/img/knjiga-detalj.jpg"  alt="Product image">
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="product-gallery-thumblist mx-auto justify-content-center">
                                    <a class="product-gallery-thumblist-item active" href="#first"><img src="media/img/knjiga-detalj-thumb.jpg" alt="Product thumb"></a>
                                    <a class="product-gallery-thumblist-item" href="#second"><img src="media/img/knjiga-detalj-thumb.jpg" alt="Product thumb"></a>
                                    <a class="product-gallery-thumblist-item" href="#third"><img src="media/img/knjiga-detalj-thumb.jpg" alt="Product thumb"></a>
                                    <a class="product-gallery-thumblist-item" href="#fourth"><img src="media/img/knjiga-detalj-thumb.jpg" alt="Product thumb"></a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Product details-->
                    <div class="col-lg-5 pt-4 pt-lg-0">
                        <div class="product-details ms-auto pb-3">

                            <div class="mb-3 mt-4"><span class="h3 fw-normal text-accent me-1">80.<small>00kn</small></span>
                                <del class="text-muted fs-lg me-3">100.<small>00kn</small></del><span class="badge bg-danger  align-middle mt-n2">Akcija</span> <span class="badge bg-fourth  align-middle mt-n2">Dostupno</span>
                            </div>

                            <form class="mb-grid-gutter" method="post">

                                <div class="mb-3 d-flex align-items-center">
                                    <select class="form-select me-3" style="width: 5rem;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <a class="btn btn-primary btn-shadow d-block w-100" href="{{ route('kosarica') }}"><i class="ci-cart fs-lg me-2"></i>Dodaj u košaricu</a>
                                </div>
                            </form>
                            <!-- Product panels-->
                            <ul class="list-unstyled fs-sm spec">
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Autor</span><span class="text-muted"><a class="product-meta text-primary" href="#">Martin Cruz Smith</a></span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Izdavač</span><a class="product-meta text-primary" href="#">Algoritam</a></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Šifra</span><span class="text-muted">60574</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Broj stranica</span><span class="text-muted">314</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Dimenzije</span><span class="text-muted">6×24</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Mjesto izdavanja</span><span class="text-muted">Zagreb</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Pismo</span><span class="text-muted">Latinica</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Stanje</span><span class="text-muted">Odlično</span></li>
                                <li class="d-flex justify-content-between mb-2 pb-2 border-bottom"><span class="text-dark fw-medium">Uvez</span><span class="text-muted">Tvrdi</span></li>
                            </ul>

                            <div class=" pt-2 pb-4 mb-1">

                                <div class="mt-3"><span class="d-inline-block align-middle text-muted fs-sm me-3 mt-1 mb-2">Podijeli:</span>
                                    <a class="btn-social bs-facebook me-2 mb-2" href="#"><i class="ci-facebook"></i></a>
                                    <a class="btn-social bs-twitter me-2 mb-2" href="#"><i class="ci-twitter"></i></a>
                                    <a class="btn-social bs-odnoklassniki me-2 mb-2" href="#"><i class="ci-mail"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-md-3">

            <div class="col-lg-8 col-md-12 offset-lg-2 py-4 text-center">
                <h2 class="h3 mb-2 pb-0">Vukovi jedu pse</h2>
                <h3 class="h6 mb-4">Smith Martin Cruz</h3>
                <p class="fs-md  pb-2">Peti nastavak serijala o Arkadiju Renku “Vukovi jedu pse” iz pera Martina Cruza Smitha pokazati će da melankolični, beskompromisni, povučeni Renko nije izgubio ništa od svojega šarma kojim je opsjeo čitatelje u doba hladnog rata, još tamo daleke 1981. kada je objavljen prvi roman u seriji, “Park Gorkoga”.</p>
                <div class="mt-3 me-3"><a class="btn-tag me-2 mb-2" href="#">#kriminalistika</a><a class="btn-tag mb-2" href="#">#roman</a></div>
            </div>
        </div>

    </div>

    <!-- Product carousel (You may also like)-->
    <div class="container py-5 my-md-3">
        <h2 class="h3 text-center pb-4">Preporučamo</h2>
        <div class="tns-carousel tns-controls-static tns-controls-outside">
            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;controls&quot;: false, &quot;nav&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 18},&quot;768&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 30}}}">
                <div>
                    <div class="card product-card-alt">
                        <div class="product-thumb">

                            <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                            </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga.jpg" alt="Product">
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="#">

                                        Wroblewski David </a></div>
                                <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i>
                                </div>
                            </div>
                            <h3 class="product-title fs-sm mb-2"><a href="{{ route('knjiga') }}">Priča o Edgaru Sawtelleu</a></h3>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-sm me-2"><i class="ci-book text-muted me-1"></i><span class="fs-xs ms-1">Književnost</span></div>
                                <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">80.<small>00kn</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div>
                    <div class="card product-card-alt">
                        <div class="product-thumb">

                            <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="#"><i class="ci-eye"></i></a>
                                <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                            </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga2.jpg" alt="Product">
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="#">

                                        Lynds Gayle </a></div>
                                <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i>
                                </div>
                            </div>
                            <h3 class="product-title fs-sm mb-2"><a href="{{ route('knjiga') }}">Mozaik</a></h3>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-sm me-2"><i class="ci-book text-muted me-1"></i><span class="fs-xs ms-1">Književnost</span></div>
                                <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">80.<small>00kn</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div>
                    <div class="card product-card-alt">
                        <div class="product-thumb">

                            <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                            </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga3.jpg" alt="Product">
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="#">

                                        Gall Zlatko </a></div>
                                <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i>
                                </div>
                            </div>
                            <h3 class="product-title fs-sm mb-2"><a href="{{ route('knjiga') }}">Velika svjetska rock enciklopedija</a></h3>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-sm me-2"><i class="ci-book text-muted me-1"></i><span class="fs-xs ms-1">Glazba</span></div>
                                <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">100.<small>00kn</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div>
                    <div class="card product-card-alt">
                        <div class="product-thumb">

                            <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                            </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga4.jpg" alt="Product">
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="#">

                                        Camus Albert </a></div>
                                <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i>
                                </div>
                            </div>
                            <h3 class="product-title fs-sm mb-2"><a href="{{ route('knjiga') }}">Stranac</a></h3>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-sm me-2"><i class="ci-book text-muted me-1"></i><span class="fs-xs ms-1">Književnost</span></div>
                                <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">100.<small>00kn</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product-->
                <div>
                    <div class="card product-card-alt">
                        <div class="product-thumb">

                            <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                            </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga3.jpg" alt="Product">
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="#">

                                        Gall Zlatko </a></div>
                                <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i>
                                </div>
                            </div>
                            <h3 class="product-title fs-sm mb-2"><a href="{{ route('knjiga') }}">Velika svjetska rock enciklopedija</a></h3>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="fs-sm me-2"><i class="ci-book text-muted me-1"></i><span class="fs-xs ms-1">Glazba</span></div>
                                <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">100.<small>00kn</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
