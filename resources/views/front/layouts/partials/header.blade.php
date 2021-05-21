<!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
<header class="bg-dark shadow-sm navbar-sticky">
    <div class="navbar navbar-expand-lg navbar-dark">
        <div class="container"><a class="navbar-brand d-none d-sm-block flex-shrink-0 me-4 order-lg-1 p-0"" href="index.html"><img src="media/img/logobijeli.svg" width="180" alt="Antikvarijat Biblos"></a><a class="navbar-brand d-sm-none me-0 order-lg-1" href="index.html"><img src="media/img/logobijeli.svg" width="160" alt="Antikvarijat Biblos"></a>
            <!-- Toolbar-->
            <div class="navbar-toolbar d-flex align-items-center order-lg-3">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button><a class="navbar-tool d-none d-lg-flex" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#searchBox" role="button" aria-expanded="false" aria-controls="searchBox"><span class="navbar-tool-tooltip">Pretraži</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-search"></i></div></a><a class="navbar-tool ms-12" href="#signin-modal" data-bs-toggle="modal"><span class="navbar-tool-tooltip">Korisnički račun</span>
                    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user"></i></div></a>
                <div class="navbar-tool dropdown ms-1"><a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="food-delivery-cart.html"><span class="navbar-tool-label">1</span><i class="navbar-tool-icon ci-cart"></i></a>
                    <!-- Cart dropdown-->
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;">
                            <div style="height: 5rem;" data-simplebar data-simplebar-auto-hide="false">
                                <div class="widget-cart-item pb-2 border-bottom">
                                    <button class="btn-close text-danger" type="button" aria-label="Remove"><span aria-hidden="true">&times;</span></button>
                                    <div class="d-flex align-items-center"><a class="d-block" href="#"><img src="media/img/knjigakosarica.jpg" width="64" alt="Pizza"></a>
                                        <div class="ps-2">
                                            <h6 class="widget-product-title"><a href="#">Priča o Edgaru Sawtelleu</a></h6>
                                            <div class="widget-product-meta"><span class="text-accent me-2">80.<small>00kn</small></span><span class="text-muted">x 1</span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                                <div class="fs-sm me-2 py-2"><span class="text-muted">Ukupno:</span><span class="text-accent fs-base ms-1">80.<small>00kn</small></span></div><a class="btn btn-outline-secondary btn-sm" href="kosarica.html">Košarica<i class="ci-arrow-right ms-1 me-n1"></i></a>
                            </div><a class="btn btn-primary btn-sm d-block w-100" href="checkout.html"><i class="ci-card me-2 fs-base align-middle"></i>Dovrši kupnju</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse me-auto mx-auto order-lg-2" id="navbarCollapse">
                <!-- Search-->
                <div class="input-group d-lg-none my-3"><i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                    <input class="form-control rounded-start" type="text" placeholder="Pretražite po nazivu ili autoru">
                </div>
                <!-- Categories dropdown-->
                <ul class="navbar-nav  pe-lg-2 me-lg-2 ">
                    <li class="nav-item "><a class="nav-link " href="category.html" ><i class="ci-book d-none d-xl-inline-block  align-middle mt-n1 me-1"></i>Knjige</a>
                    <li class="nav-item "><a class="nav-link " href="category.html" ><i class="ci-book d-none d-xl-inline-block align-middle mt-n1 me-1"></i>Autori</a>
                    <li class="nav-item "><a class="nav-link " href="category.html" ><i class="ci-book d-none d-xl-inline-block align-middle mt-n1 me-1"></i>Nakladnici</a>
                    <li class="nav-item"><a class="nav-link " href="category.html"><i class="ci-map d-none d-xl-inline-block align-middle mt-n1 me-1"></i> Vedute & zemljovidi</a></li>
                    <li class="nav-item"><a class="nav-link " href="category.html"><i class="ci-discount d-none d-xl-inline-block align-middle mt-n1 me-1"></i> Sniženje </a></li>


                    </li>
                </ul>

            </div>
        </div>
    </div>
    <!-- Search collapse-->
    <div class="search-box collapse" id="searchBox">
        <div class="card pt-3 pb-3 border-0 rounded-0">
            <div class="container">
                <div class="input-group"><i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                    <input class="form-control rounded-start" type="text" placeholder="Pretražite po nazivu ili autoru">
                </div>
            </div>
        </div>
    </div>
</header>
