<?php

namespace App\Http\Controllers\Back\Settings\App;

use App\Http\Controllers\Controller;
use App\Models\Back\Settings\Faq;
use App\Models\Back\Settings\Settings;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkForNewFiles();

        $payments = Settings::getList('payment', 'list.%', false);

        //dd($payments);

        return view('back.settings.app.payment.payment', compact('payments'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $updated = Settings::setListItem('payment', 'list.' . $request->data['code'], $request->data);

        if ($updated) {
            return response()->json(['success' => 'Način plaćanja je uspješno snimljen.']);
        }

        return response()->json(['message' => 'Server error! Pokušajte ponovo ili kontaktirajte administratora!']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Faq $faq)
    {
        $destroyed = Faq::destroy($faq->id);

        if ($destroyed) {
            return redirect()->route('faqs')->with(['success' => 'Faq was succesfully deleted!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error deleting the faq.']);
    }


    /**
     * Check for new files in ..payment/modals directory.
     * Install payment if new files exist.
     */
    private function checkForNewFiles(): void
    {
        $files    = new \DirectoryIterator('./../resources/views/back/settings/app/payment/modals');

        foreach ($files as $file) {
            if (strpos($file, 'blade.php') !== false) {
                $filename = str_replace('.blade.php', '', $file);
                $exist = false;

                $payment = collect(Settings::get('payment', 'list.' . $filename));

                if ($payment) {
                    $exist = $payment->where('code', $filename)->first();
                }

                if ( ! $exist) {
                    $default_value = [
                        'title' => $filename,
                        'code' => $filename,
                        'data' => [
                            'description' => ''
                        ],
                        'sort_order' => 0,
                        'status' => 0
                    ];

                    Settings::set('payment', 'list.' . $filename, $default_value);
                }

            }
        }
    }
}
