
@extends('front.layouts.app')

@section('content')


    <div class="container pb-5 mb-sm-4">
        <div class="pt-5">
            <div class="card py-3 mt-sm-3">
                <div class="card-body text-center">
                    <h2 class="h4 pb-3">Vaša narudžba je uspješno dovršena!</h2>
                    <p class="fs-sm mb-2">Vaša je narudžba poslana i bit će obrađena u najkraćem mogućem roku. </p>

                    <p class="fs-sm">Uskoro ćete primiti e-poštu s potvrdom narudžbe. </p>

                    <a class="btn btn-secondary mt-3 me-3" href="{{ route('index') }}">Nastavite pregled stranice</a>

                </div>
            </div>
        </div>
    </div>

@endsection
