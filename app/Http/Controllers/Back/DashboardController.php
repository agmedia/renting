<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Mjerilo;
use App\Models\Back\Chart;
use App\Models\Back\Ovjera;
use App\Models\Back\Zahtjev;
use App\Models\User;
use Illuminate\Http\Request;
use Bouncer;

class DashboardController extends Controller
{

    //
    public function index()
    {
        $zahtjevi = Zahtjev::listSearch()->paginate(5);
        $ovjera   = new Ovjera();
        $ovjere   = $ovjera->filterByRoles((new Ovjera())->newQuery())->paginate(5);
        $mjerila  = (new Mjerilo())->listSearch()->paginate(5);

        // Chart and total data
        $chart        = new Chart();
        $data         = auth()->user()->totalByMonth($chart->setQueryParams());
        $months_array = $chart->setDataByMonth($data);
        $months       = json_encode($chart->setDataByMonth($data));
        $total        = $chart->total($months_array);

        return view('dashboard', compact('zahtjevi', 'ovjere', 'mjerila', 'months', 'months_array', 'total'));
    }


    /**
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
