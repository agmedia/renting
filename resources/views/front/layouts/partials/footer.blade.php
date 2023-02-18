<!-- Footer-->
<footer class="full-row bg-gray p-0">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="divider py-50">
                    <div class="row g-4">
                        <div class="col-lg-4 d-none d-sm-block">
                            <div class="footer-widget">
                                <div class="footer-logo mb-4">
                                     <a  href="index.html"><img class="logo-bottom" src="assets/images/logo.svg" alt=""></a>
                                </div>
                                <p class="pb-20">{{ __('front/common.footer_text') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12">
                            <div class="row row-cols-md-3 row-cols-2">
                                <div class="col ">
                                    <div class="footer-widget footer-nav">
                                        <h4 class="widget-title text-secondary double-down-line-left position-relative">{{ __('front/common.legal') }}</h4>
                                        <ul>
                                            @foreach($pages as $page)
                                                <li>
                                                    <a href="{{ route('page', ['page' => $page->translation->slug]) }}">{{ $page->translation->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="footer-widget footer-nav">
                                        <h4 class="widget-title text-secondary double-down-line-left position-relative">{{ __('front/common.support') }}</h4>
                                        <ul>
                                            <li> <a href="{{ route('faq') }}">{{ __('front/common.faq') }}</a> </li>
                                            <li> <a href="{{ route('kontakt') }}">{{ __('front/common.contact') }}</a> </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="col d-none d-sm-block">
                                    <div class="footer-widget">
                                        <h4 class="widget-title text-secondary double-down-line-left position-relative">{{ __('front/common.contact') }}</h4>
                                        <ul>
                                            <li>selfcheckins@gmail.com</li>
                                        </ul>
                                    </div>
                                    <div class="footer-widget media-widget mt-3 text-secondary hover-text-primary">
                                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#"><i class="fab fa-linkedin-in"></i></a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="payments-card text-center text-sm-left" >
                                <img class="ccard"  src="assets/images/cards/CorvusPay.svg">
                            </div>
                            <div class="payments-card text-center text-sm-left" >
                                <img class="ccard" src="assets/images/cards/visa.svg">
                                <img class="ccard"  src="assets/images/cards/maestro.svg">
                                <img class="ccard"  src="assets/images/cards/mastercard.svg">
                                <img class="ccard"  src="assets/images/cards/diners.svg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright Start -->
    <div class="copyright">
        <div class="container">
            <div class="row row-cols-sm-2 row-cols-1">
                <div class="col"> <span>{{ __('front/common.copy_text') }}</span> </div>
                <div class="col">
                    <ul class="line-menu text-ordinary float-end">
                        <li>Web by: <a href="https://www.agmedia.hr">AG media</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->
</footer>
