@extends('front.layouts.app')

@section('content')

    <!-- Order Details Modal-->
    <div class="modal fade" id="order-details">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order No - 34VB5540K83</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-0">
                    <!-- Item-->
                    <div class="d-sm-flex justify-content-between mb-4 pb-3 pb-sm-2 border-bottom">
                        <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto" href="shop-single-v1.html" style="width: 10rem;"><img src="img/shop/cart/01.jpg" alt="Product"></a>
                            <div class="ps-sm-4 pt-2">
                                <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">Women Colorblock Sneakers</a></h3>
                                <div class="fs-sm"><span class="text-muted me-2">Size:</span>8.5</div>
                                <div class="fs-sm"><span class="text-muted me-2">Color:</span>White &amp; Blue</div>
                                <div class="fs-lg text-accent pt-2">$154.<small>00</small></div>
                            </div>
                        </div>
                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                            <div class="text-muted mb-2">Quantity:</div>1
                        </div>
                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                            <div class="text-muted mb-2">Subtotal</div>$154.<small>00</small>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="d-sm-flex justify-content-between my-4 pb-3 pb-sm-2 border-bottom">
                        <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto" href="shop-single-v1.html" style="width: 10rem;"><img src="img/shop/cart/02.jpg" alt="Product"></a>
                            <div class="ps-sm-4 pt-2">
                                <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">TH Jeans City Backpack</a></h3>
                                <div class="fs-sm"><span class="text-muted me-2">Brand:</span>Tommy Hilfiger</div>
                                <div class="fs-sm"><span class="text-muted me-2">Color:</span>Khaki</div>
                                <div class="fs-lg text-accent pt-2">$79.<small>50</small></div>
                            </div>
                        </div>
                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                            <div class="text-muted mb-2">Quantity:</div>1
                        </div>
                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                            <div class="text-muted mb-2">Subtotal</div>$79.<small>50</small>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="d-sm-flex justify-content-between my-4 pb-3 pb-sm-2 border-bottom">
                        <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto" href="shop-single-v1.html" style="width: 10rem;"><img src="img/shop/cart/03.jpg" alt="Product"></a>
                            <div class="ps-sm-4 pt-2">
                                <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">3-Color Sun Stash Hat</a></h3>
                                <div class="fs-sm"><span class="text-muted me-2">Brand:</span>The North Face</div>
                                <div class="fs-sm"><span class="text-muted me-2">Color:</span>Pink / Beige / Dark blue</div>
                                <div class="fs-lg text-accent pt-2">$22.<small>50</small></div>
                            </div>
                        </div>
                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                            <div class="text-muted mb-2">Quantity:</div>1
                        </div>
                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                            <div class="text-muted mb-2">Subtotal</div>$22.<small>50</small>
                        </div>
                    </div>
                    <!-- Item-->
                    <div class="d-sm-flex justify-content-between my-4">
                        <div class="d-sm-flex text-center text-sm-start"><a class="d-inline-block flex-shrink-0 mx-auto" href="shop-single-v1.html" style="width: 10rem;"><img src="img/shop/cart/04.jpg" alt="Product"></a>
                            <div class="ps-sm-4 pt-2">
                                <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">Cotton Polo Regular Fit</a></h3>
                                <div class="fs-sm"><span class="text-muted me-2">Size:</span>42</div>
                                <div class="fs-sm"><span class="text-muted me-2">Color:</span>Light blue</div>
                                <div class="fs-lg text-accent pt-2">$9.<small>00</small></div>
                            </div>
                        </div>
                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                            <div class="text-muted mb-2">Quantity:</div>1
                        </div>
                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                            <div class="text-muted mb-2">Subtotal</div>$9.<small>00</small>
                        </div>
                    </div>
                </div>
                <!-- Footer-->
                <div class="modal-footer flex-wrap justify-content-between bg-secondary fs-md">
                    <div class="px-2 py-1"><span class="text-muted">Subtotal:&nbsp;</span><span>$265.<small>00</small></span></div>
                    <div class="px-2 py-1"><span class="text-muted">Shipping:&nbsp;</span><span>$22.<small>50</small></span></div>
                    <div class="px-2 py-1"><span class="text-muted">Tax:&nbsp;</span><span>$9.<small>50</small></span></div>
                    <div class="px-2 py-1"><span class="text-muted">Total:&nbsp;</span><span class="fs-lg">$297.<small>00</small></span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Title-->
    <div class="page-title-overlap bg-dark pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="/"><i class="ci-home"></i>Naslovnica</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Moje narudžbe</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-light mb-0">Moje narudžbe</h1>
            </div>
        </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- Sidebar-->
            <aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
                <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
                    <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
                        <div class="d-md-flex align-items-center">
                            <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;"><img class="rounded-circle" src="{{ asset('media/img/faviconbiblos.png') }}" alt="Susan Gardner"></div>
                            <div class="ps-md-3">
                                <h3 class="fs-base mb-0">Miroslav Škoro</h3><span class="text-accent fs-sm">mskoro@dp.hr</span>
                            </div>
                        </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Navigacija</a>
                    </div>
                    <div class="d-lg-block collapse" id="account-menu">
                        <div class="bg-secondary px-4 py-3">
                            <h3 class="fs-sm mb-0 text-muted">Moj korisnički račun</h3>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3 active" href="{{ route('moj-racun') }}"><i class="ci-user opacity-60 me-2"></i>Moji podaci</a></li>

                            <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('moje-narudzbe') }}"><i class="ci-bag opacity-60 me-2"></i>Narudžbe<span class="fs-sm text-muted ms-auto">1</span></a></li>

                            <li class="d-lg-none  mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('logout') }}"><i class="ci-sign-out opacity-60 me-2"></i>Odjava</a></li>
                        </ul>
                    </div>
                </div>
            </aside>
            <!-- Content  -->
            <section class="col-lg-8">
                <!-- Toolbar-->
                <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
                    <h6 class="fs-base text-light mb-0">Pogledajte povijest svoji narudžbi:</h6><a class="btn btn-primary btn-sm" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Odjava</a>
                </div>
                <!-- Orders list-->
                <div class="table-responsive fs-md mb-4">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date Purchased</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal">34VB5540K83</a></td>
                            <td class="py-3">May 21, 2019</td>
                            <td class="py-3"><span class="badge bg-info m-0">In Progress</span></td>
                            <td class="py-3">$358.75</td>
                        </tr>
                        <tr>
                            <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal">78A643CD409</a></td>
                            <td class="py-3">December 09, 2018</td>
                            <td class="py-3"><span class="badge bg-danger m-0">Canceled</span></td>
                            <td class="py-3"><span>$760.50</span></td>
                        </tr>
                        <tr>
                            <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal">112P45A90V2</a></td>
                            <td class="py-3">October 15, 2018</td>
                            <td class="py-3"><span class="badge bg-warning m-0">Delayed</span></td>
                            <td class="py-3">$1,264.00</td>
                        </tr>
                        <tr>
                            <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal">28BA67U0981</a></td>
                            <td class="py-3">July 19, 2018</td>
                            <td class="py-3"><span class="badge bg-success m-0">Delivered</span></td>
                            <td class="py-3">$198.35</td>
                        </tr>
                        <tr>
                            <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal">502TR872W2</a></td>
                            <td class="py-3">April 04, 2018</td>
                            <td class="py-3"><span class="badge bg-success m-0">Delivered</span></td>
                            <td class="py-3">$2,133.90</td>
                        </tr>
                        <tr>
                            <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal">47H76G09F33</a></td>
                            <td class="py-3">March 30, 2018</td>
                            <td class="py-3"><span class="badge bg-success m-0">Delivered</span></td>
                            <td class="py-3">$86.40</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination-->
                <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#"><i class="ci-arrow-left me-2"></i>Prev</a></li>
                    </ul>
                    <ul class="pagination">
                        <li class="page-item d-sm-none"><span class="page-link page-link-static">1 / 5</span></li>
                        <li class="page-item active d-none d-sm-block" aria-current="page"><span class="page-link">1<span class="visually-hidden">(current)</span></span></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">2</a></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">3</a></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">4</a></li>
                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">5</a></li>
                    </ul>
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#" aria-label="Next">Next<i class="ci-arrow-right ms-2"></i></a></li>
                    </ul>
                </nav>
            </section>
        </div>
    </div>

@endsection
