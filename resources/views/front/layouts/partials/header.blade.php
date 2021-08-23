<header class="bg-dark shadow-sm navbar-sticky">
    <div class="navbar navbar-expand-lg navbar-dark">
        <div class="container"><a class="navbar-brand d-none d-sm-block flex-shrink-0 me-4 order-lg-1 p-0" href="{{ route('index') }}"><img src="{{ asset('media/img/logobijeli.svg') }}" width="180" alt="Antikvarijat Biblos"></a><a class="navbar-brand d-sm-none me-0 order-lg-1 p-0" href="{{ route('index') }}"><img src="{{ asset('media/img/logobijeli.svg') }}" width="160" alt="Antikvarijat Biblos"></a>
            <!-- Toolbar-->
            <div class="navbar-toolbar d-flex align-items-center order-lg-3">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button>
                <a class="navbar-tool d-none d-lg-flex" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#searchBox" role="button" aria-expanded="false" aria-controls="searchBox"><span class="navbar-tool-tooltip">Pretraži</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-search"></i></div>
                </a>
                <a class="navbar-tool ms-12" href="{{ route('loginx') }}" ><span class="navbar-tool-tooltip">Korisnički račun</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user"></i></div>
                </a>

                <cart-nav-icon carturl="{{ route('kosarica') }}" checkouturl="{{ route('naplata') }}"></cart-nav-icon>

            </div>
            <div class="collapse navbar-collapse me-auto mx-auto order-lg-2" id="navbarCollapse">
                <div class="input-group d-lg-none my-3"><i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                    <input class="form-control rounded-start" type="text" placeholder="Pretražite po nazivu ili autoru">
                </div>
                <ul class="navbar-nav pe-lg-2 me-lg-2">
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route', ['group' => 'knjige']) }}"><i class="ci-book d-none d-xl-inline-block align-middle mt-n1 me-1"></i>Knjige</a>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route.author') }}"><i class="ci-user-circle d-none d-xl-inline-block align-middle mt-n1 me-1"></i>Autori</a>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route.publisher') }}"><i class="ci-bookmark d-none d-xl-inline-block align-middle mt-n1 me-1"></i>Nakladnici</a>
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog.route', ['group' => 'vedute-&-zemljovidi']) }}"><i class="ci-map d-none d-xl-inline-block align-middle mt-n1 me-1"></i>Vedute & zemljovidi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kategorija') }}"><i class="ci-discount d-none d-xl-inline-block align-middle mt-n1 me-1"></i>Sniženje</a></li>
                    <li class="nav-item d-inloine-block d-lg-none"><a class="nav-link" href="o-nama">O nama</a></li>
                    <li class="nav-item d-inloine-block d-lg-none"><a class="nav-link" href="kontakt">Kontakt</a></li>
                </ul>
                <div class="offcanvas-cap d-block d-lg-none px-grid-gutter pt-4 pb-3 mb-2">
                    <div class="d-flex mb-3"><i class="ci-phone h4 mb-0 fw-normal text-primary mt-1 me-1"></i>
                        <div class="ps-2">
                            <div class="text-white fs-sm">Telefon</div><a class="nav-link-style text-white fs-md" href="tel:+385148165740">+385 1 48 16 574</a>
                        </div>
                    </div>
                    <div class="d-flex mb-3"><i class="ci-mail h5 mb-0 fw-normal text-primary mt-1 me-1"></i>
                        <div class="ps-2">
                            <div class="text-white fs-sm">Email</div><a class="nav-link-style text-white fs-md" href="mailto:info@antikvarijat-biblos.hr">info@antikvarijat-biblos.hr</a>
                        </div>
                    </div>
                    <h6 class="pt-2 pb-1 text-white">Pratite nas</h6><a class="btn-social bs-light bs-instagram me-2 mb-2" href="#"><i class="ci-instagram"></i></a><a class="btn-social bs-light bs-facebook me-2 mb-2" href="#"><i class="ci-facebook"></i></a>
                </div>

            </div>
        </div>
    </div>
    <!-- Search collapse-->
    <div class="search-box collapse" id="searchBox">
        <div class="card pt-3 pb-3 border-0 rounded-0">
            <div class="container">
                <div class="input-group"><i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                    <input class="form-control rounded-start" type="text" id="search-input" placeholder="Pretražite po nazivu ili autoru">
                </div>
            </div>
            <div class="row justify-content-center" style="z-index: 999;" id="search-view-panel">

            </div>
        </div>
    </div>
</header>
