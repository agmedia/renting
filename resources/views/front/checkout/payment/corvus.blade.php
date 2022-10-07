<form name="pay" class="w-100" action="{{ $data['action'] }}" method="POST">

   <input id="target" name="target" value="_top" type="hidden"/>
    <input id="mode" name="mode" value="form" type="hidden"/>
    <input type="hidden" name="store_id" value="{{ $data['shop_id'] }}">
    <input id="require_complete"  name="require_complete" value="true" type="hidden"/>
    <input type="hidden" name="order_number" value="{{ $data['order_id'] }}">
    <input type="hidden" name="amount" value="{{ $data['total'] }}}">
    <input type="hidden" name="hash" value="{{ $data['lastname'] }}">
    <input id="currency" name="currency" value="{{ $data['currency'] }}" type="hidden"/>
    <input id="cart"  name="cart" value="Web shop kupnja - {{ $data['order_id'] }}" type="hidden"/>
    <input id="language" name="language" value="{{ $data['lang'] }}" type="hidden"/>
    <input type="hidden" name="cardholder_name" value="{{ $data['firstname'] }}">
    <input type="hidden" name="cardholder_surname" value="{{ $data['lastname'] }}">
    <input type="hidden" name="cardholder_phone" value="{{ $data['telephone'] }}">
    <input type="hidden" name="cardholder_email" value="{{ $data['email'] }}">
    <input type="hidden" name="payment_all" value="{{ $data['number_of_installments'] }}">





    <div class="d-flex mt-3">
        <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="{{ route('checkout') }}"><i class="ci-arrow-left  me-1"></i><span class="d-none d-sm-inline">Povratak na plaćanje</span><span class="d-inline d-sm-none">Povratak</span></a></div>
        <div class="w-50 ps-2"><button class="btn btn-primary d-block w-100" type="submit"><span class="d-none d-sm-inline">Dovršite narudžbu</span><span class="d-inline d-sm-none">Dovrši kupnju</span><i class="ci-arrow-right ms-1"></i></button></div>
    </div>
    <div class="clearfix"></div>
</form>
