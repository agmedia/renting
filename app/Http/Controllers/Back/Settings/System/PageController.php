<?php

namespace App\Http\Controllers\Back\Settings\System;

use App\Http\Controllers\Controller;
use App\Models\Back\Settings\System\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search') && ! empty($request->search)) {
            $pages = Page::whereHas('translation', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })->paginate(12);
        } else {
            $pages = Page::paginate(12);
        }

        return view('back.settings.system.pages.index', compact('pages'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Page::groups()->pluck('group');

        return view('back.settings.system.pages.edit', compact('groups'));
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
        //dd($request);
        $page = new Page();

        $stored = $page->validateRequest($request)->create();

        if ($stored) {
            return redirect()->route('pages.edit', ['page' => $stored])->with(['success' => 'Page was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the page.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Author $author
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $groups = $page->groups()->pluck('group');

        return view('back.settings.system.pages.edit', compact('page', 'groups'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Author                   $author
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $updated = $page->validateRequest($request)->edit();

        if ($updated) {
            $page->resolveImage($updated);

            $this->flush($updated);

            return redirect()->route('pages.edit', ['page' => $updated])->with(['success' => 'Page was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the page.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Page $page)
    {
        $destroyed = Page::destroy($page->id);

        if ($destroyed) {
            return redirect()->route('pages')->with(['success' => 'Page was succesfully deleted!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error deleting the page.']);
    }


    /**
     * @param Page $page
     */
    private function flush(Page $page): void
    {
        Cache::forget('page.' . $page->id);
        Cache::forget('page.' . $page->slug);
    }
}
