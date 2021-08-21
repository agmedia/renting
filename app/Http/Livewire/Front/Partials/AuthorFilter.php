<?php

namespace App\Http\Livewire\Front\Partials;

use App\Helpers\Query;
use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Product;
use App\Models\Front\Catalog\Publisher;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

/**
 * Class AuthorFilter
 * @package App\Http\Livewire\Front\Partials
 */
class AuthorFilter extends Component
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
    public $products;

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
    public $selected_author;

    /**
     * @var
     */
    public $publishers;

    /**
     * @var
     */
    public $publisher;

    /**
     * @var
     */
    public $selected_publisher;

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
        $this->mountQuery();
        $this->setProducts($this->ids);

        if ($this->selected_author) {
            $this->setPublishers();
        }

        if ($this->selected_publisher) {
            $this->setAuthors();
        }

    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->setCategories();

        if ($this->selected_publisher) {
            foreach ($this->authors as $key => $author) {
                $this->authors[$key]->broj = $this->products->where('author_id', $author->id)->count();
            }
        }

        if ($this->selected_author) {
            foreach ($this->publishers as $key => $publisher) {
                $this->publishers[$key]->broj = $this->products->where('publisher_id', $publisher->id)->count();
            }
        }

        $this->emit('idChanged', [
            'ids' => $this->ids,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'start' => $this->start,
            'end' => $this->end
        ]);

        return view('livewire.front.partials.author-filter');
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
        $this->products = Product::whereIn('id', $ids)->get();
    }


    /**
     *
     */
    private function setAuthors()
    {
        $author_ids = $this->products->pluck('author_id')->unique();
        $this->authors = Author::whereIn('id', $author_ids)->get();
    }


    /**
     *
     */
    private function setPublishers()
    {
        $publisher_ids = $this->products->pluck('publisher_id')->unique();
        $this->publishers = Publisher::whereIn('id', $publisher_ids)->get();
    }


    /**
     *
     */
    private function setCategories()
    {
        if ($this->selected_author) {
            if ($this->category) {
                $this->categories = $this->selected_author->categories($this->category->id)->all();
            } else {
                $this->categories = $this->selected_author->categories()->all();
            }
        }

        if ($this->selected_publisher) {
            if ($this->category) {
                $this->categories = $this->selected_publisher->categories($this->category->id)->all();
            } else {
                $this->categories = $this->selected_publisher->categories()->all();
            }
        }

        if ($this->subcategory) {
            $this->categories = null;
        }
    }
}
