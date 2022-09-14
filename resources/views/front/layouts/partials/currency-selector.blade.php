<div class="currency">
    <div class="dropdown hover-dropdown">
        <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">{{ \Illuminate\Support\Str::upper(ag_currencies(true)->code) }}</button>
        <ul class="dropdown-menu">
            @foreach (ag_currencies() as $currency)
                <li>
                    <a class="dropdown-item @if (current_locale() == $currency->code) active @endif" href="{{ route('set.currency', ['currency' => $currency->code]) }}">{{ $currency->title->{LaravelLocalization::getCurrentLocale()} }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>