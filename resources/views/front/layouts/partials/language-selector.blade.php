
<div class="language">
    <div class="dropdown hover-dropdown">
        <button class="dropdown-toggle text-primary" type="button" data-bs-toggle="dropdown">{{ \Illuminate\Support\Str::upper(current_locale()) }}</button>
        <ul class="dropdown-menu">
            @if (isset($langs))
                @foreach ($langs as $lang)
                    <li>
                        <a class="dropdown-item @if (current_locale() == $lang['code']) active @endif" href="{{ LaravelLocalization::getLocalizedURL($lang['code'], $lang['slug'], [], true) }}">{{ $lang['title'] }}</a>
                    </li>
                @endforeach
            @else
                @foreach (ag_lang() as $lang)
                    <li>
                        <a class="dropdown-item @if (current_locale() == $lang->code) active @endif" href="{{ LaravelLocalization::getLocalizedURL($lang->code, null, [], true) }}">{{ $lang->title->{LaravelLocalization::getCurrentLocale()} }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>