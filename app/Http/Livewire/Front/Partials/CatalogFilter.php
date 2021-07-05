<?php

namespace App\Http\Livewire\Front\Partials;

use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\Publisher;
use Livewire\Component;

class CatalogFilter extends Component
{

    public $group;

    public $category = null;

    public $subcategory = null;

    public $categories;

    public $authors;
    public $author;

    public $selectedAuthor;

    public $publishers;
    public $publisher;

    protected $queryString = ['author' => ['except' => false], 'publisher'];


    public function mount()
    {
        if ( ! $this->category && ! $this->subcategory) {
            $category = new Category();

            $this->categories = $category->topList($this->group)->with('subcategories')->get();

            $ids = collect();

            foreach ($this->categories as $item) {
                $ids = $ids->push($item->products()->pluck('id'));

                if ($item->subcategories) {
                    foreach ($item->subcategories as $subcategory) {
                        $ids = $ids->push($subcategory->products()->pluck('id'));
                    }
                }
            }

            $ids = $ids->unique()->flatten();

            $author_ids = Product::whereIn('id', $ids)->pluck('author_id')->unique();
            $publisher_ids = Product::whereIn('id', $ids)->pluck('publisher_id')->unique();

            $this->authors = Author::whereIn('id', $author_ids)->get();
            $this->publishers = Publisher::whereIn('id', $publisher_ids)->get();
        }

    }


    public function changeSelected($slug)
    {
        dd($slug);
        return request()->query->set('author', $slug);
    }


    public function updatingSelectedAuthor($slug)
    {
        //$this->queryString = ['author' => $slug];
        return request()->fullUrlWithQuery(['author' => $slug]);
    }


    public function render()
    {
        return view('livewire.front.partials.catalog-filter');
    }
}
