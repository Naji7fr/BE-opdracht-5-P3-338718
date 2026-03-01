<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class AllergenenController extends Controller
{
    /**
     * Overzicht Allergenen (User Story 01 - Opdracht 4)
     * Scenario 01: Producten met geselecteerd allergeen, gesorteerd A-Z, pagination max 4
     */
    public function index(Request $request)
    {
        $allergenen = DB::select('SELECT Id, Naam, Omschrijving FROM Allergeen WHERE IsActief = 1 ORDER BY Naam');

        $allergeenId = $request->get('allergeen_id');

        if ($allergeenId !== null && $allergeenId !== '') {
            $producten = DB::select('CALL sp_GetProductenMetAllergeen(?)', [(int) $allergeenId]);
        } else {
            // Geen filter: alle producten met allergenen, één rij per product, A-Z
            $producten = DB::select("
                SELECT
                    p.Id AS ProductId,
                    p.Naam AS ProductNaam,
                    p.Barcode,
                    GROUP_CONCAT(a.Naam ORDER BY a.Naam SEPARATOR ', ') AS AllergeenNaam,
                    NULL AS AllergeenOmschrijving
                FROM Product p
                INNER JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId
                INNER JOIN Allergeen a ON ppa.AllergeenId = a.Id
                WHERE p.IsActief = 1 AND ppa.IsActief = 1
                GROUP BY p.Id, p.Naam, p.Barcode
                ORDER BY p.Naam ASC
            ");
        }

        // Pagination: max 4 per pagina (Opdracht 4)
        $perPage = 4;
        $currentPage = Paginator::resolveCurrentPage('page');
        $items = collect($producten);
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->values()->all();
        $productenPaginated = new LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('allergenen.index', [
            'allergenen' => $allergenen,
            'producten' => $productenPaginated,
            'geselecteerdAllergeenId' => $allergeenId,
        ]);
    }

    /**
     * Overzicht leverancier gegevens voor een product (Scenario 02 & 03)
     * Toont "Er zijn geen adresgegevens bekend" als ContactId NULL is
     */
    public function leverancierGegevens(int $productId)
    {
        $result = DB::select('CALL sp_GetLeverancierGegevensByProductId(?)', [$productId]);

        if (empty($result)) {
            abort(404, 'Geen leverancier gevonden voor dit product');
        }

        $leverancier = (object) $result[0];
        $heeftGeenAdres = $leverancier->ContactId === null;

        return view('allergenen.leverancier-gegevens', [
            'leverancier' => $leverancier,
            'heeftGeenAdres' => $heeftGeenAdres,
        ]);
    }
}
