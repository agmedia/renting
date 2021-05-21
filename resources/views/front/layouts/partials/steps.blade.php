<div class="steps steps-light pt-2 pb-3 mb-5">
    <a class="step-item {{ request()->routeIs(['kosarica']) ? 'current' : '' }} {{ request()->routeIs(['kosarica', 'adresa-isporuke']) ? 'active' : '' }}" href="{{ route('kosarica') }}">
        <div class="step-progress"><span class="step-count">1</span></div>
        <div class="step-label"><i class="ci-cart"></i>Košarica</div>
    </a>
    <a class="step-item  {{ request()->routeIs(['adresa-isporuke']) ? 'current' : '' }} {{ request()->routeIs([ 'adresa-isporuke']) ? 'active' : '' }}" href="{{ route('adresa-isporuke') }}">
        <div class="step-progress"><span class="step-count">2</span></div>
        <div class="step-label"><i class="ci-user-circle"></i>Podaci</div>
    </a>
    <a class="step-item" href="#">
        <div class="step-progress"><span class="step-count">3</span></div>
        <div class="step-label"><i class="ci-package"></i>Dostava</div></a>
    <a class="step-item" href="#">
        <div class="step-progress"><span class="step-count">4</span></div>
        <div class="step-label"><i class="ci-card"></i>Plaćanje</div>
    </a>
    <a class="step-item" href="#">
        <div class="step-progress"><span class="step-count">5</span></div>
        <div class="step-label"><i class="ci-check-circle"></i>Pregledaj</div>
    </a>
</div>
