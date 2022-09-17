<?php

namespace App\Http\Controllers\Back\Settings;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Product\Product;
use App\Models\Back\Marketing\Action\Action;
use App\Models\Back\Settings\Options\Option;
use App\Models\Back\Settings\Settings;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = Option::paginate(12);

        //dd($options->first()->title);

        return view('back.settings.options.index', compact('options'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Settings::get('action', 'group_list');

        return view('back.settings.options.edit', compact('groups'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option = new Option();

        $stored = $option->validateRequest($request)->create();

        if ($stored) {
            return redirect()->route('options.edit', ['option' => $stored])->with(['success' => 'Option was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the option.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Author $author
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        $groups = Settings::get('action', 'group_list');

        return view('back.settings.options.edit', compact('option', 'groups'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Author                   $author
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        $updated = $option->validateRequest($request)->edit();

        if ($updated) {
            return redirect()->route('options.edit', ['option' => $updated])->with(['success' => 'Option was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the option.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Option $option)
    {
        $destroyed = Option::destroy($option->id);

        if ($destroyed) {
            return redirect()->route('options')->with(['success' => 'OPcija je uspjšeno izbrisana!']);
        }

        return redirect()->back()->with(['error' => 'Oops..! Greška prilikom brisanja.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyApi(Request $request)
    {
        if ($request->has('id')) {
            $option = Option::find($request->input('id'));
            $destroyed = $option->delete();

            if ($destroyed) {
                return response()->json(['success' => 200]);
            }
        }

        return response()->json(['error' => 300]);
    }
}
