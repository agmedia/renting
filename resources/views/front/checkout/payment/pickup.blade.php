<form name="pay" action="{{ route('checkout') }}" method="GET">
    <input type="hidden" name="provjera" value="{{ $data['order_id'] }}">
    <div class="d-flex">
    <div class="w-50 pe-3">
        <a class="btn btn-secondary d-block w-100" href="{{ route('naplata') }}"><i class="ci-arrow-left mt-sm-0 me-1"></i><span class="d-none d-sm-inline">Povratak na plaćanje</span><span class="d-inline d-sm-none">Povratak</span></a>
    </div>
    <div class="w-50 ps-2">
        <button class="btn btn-primary d-block w-100" type="submit"><span class="d-none d-sm-inline">Dovršite narudžbu</span><span class="d-inline d-sm-none">Nastavi</span><i class="ci-arrow-right mt-sm-0 ms-1"></i></button>
    </div>
    </div>
</form>