<?php

namespace App\Http\Livewire\Front\Partials;

use App\Helpers\Query;
use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Category;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\Publisher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

/**
 * Class CatalogFilter
 * @package App\Http\Livewire\Front\Partials
 */
class CatalogFilter extends Component
{

    /**
     * @var null
     */
    public $group = null;

    /**
     * @var null
     */
    public $category = null;

    /**
     * @var null
     */
    public $subcategory = null;

    /**
     * @var null
     */
    public $categories = null;

    /**
     * @var
     */
    public $ids;

    /**
     * @var
     */
    public $authors;

    /**
     * @var
     */
    public $author;

    /**
     * @var
     */
    public $products;

    /**
     * @var
     */
    public $publishers;

    /**
     * @var
     */
    public $publisher;

    /**
     * @var string
     */
    public $autor = '';

    /**
     * @var string
     */
    public $nakladnik = '';

    /**
     * @var
     */
    public $start;

    /**
     * @var
     */
    public $end;

    /**
     * @var \string[][]
     */
    protected $queryString = [
        'autor' => ['except' => ''],
        'nakladnik' => ['except' => ''],
        'start' => ['except' => ''],
        'end' => ['except' => '']
    ];


    /**
     *
     */
    public function mount()
    {
        $this->getBaseIDs();
        $this->mountQuery();
        $this->setProducts($this->ids);
        $this->setAuthors();
        $this->setPublishers();
    }


    /**
     *
     */
    public function updatedAuthor()
    {
        $this->resolveQuery();
    }


    /**
     *
     */
    public function updatedPublisher()
    {
        $this->resolveQuery();
    }


    /**
     *
     */
    public function updatedStart()
    {
        $this->resolveQuery();
    }


    /**
     *
     */
    public function updatedEnd()
    {
        $this->resolveQuery();
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $authors = [];
        /*$author_counts = Product::active()
                                ->hasStock()
                                ->groupBy('author_id')
                                ->select('author_id', DB::raw('count(*) as total'))
                                ->pluck('total','author_id')
                                ->all();*/

        /*$publisher_counts = Product::active()
                                   ->hasStock()
                                   ->groupBy('publisher_id')
                                   ->select('publisher_id', DB::raw('count(*) as total'))
                                   ->pluck('total','publisher_id')
                                   ->all();*/

        /*foreach ($this->authors as $key => $author) {
            if ( ! isset($author_counts[$author->id])) {
                $this->authors->forget($key);
                //unset($this->authors[$key]);
            } else {
                $this->authors[$key]->broj = $author_counts[$author->id];
                //$authors[$key]['autor'] = $author;
                //$authors[$key]['broj'] = $author_counts[$key];
            }
        }*/

        //dd($this->authors);

        /*foreach ($this->publishers as $key => $publisher) {
            if ( ! isset($publisher_counts[$publisher->id])) {
                $this->publishers->forget($key);
            } else {
                $this->publishers[$key]->broj = $publisher_counts[$publisher->id];
            }
        }*/

        $this->emit('idChanged', [
            'ids' => $this->ids,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'start' => $this->start,
            'end' => $this->end
        ]);

        return view('livewire.front.partials.catalog-filter');
    }


    /**
     *
     */
    private function mountQuery()
    {
        if ($this->autor != '') {
            $this->author = Query::mountAuthor($this->autor);
        }

        if ($this->nakladnik != '') {
            $this->publisher = Query::mountPublisher($this->nakladnik);
        }
    }


    /**
     *
     */
    private function resolveQuery()
    {
        if ($this->author) {
            $this->author = Query::unset($this->author);
            $this->autor = Query::resolve($this->author);
        }

        if ($this->publisher) {
            $this->publisher = Query::unset($this->publisher);
            $this->nakladnik = Query::resolve($this->publisher);
        }
    }


    /**
     * @param $ids
     */
    private function setProducts($ids)
    {
        //$this->products = Product::whereIn('id', $ids)->get();
    }


    /**
     * @param $ids
     */
    private function setAuthors()
    {
        //$this->authors = Author::active()->select('id', 'title', 'slug')->get()->toArray();
        $authors = Author::active()->pluck('title', 'id')->toArray();

        $author_counts = Product::active()
                                ->hasStock()
                                ->groupBy('author_id')
                                ->select('author_id', DB::raw('count(*) as total'))
                                ->pluck('total','author_id')
                                ->all();

        $this->authors = [];

        foreach ($authors as $key => $author) {
            if ( ! isset($author_counts[$key])) {
                //$this->authors->forget($key);
                unset($authors[$key]);
            } else {
                //$this->authors[$key]->broj = $author_counts[$author->id];
                $this->authors[$key]['title'] = $author;
                $this->authors[$key]['broj'] = $author_counts[$key];
            }
        }
    }


    /**
     * @param $ids
     */
    private function setPublishers()
    {
        //$this->publishers = Publisher::active()->select('id', 'title', 'slug')->get();
        $publishers = Publisher::active()->pluck('title', 'id')->toArray();

        $publisher_counts = Product::active()
                                   ->hasStock()
                                   ->groupBy('publisher_id')
                                   ->select('publisher_id', DB::raw('count(*) as total'))
                                   ->pluck('total','publisher_id')
                                   ->all();

        $this->publishers = [];

        foreach ($publishers as $key => $publisher) {
            if ( ! isset($publisher_counts[$key])) {
                //$this->publishers->forget($key);
                unset($publishers[$key]);
            } else {
                //$this->publishers[$key]->broj = $publisher_counts[$publisher->id];
                $this->publishers[$key]['title'] = $publisher;
                $this->publishers[$key]['broj'] = $publisher_counts[$key];
            }
        }
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    private function getBaseIDs()
    {
        if ($this->group) {
            if ( ! $this->category && ! $this->subcategory) {
                $category = new Category();
                $this->categories = $category->topList($this->group)->sortByName()->with('subcategories')->withCount('products')->get();
            }


            if ($this->category && ! $this->subcategory) {
                $item = $this->category->where('group', $this->group)->where('id', $this->category->id)->sortByName()->with('subcategories')->withCount('products')->first();

                if ($item && $item->subcategories->count()) {
                    $this->categories = $item->subcategories;
                }
            }
        }
    }
}
