<?php

namespace App\Actions\Fortify;

use App\Http\Controllers\Controller;
use Bouncer;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;


    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }


    /**
     * @param Request       $request
     * @param CreateNewUser $creator
     *
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, CreateNewUser $creator): RedirectResponse
    {
        $user = $creator->register($request->all());

        $this->guard->login($user);

        return redirect()->route('index');
    }

}
