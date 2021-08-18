<?php

namespace App\Http\Livewire\Front\Partials;

use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\Publisher;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CatalogFilter extends Component
{

    public $group = null;

    public $category = null;

    public $subcategory = null;

    public $categories = null;

    public $authors;
    public $author;

    public $selectedAuthor = null;
    public $selectedAuthors = null;

    public $publishers;
    public $publisher;

    protected $queryString = ['author'];


    public function mount()
    {
        Log::info($this->group);
        if ( ! $this->category && ! $this->subcategory) {
            $category = new Category();
            $this->categories = $category->topList($this->group)->with('subcategories')->get();

            $ids = collect();

            foreach ($this->categories as $item) {
                $ids = $ids->push($item->products()->active()->pluck('id'));

                if ($item->subcategories) {
                    foreach ($item->subcategories as $subcategory) {
                        $ids = $ids->push($subcategory->products()->active()->pluck('id'));
                    }
                }
            }

            $ids = $ids->unique()->flatten();
        }


        if ($this->category && ! $this->subcategory) {
            $item = $this->category->topList($this->group)->where('id', $this->category->id)->with('subcategories')->first();

            if ($item && $item->subcategories->count()) {
                $this->categories = $item->subcategories;
            }

            $ids = collect();

            $ids = $ids->push($item->products()->active()->pluck('id'));

            if ($item->subcategories) {
                foreach ($item->subcategories as $subcategory) {
                    $ids = $ids->push($subcategory->products()->active()->pluck('id'));
                }
            }

            //dump($ids);

            $ids = $ids->unique()->flatten();
        }


        if ($this->category && $this->subcategory) {
            $item = $this->subcategory->topList($this->group)->first();

            $ids = collect();

            $ids = $ids->push($item->products()->active()->pluck('id'));

            if ($item->subcategories) {
                foreach ($item->subcategories as $subcategory) {
                    $ids = $ids->push($subcategory->products()->active()->pluck('id'));
                }
            }

            //dump($ids);

            $ids = $ids->unique()->flatten();
        }

        $this->setAuthors($ids);
        $this->setPublishers($ids);
    }


    public function selectAuthor($slug)
    {
        if ( ! $this->selectedAuthors) {
            $this->selectedAuthors = collect();
        }

        $author = Author::where('slug', $slug)->first();

        $this->selectedAuthors->put($author->id, $author);

        //dd($author);

        //array_push($this->selectedAuthors, $author->toArray());

        $this->queryString = ['author' => $slug];
    }



    public function render()
    {
        return view('livewire.front.partials.catalog-filter');
    }


    private function setAuthors($ids)
    {
        $author_ids = Product::whereIn('id', $ids)->pluck('author_id')->unique();
        $this->authors = Author::whereIn('id', $author_ids)->get();
    }


    private function setPublishers($ids)
    {
        $publisher_ids = Product::whereIn('id', $ids)->pluck('publisher_id')->unique();
        $this->publishers = Publisher::whereIn('id', $publisher_ids)->get();
    }
}
