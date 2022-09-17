<?php

namespace App\Http\Livewire\Back\Marketing;

use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Apartment\ApartmentTranslation;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Category;
use App\Models\Back\Catalog\Product\Product;
use App\Models\Back\Catalog\Publisher;
use App\Models\Back\Marketing\Blog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ActionGroupList extends Component
{
    use WithPagination;

    /**
     * @var string[]
     */
    protected $listeners = ['groupUpdated' => 'groupSelected'];

    /**
     * @var string
     */
    public $search = '';

    /**
     * @var array
     */
    public $search_results = [];

    /**
     * @var string
     */
    public $group = '';

    /**
     * @var Collection
     */
    public $list = [];


    public function mount()
    {
        if ( ! empty($this->list)) {
            $ids = $this->list;
            $this->list = [];

            foreach ($ids as $id) {
                $this->addItem(intval($id));
            }

            $this->render();
        }
    }


    /**
     * @param string $value
     */
    public function updatingSearch(string $value)
    {
        $this->search = $value;
        $this->search_results = [];

        if ($this->search != '') {
            switch ($this->group) {
                case 'apartment':
                    $this->search_results = ApartmentTranslation::where('lang', current_locale())->where('title', 'like', '%' . $this->search . '%')->get();
                    break;
            }
        }
    }


    /**
     * @param int $id
     */
    public function addItem(int $id)
    {
        $this->search = '';
        $this->search_results = [];

        switch ($this->group) {
            case 'apartment':
                $this->list[$id] = Apartment::where('id', $id)->first();
                break;
        }
    }


    /**
     * @param int $id
     */
    public function removeItem(int $id)
    {
        if ($this->list[$id]) {
            unset($this->list[$id]);
        }
    }


    /**
     * @param string $group
     */
    public function groupSelected(string $group)
    {
        $this->group = $group;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        if ( ! empty($this->list)) {
            $this->emit('list_full');
        } else {
            $this->emit('list_empty');
        }

        return view('livewire.back.marketing.action-group-list', [
            'list' => $this->list,
            'group' => $this->group
        ]);
    }


    /**
     * @return string
     */
    public function paginationView()
    {
        return 'vendor.pagination.bootstrap-livewire';
    }
}
