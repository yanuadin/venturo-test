<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class SalesReportController extends Controller
{
    public function index(Request $request): View
    {
        //Default Value
        $year = $request->filled('tahun') ? $request->input('tahun') : 2021;

        //Get and collect data from API
        $menus = collect(Http::get('https://tes-web.landa.id/intermediate/menu')->json());
        $transactions = collect(Http::get('https://tes-web.landa.id/intermediate/transaksi?tahun=' . $year)->json())->groupBy('menu');

        $summaryMonths = array_fill(0, 13, 0);

        //Arrange data for front-end
        foreach ($menus as $key => $menu) {
            try {
                $trans = $transactions[$menu['menu']]->groupBy(function ($value) {
                    return Carbon::parse($value['tanggal'])->translatedFormat('n');
                });

                for ($i = 0; $i < 12; $i++) {
                    $matchKey = (string) ($i + 1);

                    $subtotal = isset($trans[$matchKey]) ? $trans[$matchKey]->sum('total') : 0;

                    //Sub Total
                    $menu['subtotal'][] = $subtotal;

                    //Total @month
                    $summaryMonths[$i] += $subtotal;
                }

                //Total
                $menu['total'] = $transactions[$menu['menu']]->sum('total');

                //Grand Total
                $summaryMonths[12] += $menu['total'];

                $results[$key] = $menu;
            }catch (\Exception $e) {

            }
        }

        //Group by kategori
        $results = collect($results)->groupBy('kategori');

        return view('sales-report', ['results' => $results, 'summaryMonths' => $summaryMonths, 'year' => $year]);
    }
}
