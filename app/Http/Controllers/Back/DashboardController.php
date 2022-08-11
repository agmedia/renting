<?php

namespace App\Http\Controllers\Back;

use App\Helpers\Chart;
use App\Helpers\Helper;
use App\Helpers\Import;
use App\Helpers\ProductHelper;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Mail\OrderReceived;
use App\Mail\OrderSent;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Category;
use App\Models\Back\Catalog\Mjerilo;
use App\Models\Back\Catalog\Publisher;
use App\Models\Back\Orders\Order;
use App\Models\Back\Orders\OrderProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DashboardController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['today']      = Order::whereDate('created_at', Carbon::today())->count();
        $data['proccess']   = Order::whereIn('order_status_id', [1, 2, 3])->count();
        $data['finished']   = Order::whereIn('order_status_id', [4, 5, 6, 7])->count();
        $data['this_month'] = Order::whereMonth('created_at', '=', Carbon::now()->month)->count();

        $orders   = Order::last()->get();
        /*$products = $orders->map(function ($item) {
            return $item->products()->get();
        })->flatten();*/

        $chart     = new Chart();
        $this_year = json_encode($chart->setDataByYear(
            Order::chartData($chart->setQueryParams())
        ));
        $last_year = json_encode($chart->setDataByYear(
            Order::chartData($chart->setQueryParams(true))
        ));

        return view('back.dashboard', compact('data', 'orders'/*, 'products'*/, 'this_year', 'last_year'));
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
            'name'  => 'superadmin',
            'title' => 'Super Administrator',
        ]);

        Bouncer::role()->firstOrCreate([
            'name'  => 'admin',
            'title' => 'Administrator',
        ]);

        Bouncer::role()->firstOrCreate([
            'name'  => 'editor',
            'title' => 'Editor',
        ]);

        Bouncer::role()->firstOrCreate([
            'name'  => 'customer',
            'title' => 'Customer',
        ]);

        Bouncer::allow($superadmin)->everything();

        Bouncer::ability()->firstOrCreate([
            'name'  => 'set-super',
            'title' => 'Postavi korisnika kao Superadmina.'
        ]);

        $users = User::whereIn('email', ['filip@agmedia.hr', 'tomislav@agmedia.hr'])->get();

        foreach ($users as $user) {
            $user->assign($superadmin);
        }

        return redirect()->route('dashboard');
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mailing(Request $request)
    {
        /*$order = Order::where('id', 16)->first();

        dispatch(function () use ($order) {
            Mail::to(config('mail.admin'))->send(new OrderReceived($order));
            Mail::to($order->payment_email)->send(new OrderSent($order));
        });*/

        return redirect()->route('dashboard');
    }



}
