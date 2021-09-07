@extends('errors.container')

@section ( 'title', '404 Error')

@section('content')
    <section id="page-title">
        <div class="container clearfix">
            <h1>Stranica nije pronađena</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Naslovna</a></li>
                <li class="breadcrumb-item active" aria-current="page">404</li>
            </ol>
        </div>
    </section>

    <section id="content" style="margin-bottom: 0px;">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="col_half nobottommargin">
                    <div class="error404 center">404</div>
                </div>
                <div class="col_half nobottommargin col_last">
                    <div class="heading-block nobottomborder">
                        <h4>Ooopps! Stranica koju ste tražili nije pronađena.</h4>
                        <span>Probajte pretražiti viličare ili kliknite ne linkove ispod.</span>
                    </div>
                    <form action="{{ route('pretrazi') }}" method="get" class="nobottommargin">
                        <div class="input-group ">
                            <input type="text" class="form-control" name="q" placeholder="Pretraži stranice">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit">Pretraži</button>
                            </div>
                        </div>
                    </form>
                    <div class="row col-12 topmargin nobottommargin">
                        <a href="{{ route('index') }}" class="btn btn-outline-dark">Idi na početnu</a>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-dark leftmargin-sm">Idi nazad</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
