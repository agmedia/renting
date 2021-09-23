<?php

namespace App\Http\Livewire\Front\Partials;

use App\Models\Front\Catalog\Author;
use App\Models\Front\Catalog\Publisher;
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
    public $authors = [];

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
    public $publishers = [];

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
     * @var
     */
    public $searcha;
    /**
     * @var
     */
    public $searchp;

    /**
     * @var \string[][]
     */
    protected $queryString = [
        /*'autor' => ['except' => ''],
        'nakladnik' => ['except' => ''],*/
        'start' => ['except' => ''],
        'end' => ['except' => '']
    ];


    /**
     *
     */
    public function mount()
    {
        $this->setCategories();

    }


    /**
     * @param $value
     */
    public function updatingSearcha($value)
    {
        $this->searcha = $value;
        $this->authors = [];

        if ($this->searcha != '') {
            $this->authors = Author::where('title', 'LIKE', '%' . $this->searcha . '%')
                                   ->select('id', 'title', 'url')
                                   ->withCount('products')
                                   ->having('products_count', '>', 0)
                                   ->limit(5)
                                   ->get();
        }

    }


    /**
     * @param $value
     */
    public function updatingSearchp($value)
    {
        $this->searchp    = $value;
        $this->publishers = [];

        if ($this->searchp != '') {
            $this->publishers = Publisher::where('title', 'LIKE', '%' . $this->searchp . '%')
                                         ->select('id', 'title', 'url')
                                         ->withCount('products')
                                         ->having('products_count', '>', 0)
                                         ->limit(5)
                                         ->get();
        }

    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        //dd($this->selected_author);

        $this->emit('idChanged', [
            'ids' => $this->ids,
            /*'author' => $this->authors,
            'publisher' => $this->publishers,*/
            'start' => $this->start,
            'end' => $this->end
        ]);

        return view('livewire.front.partials.author-filter');
    }


    /**
     *
     */
    private function setCategories()
    {
        $response = [];

        // AKo su autori
        if ($this->selected_author) {
            if ($this->category) {
                $categories = $this->selected_author->categories($this->category->id);
            } else {
                $categories = $this->selected_author->categories();
            }

            foreach ($categories as $category) {
                $response[] = [
                    'id' => $category['id'],
                    'title' => $category['title'],
                    'count' => $category['products_count'],
                    'url' => route('catalog.route.author', ['author' => $this->selected_author, 'cat' => ($category->parent ?: $category), 'subcat' => ($category->parent ? $category : $category->parent)])
                ];
            }
        }

        // Ako su nakladnici
        if ($this->selected_publisher) {
            if ($this->category) {
                $categories = $this->selected_publisher->categories($this->category->id)->all();
            } else {
                $categories = $this->selected_publisher->categories()->all();
            }

            foreach ($categories as $category) {
                $response[] = [
                    'id' => $category['id'],
                    'title' => $category['title'],
                    'count' => $category['products_count'],
                    'url' => route('catalog.route.publisher', ['publisher' => $this->selected_publisher, 'cat' => ($category->parent ?: $category), 'subcat' => ($category->parent ? $category : $category->parent)])
                ];
            }
        }

        //dd($this);

        $this->categories = $response;

        if ($this->subcategory) {
            $this->categories = null;
        }
    }
}
