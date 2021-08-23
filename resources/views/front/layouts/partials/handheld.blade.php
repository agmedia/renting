<!-- Toolbar for handheld devices (Marketplace)-->
<div class="handheld-toolbar">
    <div class="d-table table-layout-fixed w-100">



            @if (Request::is('knjige/*' ) || Request::is('knjige' ))

            @if(isset($prod) && $prod)

            @else

            <a class="d-table-cell handheld-toolbar-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#shop-sidebar"><span class="handheld-toolbar-icon"><i class="ci-filter-alt"></i></span><span class="handheld-toolbar-label">Filtriraj</span></a>
            @endif
        @endif


        <a class="d-table-cell handheld-toolbar-item" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" onclick="window.scrollTo(0, 0)"><span class="handheld-toolbar-icon"><i class="ci-menu"></i></span><span class="handheld-toolbar-label">Menu</span></a>
        <a class="d-table-cell handheld-toolbar-item" href="marketplace-cart.html"><span class="handheld-toolbar-icon"><i class="ci-cart"></i><span class="badge bg-primary rounded-pill ms-1">1</span></span><span class="handheld-toolbar-label">80.00kn</span></a>
    </div>
</div>
