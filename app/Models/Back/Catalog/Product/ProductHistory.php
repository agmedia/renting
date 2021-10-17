<?php

namespace App\Models\Back\Catalog\Product;

use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Category;
use App\Models\Back\Catalog\Publisher;
use App\Models\Back\Settings\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ProductHistory extends Model
{

    /**
     * @var string $table
     */
    protected $table = 'history_log';

    /**
     * @var array $guarded
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    private $new;

    /**
     * @var array|null
     */
    private $old;

    /**
     * @var string
     */
    private $changed = '';

    /**
     * @var string
     */
    private $target = 'product';


    /**
     * ProductHistory constructor.
     *
     * @param array      $new
     * @param array|null $old
     */
    public function __construct(array $new, array $old = null)
    {
        $this->new = $new;
        $this->old = $old ?: null;
    }


    /**
     * @param string $type
     */
    public function addData(string $type)
    {
        Log::info($this->new);
        Log::info($this->old);

        if ($this->old) {
            $this->collectChangedValues();
        } else {
            $this->addNewValue();
        }

        return $this->valueResponse();
    }


    private function valueResponse()
    {
        if ($this->changed != '') {
            Log::info($this->changed);
            return $this->changed;
        }
        Log::info('Proizvod je snimljen. Bez promjene...');
        return 'Proizvod je snimljen. Bez promjene...';
    }


    private function addNewValue()
    {
        $this->changed = 'Dodana je nova knjiga.';
    }


    private function collectChangedValues()
    {
        // Author changed
        if ($this->old['author_id'] != $this->new['author_id']) {
            $old = Author::find($this->old['author_id']);
            $new = Author::find($this->new['author_id']);

            $this->changed .= '<br>Promijenjen autor: <b>' . (isset($old->title) ? $old->title : '(Nepoznat)') . '</b> u <b>' . (isset($new->title) ? $new->title : '(Nepoznat)') . '</b>' ;
        }

        // Publisher changed
        if ($this->old['publisher_id'] != $this->new['publisher_id']) {
            $old = Publisher::find($this->old['publisher_id']);
            $new = Publisher::find($this->new['publisher_id']);

            $this->changed .= '<br>Promijenjen nakladnik: <b>' . (isset($old->title) ? $old->title : '(Nepoznat)') . '</b> u <b>' . (isset($new->title) ? $new->title : '(Nepoznat)') . '</b>' ;
        }

        // Action changed
        if ($this->old['action_id'] != $this->new['action_id'] ||
            $this->old['special'] != $this->new['special'] ||
            $this->old['special_from'] != $this->new['special_from'] ||
            $this->old['special_to'] != $this->new['special_to']
        ) {
            $action = ($this->old['action_id'] != $this->new['action_id']) ? ' dodana kroz akciju.' : '.';

            if ($this->old['special'] != $this->new['special']) {
                $old = $this->old['special'] ? number_format($this->old['special'], 2, ',', '.') : 'prazno';
                $new = $this->new['special'] ? number_format($this->new['special'], 2, ',', '.') : 'prazno';
                $action_price = ('<b>' . $old . '</b> u <b>' . $new . '</b>');
            } else {
                $action_price = 'nema promijene';
            }

            $action_duration = '';

            if ($this->old['special_from'] != $this->new['special_from']) {
                $old = $this->old['special_from'] ? Carbon::make($this->old['special_from'])->format('d.m.Y') : 'neograničeno';
                $new = $this->new['special_from'] ? Carbon::make($this->new['special_from'])->format('d.m.Y') : 'neograničeno';
                $action_duration .= ('Od: <b>' . $old . '</b> u <b>' . $new . '</b>');
            } else {
                $action_duration .= 'Od: nema promijene';
            }

            if ($this->old['special_to'] != $this->new['special_to']) {
                $old = $this->old['special_to'] ? Carbon::make($this->old['special_to'])->format('d.m.Y') : 'neograničeno';
                $new = $this->new['special_to'] ? Carbon::make($this->new['special_to'])->format('d.m.Y') : 'neograničeno';
                $action_duration .= ('Do: <b>' . $old . '</b> u <b>' . $new . '</b>');
            } else {
                $action_duration .= 'Do: nema promijene';
            }


            $this->changed .= '<br>Promijenjena je akcija' . $action . '<br>';
            $this->changed .= 'Akcijska cijena: ' . $action_price;
            $this->changed .= 'Trajanje: ' . $action_duration;
        }

        // Name changed
        if ($this->old['name'] != $this->new['name']) {
            $this->changed .= '<br>Promijenjeno ime: <b>' . $this->old['name'] . '</b> u <b>' . $this->new['name'] . '</b>';
        }

        // Sku changed
        if ($this->old['sku'] != $this->new['sku']) {
            $this->changed .= '<br>Promijenjena šifra: <b>' . $this->old['sku'] . '</b> u <b>' . $this->new['sku'] . '</b>';
        }

        // Polica changed
        if ($this->old['polica'] != $this->new['polica']) {
            $this->changed .= '<br>Promijenjena polica: <b>' . $this->old['polica'] . '</b> u <b>' . $this->new['polica'] . '</b>';
        }

        // Description changed
        if ($this->old['description'] != $this->new['description']) {
            $this->changed .= '<br>Promijenjena je opis knjige.';
        }

        // Image main changed
        if ($this->old['image'] != $this->new['image']) {
            $this->changed .= '<br>Promijenjena je glavna slika knjige.';
        }

        // Price changed
        if ($this->old['price'] != $this->new['price']) {
            $this->changed .= '<br>Promijenjena cijena: <b>' . number_format($this->old['price'], 2, ',', '.') . '</b> u <b>' . number_format($this->new['price'], 2, ',', '.') . '</b>';
        }

        // Quantity changed
        if ($this->old['quantity'] != $this->new['quantity']) {
            $this->changed .= '<br>Promijenjena količina: <b>' . $this->old['quantity'] . '</b> u <b>' . $this->new['quantity'] . '</b>';
        }

        // Tax changed
        if ($this->old['tax_id'] != $this->new['tax_id']) {
            $old = Settings::get('tax', 'list')->where('id', $this->old['tax_id'])->first();
            $new = Settings::get('tax', 'list')->where('id', $this->new['tax_id'])->first();

            $this->changed .= '<br>Promijenjen porez: <b>' . (isset($old->title) ? $old->title : '(Nepoznat)') . '</b> u <b>' . (isset($new->title) ? $new->title : '(Nepoznat)') . '</b>';
        }

        // Meta data changed
        if ($this->old['meta_title'] != $this->new['meta_title'] || $this->old['meta_description'] != $this->new['meta_description']) {
            $this->changed .= '<br>Promijenjeni meta podaci knjige.';
        }

        // pages changed
        if ($this->old['pages'] != $this->new['pages']) {
            $this->changed .= '<br>Promijenjen broj stranica: <b>' . $this->old['pages'] . '</b> u <b>' . $this->new['pages'] . '</b>';
        }

        // dimensions changed
        if ($this->old['dimensions'] != $this->new['dimensions']) {
            $this->changed .= '<br>Promijenjene dimenzije: <b>' . $this->old['dimensions'] . '</b> u <b>' . $this->new['dimensions'] . '</b>';
        }

        // origin changed
        if ($this->old['origin'] != $this->new['origin']) {
            $this->changed .= '<br>Promijenjeno mjesto izdavanja: <b>' . $this->old['origin'] . '</b> u <b>' . $this->new['origin'] . '</b>';
        }

        // letter changed
        if ($this->old['letter'] != $this->new['letter']) {
            $this->changed .= '<br>Promijenjeno pismo: <b>' . $this->old['letter'] . '</b> u <b>' . $this->new['letter'] . '</b>';
        }

        // condition changed
        if ($this->old['condition'] != $this->new['condition']) {
            $this->changed .= '<br>Promijenjeno stanje: <b>' . $this->old['condition'] . '</b> u <b>' . $this->new['condition'] . '</b>';
        }

        // binding changed
        if ($this->old['binding'] != $this->new['binding']) {
            $this->changed .= '<br>Promijenjen uvez: <b>' . $this->old['binding'] . '</b> u <b>' . $this->new['binding'] . '</b>';
        }

        // year changed
        if ($this->old['year'] != $this->new['year']) {
            $this->changed .= '<br>Promijenjena godina izdavanja: <b>' . $this->old['year'] . '</b> u <b>' . $this->new['year'] . '</b>';
        }

        // status changed
        if ($this->old['status'] != $this->new['status']) {
            $this->changed .= '<br>Promijenjena status vidljivosti: <b>' . ($this->new['status'] ? 'Aktiviran' : 'Deaktiviran') . '</b>';
        }

        // category changed
        if ($this->old['categories'][0]['id'] != $this->new['categories'][0]['id']) {
            $this->changed .= '<br>Promijenjena kategorija: <b>' . $this->old['categories'][0]['title'] . '</b> u <b>' . $this->new['categories'][0]['title'] . '</b>';
        }
    }
}
