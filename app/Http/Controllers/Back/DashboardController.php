<?php

namespace App\Http\Controllers\Back;

use App\Helpers\Import;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Back\Catalog\Mjerilo;
use App\Models\Back\Catalog\Product\Product;
use App\Models\Back\Catalog\Product\ProductCategory;
use App\Models\Back\Catalog\Product\ProductImage;
use App\Models\Back\Chart;
use App\Models\Back\Ovjera;
use App\Models\Back\Zahtjev;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DashboardController extends Controller
{

    //
    public function index()
    {
        /*$zahtjevi = Zahtjev::listSearch()->paginate(5);
        $ovjera   = new Ovjera();
        $ovjere   = $ovjera->filterByRoles((new Ovjera())->newQuery())->paginate(5);
        $mjerila  = (new Mjerilo())->listSearch()->paginate(5);

        // Chart and total data
        $chart        = new Chart();
        $data         = auth()->user()->totalByMonth($chart->setQueryParams());
        $months_array = $chart->setDataByMonth($data);
        $months       = json_encode($chart->setDataByMonth($data));
        $total        = $chart->total($months_array);*/

        return view('back.dashboard'/*, compact('zahtjevi', 'ovjere', 'mjerila', 'months', 'months_array', 'total')*/);
    }


    /**
     * Import initialy from excel files.
     *
     * @param Request $request
     */
    public function import(Request $request)
    {
        $spread = IOFactory::load(public_path('assets/artikli.csv'));
        $sheet  = $spread->getActiveSheet();
        $list   = array(1, $sheet->toArray(null, true, true, true))[1];

        //dd($list);

        $import = new Import();
        $count = 0;

        $unknown_author_id = 6;
        $unknown_publisher_id = 2;

        for ($i = 2; $i < count($list); $i++) {
            //dd($list[$i]);
            $attributes = $import->setAttributes($list[$i]);

            $categories = $import->resolveCategories(explode(', ', $list[$i]['AA']));

            dd($categories);

            return;

            $name = $list[$i]['D'];

            $product_id = Product::insertGetId([
                'author_id'        => $attributes['author'] ?: $unknown_author_id,
                'publisher_id'     => $attributes['publisher'] ?: $unknown_publisher_id,
                'action_id'        => 0,
                'name'             => $name,
                'sku'              => $list[$i]['C'],
                'description'      => $list[$i]['H'],
                'slug'             => Str::slug($name),
                'price'            => $list[$i]['Z'],
                'quantity'         => $list[$i]['O'],
                'tax_id'           => 1,
                'special'          => $list[$i]['Y'],
                'special_from'     => null,
                'special_to'       => null,
                'meta_title'       => $name,
                'meta_description' => $name,
                'pages'            => $attributes['pages'],
                'dimensions'       => $attributes['dimensions'],
                'origin'           => $attributes['origin'],
                'letter'           => $attributes['letter'],
                'condition'        => $attributes['condition'],
                'binding'          => $attributes['binding'],
                'year'             => $attributes['year'],
                'viewed'           => 0,
                'sort_order'       => 0,
                'push'             => 0,
                'status'           => $list[$i]['O'] ? 1 : 0,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now()
            ]);

            if ($product_id) {
                $images = $import->resolveImages(explode(', ', $list[$i]['AD']), $name);
                $categories = $import->resolveCategories(explode(', ', $list[$i]['AA']));

                if ($images) {
                    for ($i = 0; $i < count($images); $i++) {
                        ProductImage::insert([
                            'product_id' => $product_id,
                            'image'      => $images[$i],
                            'alt'        => $name,
                            'published'  => 1,
                            'sort_order' => $i,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }
                }

                if ($categories) {
                    foreach ($categories as $category) {
                        ProductCategory::insert([
                            'product_id'  => $product_id,
                            'category_id' => $category
                        ]);
                    }
                }

                $count++;
            }
        }

        return redirect()->route('dashboard')->with(['success' => 'Import je uspješno obavljen..! ' . $count . ' proizvoda importano.']);
    }


    /**
     * Set up roles. Should be done once only.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setRoles()
    {
        if ( ! auth()->user()->can('*')) {
            abort(401);
        }

        $superadmin = Bouncer::role()->firstOrCreate([
            'name' => 'superadmin',
            'title' => 'Super Administrator',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'editor',
            'title' => 'Editor',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'customer',
            'title' => 'Customer',
        ]);

        Bouncer::allow($superadmin)->everything();

        Bouncer::ability()->firstOrCreate([
            'name' => 'set-super',
            'title' => 'Postavi korisnika kao Superadmina.'
        ]);

        $users = User::whereIn('email', ['filip@agmedia.hr', 'tomislav@agmedia.hr'])->get();

        foreach ($users as $user) {
            $user->assign($superadmin);
        }

        return redirect()->route('dashboard');
    }
}
