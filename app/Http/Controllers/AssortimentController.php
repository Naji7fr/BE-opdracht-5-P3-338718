<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssortimentController extends Controller
{
    /**
     * Wireframe-02: Overzicht producten uit het assortiment
     * Scenario 01: filter op tijdsvak, gesorteerd op EinddatumLevering aflopend
     */
    public function index(Request $request)
    {
        $startDatum = $request->get('startdatum');
        $eindDatum  = $request->get('einddatum');

        if ($startDatum && $eindDatum) {
            $start = \Carbon\Carbon::parse($startDatum)->format('Y-m-d');
            $end   = \Carbon\Carbon::parse($eindDatum)->format('Y-m-d');
            $producten = DB::select('CALL sp_GetProductenUitAssortiment(?, ?)', [$start, $end]);
        } else {
            $producten = DB::select('CALL sp_GetProductenUitAssortiment(?, ?)', ['2000-01-01', '2099-12-31']);
        }

        return view('assortiment.index', [
            'producten'  => $producten,
            'startdatum' => $startDatum,
            'einddatum'  => $eindDatum,
        ]);
    }

    /**
     * Wireframe-03 / 05: Product detail met allergeeninfo en Verwijder knop
     */
    public function show(Request $request, int $productId)
    {
        $result = DB::select('CALL sp_GetProductDetail(?)', [$productId]);

        if (empty($result)) {
            abort(404, 'Product niet gevonden');
        }

        $product    = (object) $result[0];
        $startdatum = $request->get('startdatum');
        $einddatum  = $request->get('einddatum');

        return view('assortiment.show', [
            'product'    => $product,
            'startdatum' => $startdatum,
            'einddatum'  => $einddatum,
        ]);
    }

    /**
     * Wireframe-04 / 06: Verwijder product na bevestiging
     * Scenario 02: succesvol verwijderd
     * Scenario 03: blokkade – datum van vandaag ligt voor einddatum levering
     */
    public function destroy(Request $request, int $productId)
    {
        $resultaat = DB::select('CALL sp_VerwijderProduct(?)', [$productId]);
        $status    = $resultaat[0]->resultaat ?? 'blocked';

        $startdatum = $request->get('startdatum');
        $einddatum  = $request->get('einddatum');

        if ($status === 'success') {
            return redirect()
                ->route('assortiment.show', ['productId' => $productId, 'startdatum' => $startdatum, 'einddatum' => $einddatum])
                ->with('success', 'Product is succesvol verwijdert');
        }

        return redirect()
            ->route('assortiment.show', ['productId' => $productId, 'startdatum' => $startdatum, 'einddatum' => $einddatum])
            ->with('error', 'Product kan niet worden verwijdert, datum van vandaag ligt voor einddatum levering');
    }
}
