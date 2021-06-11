<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search') && ! empty($request->search)) {
            $publishers = Publisher::where('title', 'like', '%' . $request->search . '%')->paginate(1);
        } else {
            $publishers = Publisher::paginate(1);
        }

        return view('back.catalog.publisher.index', compact('publishers'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.catalog.publisher.edit');
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
        $publisher = new Publisher();

        $stored = $publisher->validateRequest($request)->create();

        if ($stored) {
            $publisher->resolveImage($stored);

            return redirect()->route('publishers.edit', ['publisher' => $stored])->with(['success' => 'Publisher was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the publisher.']);
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Publisher $publisher
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        return view('back.catalog.publisher.edit', compact('publisher'));
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Publisher                $publisher
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        $updated = $publisher->validateRequest($request)->edit();

        if ($updated) {
            $publisher->resolveImage($updated);

            return redirect()->route('publishers.edit', ['publisher' => $updated])->with(['success' => 'Publisher was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the publisher.']);
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Publisher $publisher)
    {
        $destroyed = Publisher::destroy($publisher->id);

        if ($destroyed) {
            return redirect()->route('publishers')->with(['success' => 'Publisher was succesfully deleted!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error deleting the publisher.']);
    }
}
