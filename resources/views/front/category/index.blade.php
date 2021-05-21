@extends('front.layouts.app')

@section('content')

    <!-- Page Title-->
    <div class="page-title-overlap bg-dark pt-4" style="background-image: url('media/img/indexslika.jpg');-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Naslovnica</a></li>

                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Knjige</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-light mb-0">Knjige</h1>
            </div>
        </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- Sidebar-->
            <aside class="col-lg-4">
                <!-- Sidebar-->
                <div class="offcanvas offcanvas-collapse bg-white w-100 rounded-3 shadow-lg py-1" id="shop-sidebar" style="max-width: 22rem;">
                    <div class="offcanvas-cap align-items-center shadow-sm">
                        <h2 class="h5 mb-0">Filtriraj</h2>
                        <button class="btn-close ms-auto" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body py-grid-gutter px-lg-grid-gutter">
                        <!-- Categories-->
                        <div class="widget widget-categories mb-4 pb-4 border-bottom">
                            <h3 class="widget-title">Kategorije</h3>
                            <div class="accordion mt-n1" id="shop-categories">
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Alternativa <span class="badge bg-secondary ms-2 position-absolute  end-0">318</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Antropozofija <span class="badge bg-secondary ms-2 position-absolute  end-0">58</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Arheologija <span class="badge bg-secondary ms-2 position-absolute  end-0">55</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Ekonomija <span class="badge bg-secondary ms-2 position-absolute  end-0">166</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Enciklopedija <span class="badge bg-secondary ms-2 position-absolute  end-0">71</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Enologija <span class="badge bg-secondary ms-2 position-absolute  end-0">29</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Etnologija i antropologija <span class="badge bg-secondary ms-2 position-absolute  end-0">115</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Filozofija <span class="badge bg-secondary ms-2 position-absolute  end-0">1318</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Geografija <span class="badge bg-secondary ms-2 position-absolute  end-0">261</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Glazba <span class="badge bg-secondary ms-2 position-absolute  end-0">202</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Gramatika i pravopis <span class="badge bg-secondary ms-2 position-absolute  end-0">76</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >HRVATSKA RARA <span class="badge bg-secondary ms-2 position-absolute  end-0">96</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Kazalište i film <span class="badge bg-secondary ms-2 position-absolute  end-0">134</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Književnost <span class="badge bg-secondary ms-2 position-absolute  end-0">318</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Kuharstvo <span class="badge bg-secondary ms-2 position-absolute  end-0">318</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item border-bottom">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Lingvistika <span class="badge bg-secondary ms-2 position-absolute  end-0">318</span></a></h3>
                                </div>
                                <!-- menu item-->
                                <div class="accordion-item ">
                                    <h3 class="accordion-header"><a class="accordion-button py-2 none collapsed" href="#shoes" role="link" >Matematika i fizika <span class="badge bg-secondary ms-2 position-absolute  end-0">65</span></a></h3>
                                </div>



                            </div>
                        </div>

                        <!-- Filter by Brand-->
                        <div class="widget widget-filter mb-4 pb-4 border-bottom">
                            <h3 class="widget-title">Autor</h3>
                            <div class="input-group input-group-sm mb-2">
                                <input class="widget-filter-search form-control rounded-end pe-5" type="text" placeholder="Pretraži autora"><i class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                            </div>
                            <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 11rem;" data-simplebar data-simplebar-auto-hide="false">
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="adidas">
                                        <label class="form-check-label widget-filter-item-text" for="adidas">Aab Eva Maria</label>
                                    </div><span class="fs-xs text-muted">425</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ataylor">
                                        <label class="form-check-label widget-filter-item-text" for="ataylor">Abadžić Nijaz</label>
                                    </div><span class="fs-xs text-muted">15</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="armani">
                                        <label class="form-check-label widget-filter-item-text" for="armani">Abellan Jose Luis</label>
                                    </div><span class="fs-xs text-muted">18</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="banana">
                                        <label class="form-check-label widget-filter-item-text" for="banana">Balaš Bela</label>
                                    </div><span class="fs-xs text-muted">103</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="bilabong">
                                        <label class="form-check-label widget-filter-item-text" for="bilabong">Bakić Jovo</label>
                                    </div><span class="fs-xs text-muted">27</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="birkenstock">
                                        <label class="form-check-label widget-filter-item-text" for="birkenstock">Ballard James Graham</label>
                                    </div><span class="fs-xs text-muted">10</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="klein">
                                        <label class="form-check-label widget-filter-item-text" for="klein">Barber Edwin</label>
                                    </div><span class="fs-xs text-muted">365</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="columbia">
                                        <label class="form-check-label widget-filter-item-text" for="columbia">Bašić Mario</label>
                                    </div><span class="fs-xs text-muted">508</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="converse">
                                        <label class="form-check-label widget-filter-item-text" for="converse">Bastide Roger</label>
                                    </div><span class="fs-xs text-muted">176</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="dockers">
                                        <label class="form-check-label widget-filter-item-text" for="dockers">Bedford Neal</label>
                                    </div><span class="fs-xs text-muted">54</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="fruit">
                                        <label class="form-check-label widget-filter-item-text" for="fruit">Bezić Filipović Branka</label>
                                    </div><span class="fs-xs text-muted">739</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="hanes">
                                        <label class="form-check-label widget-filter-item-text" for="hanes">Carić Juraj</label>
                                    </div><span class="fs-xs text-muted">92</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="choo">
                                        <label class="form-check-label widget-filter-item-text" for="choo">Čanak Milan</label>
                                    </div><span class="fs-xs text-muted">17</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="levis">
                                        <label class="form-check-label widget-filter-item-text" for="levis">Davidson Donald</label>
                                    </div><span class="fs-xs text-muted">361</span>
                                </li>

                            </ul>
                        </div>



                        <!-- Filter by NAkladnik-->
                        <div class="widget widget-filter mb-4 pb-4 border-bottom">
                            <h3 class="widget-title">Nakladnici</h3>
                            <div class="input-group input-group-sm mb-2">
                                <input class="widget-filter-search form-control rounded-end pe-5" type="text" placeholder="Pretraži nakladnika"><i class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                            </div>
                            <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 11rem;" data-simplebar data-simplebar-auto-hide="false">
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="adidas">
                                        <label class="form-check-label widget-filter-item-text" for="adidas">Algoritam</label>
                                    </div><span class="fs-xs text-muted">425</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ataylor">
                                        <label class="form-check-label widget-filter-item-text" for="ataylor">Algoritam</label>
                                    </div><span class="fs-xs text-muted">15</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="armani">
                                        <label class="form-check-label widget-filter-item-text" for="armani">Algoritam</label>
                                    </div><span class="fs-xs text-muted">18</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="banana">
                                        <label class="form-check-label widget-filter-item-text" for="banana">Algoritam</label>
                                    </div><span class="fs-xs text-muted">103</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="bilabong">
                                        <label class="form-check-label widget-filter-item-text" for="bilabong">Algoritam</label>
                                    </div><span class="fs-xs text-muted">27</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="birkenstock">
                                        <label class="form-check-label widget-filter-item-text" for="birkenstock">Algoritam</label>
                                    </div><span class="fs-xs text-muted">10</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="klein">
                                        <label class="form-check-label widget-filter-item-text" for="klein">Algoritam</label>
                                    </div><span class="fs-xs text-muted">365</span>
                                </li>
                                <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="columbia">
                                        <label class="form-check-label widget-filter-item-text" for="columbia">Algoritam</label>
                                    </div><span class="fs-xs text-muted">508</span>
                                </li>


                            </ul>
                        </div>


                        <!-- Price range-->
                        <div class="widget mb-4 pb-4 border-bottom">
                            <h3 class="widget-title">Godina izdanja</h3>
                            <div class="range-slider" data-start-min="1500" data-start-max="2020" data-min="1500" data-max="2021" data-step="1">
                                <div class="range-slider-ui"></div>
                                <div class="d-flex pb-1">
                                    <div class="w-50 pe-2 me-2">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control range-slider-value-min" type="text">
                                            <span class="input-group-text">g</span>
                                        </div>
                                    </div>
                                    <div class="w-50 ps-2">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control range-slider-value-max" type="text">
                                            <span class="input-group-text">g</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </aside>
            <!-- Content  -->
            <section class="col-lg-8">
                <!-- Toolbar-->
                <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pb-4 pb-sm-5">
                    <div class="d-flex flex-wrap">
                        <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4 pb-3">
                            <label class="text-light opacity-75 text-nowrap fs-sm me-2 d-none d-sm-block" for="sorting">Sortiraj:</label>
                            <select class="form-select" id="sorting">
                                <option>Najnovije</option>
                                <option>Najmanja cijena</option>
                                <option>Najveća cijena</option>
                                <option>A - Ž </option>
                                <option>Ž - A </option>
                            </select><span class="fs-sm text-light opacity-75 text-nowrap ms-2 d-none d-md-block">od 19580 artikala</span>
                        </div>
                    </div>
                    <div class="d-flex pb-3"><a class="nav-link-style nav-link-light me-3" href="#"><i class="ci-arrow-left"></i></a><span class="fs-md text-light">1 / 324</span><a class="nav-link-style nav-link-light ms-3" href="#"><i class="ci-arrow-right"></i></a></div>
                </div>
                <!-- Products grid-->
                <div class="row mx-n2">
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga2.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga3.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <button class="btn-wishlist btn-sm" type="button"><i class="ci-heart"></i></button>
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga4.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga2.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga3.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <button class="btn-wishlist btn-sm" type="button"><i class="ci-heart"></i></button>
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga4.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga2.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga3.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <button class="btn-wishlist btn-sm" type="button"><i class="ci-heart"></i></button>
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga4.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga2.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga3.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <button class="btn-wishlist btn-sm" type="button"><i class="ci-heart"></i></button>
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga4.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">
                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>
                    <!-- Product-->
                    <div class="col-md-4 col-sm-6 px-2 mb-4">
                        <div class="card product-card-alt">
                            <div class="product-thumb">

                                <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{ route('knjiga') }}"><i class="ci-eye"></i></a>
                                    <button class="btn btn-light btn-icon btn-shadow fs-base mx-2" type="button"><i class="ci-cart"></i></button>
                                </div><a class="product-thumb-overlay" href="{{ route('knjiga') }}"></a><img src="media/img/knjiga2.jpg" alt="Product">
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                                    <div class="text-muted fs-xs me-1"><a class="product-meta fw-medium" href="{{ route('knjiga') }}">

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
                        <hr class="d-sm-none">
                    </div>


                </div>


                <hr class="my-3">
                <!-- Pagination-->
                <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#"><i class="ci-arrow-left me-2"></i>Prethodna</a></li>
                    </ul>
                    <ul class="pagination">
                        <li class="page-item d-sm-none"><span class="page-link page-link-static">1 / 5</span></li>
                        <li class="page-item active d-none d-sm-block" aria-current="page"><span class="page-link">1<span class="visually-hidden">(trenutno)</span></span></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">2</a></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">3</a></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">4</a></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">5</a></li>
                    </ul>
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#" aria-label="Next">Sljedeća<i class="ci-arrow-right ms-2"></i></a></li>
                    </ul>
                </nav>
            </section>
        </div>
    </div>




@endsection
