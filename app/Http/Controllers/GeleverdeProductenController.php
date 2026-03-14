<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeleverdeProductenController extends Controller
{
    /**
     * Overzicht geleverde producten (Wireframe-02, Wireframe-04)
     * Scenario 01 & 03: filter op tijdsvak, totaal geleverd per product, of melding geen leveringen
     */
    public function index(Request $request)
    {
        $startDatum = $request->get('startdatum');
        $eindDatum  = $request->get('einddatum');

        if ($startDatum && $eindDatum) {
            $start = \Carbon\Carbon::parse($startDatum)->format('Y-m-d');
            $end   = \Carbon\Carbon::parse($eindDatum)->format('Y-m-d');
            $leveringen = DB::select('CALL sp_GetGeleverdeProductenByTijdsvak(?, ?)', [$start, $end]);
        } else {
            // Geen selectie: alle leveringen tot en met vandaag (Wireframe-02)
            $leveringen = DB::select('CALL sp_GetGeleverdeProductenByTijdsvak(?, ?)', ['2000-01-01', now()->format('Y-m-d')]);
        }

        return view('geleverde-producten.index', [
            'leveringen'   => $leveringen,
            'startdatum'   => $startDatum,
            'einddatum'    => $eindDatum,
        ]);
    }

    /**
     * Specificatie geleverde producten (Wireframe-03)
     * Scenario 02: per leveringdatum en aantal voor één product in het tijdsvak
     */
    public function specificatie(Request $request, int $productId)
    {
        $startDatum = $request->get('startdatum');
        $eindDatum  = $request->get('einddatum');

        if (!$startDatum || !$eindDatum) {
            return redirect()->route('geleverde-producten.index')->with('error', 'Selecteer een tijdsvak.');
        }

        $start = \Carbon\Carbon::parse($startDatum)->format('Y-m-d');
        $end   = \Carbon\Carbon::parse($eindDatum)->format('Y-m-d');

        $product = DB::select('SELECT Id, Naam FROM Product WHERE Id = ?', [$productId]);
        if (empty($product)) {
            abort(404, 'Product niet gevonden');
        }
        $product = (object) $product[0];

        $allergenen = DB::select("
            SELECT a.Naam
            FROM ProductPerAllergeen ppa
            INNER JOIN Allergeen a ON ppa.AllergeenId = a.Id
            WHERE ppa.ProductId = ?
            ORDER BY a.Naam
        ", [$productId]);
        $allergenenNamen = array_map(fn($r) => $r->Naam, $allergenen);

        $specificaties = DB::select('CALL sp_GetSpecificatieLeveringen(?, ?, ?)', [$productId, $start, $end]);

        return view('geleverde-producten.specificatie', [
            'product'        => $product,
            'allergenenNamen'=> $allergenenNamen,
            'specificaties'  => $specificaties,
            'startdatum'     => $startDatum,
            'einddatum'      => $eindDatum,
        ]);
    }
}
