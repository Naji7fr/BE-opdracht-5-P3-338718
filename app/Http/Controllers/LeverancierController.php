<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Leverancier;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class LeverancierController extends Controller
{
    /**
     * Display a listing of suppliers with product count
     */
    public function index()
    {
        // Use stored procedure to get all suppliers with product count
        $leveranciers = DB::select('CALL sp_GetAllLeveranciers()');
        
        return view('leveranciers.index', compact('leveranciers'));
    }

    /**
     * Display products for a specific supplier
     */
    public function showProducten($id)
    {
        // Get supplier info
        $leverancier = DB::select('CALL sp_GetLeverancierById(?)', [$id]);
        
        if (empty($leverancier)) {
            abort(404, 'Leverancier niet gevonden');
        }
        
        $leverancier = $leverancier[0];
        
        // Get products for this supplier
        $producten = DB::select('CALL sp_GetProductenByLeverancier(?)', [$id]);
        
        // Check if supplier has no products
        if (empty($producten)) {
            return view('leveranciers.no-products', compact('leverancier'));
        }
        
        return view('leveranciers.producten', compact('leverancier', 'producten'));
    }

    /**
     * Show form for adding new product delivery
     */
    public function createLevering($leverancierId, $productId)
    {
        $leverancier = Leverancier::findOrFail($leverancierId);
        $product = Product::findOrFail($productId);
        
        return view('leveranciers.levering-form', compact('leverancier', 'product'));
    }

    /**
     * Store new product delivery
     */
    public function storeLevering(Request $request, $leverancierId, $productId)
    {
        $request->validate([
            'aantal' => 'required|integer|min:1',
            'datum_volgende_levering' => 'nullable|date'
        ]);

        $leverancier = Leverancier::findOrFail($leverancierId);
        $product = Product::findOrFail($productId);

        try {
            // Use stored procedure to add delivery and update stock
            DB::statement('CALL sp_AddProductLevering(?, ?, ?, ?)', [
                $leverancierId,
                $productId,
                $request->aantal,
                $request->datum_volgende_levering
            ]);

            return redirect()
                ->route('leveranciers.producten', $leverancierId)
                ->with('success', 'Levering succesvol toegevoegd');

        } catch (\Exception $e) {
            // Check if product is inactive
            if (strpos($e->getMessage(), 'niet meer actief') !== false || $product->IsActief == 0) {
                return back()
                    ->with('error', "Het product {$product->Naam} van de leverancier {$leverancier->Naam} wordt niet meer geproduceerd")
                    ->with('redirect_after', 4)
                    ->with('redirect_url', route('leveranciers.producten', $leverancierId));
            }

            return back()->with('error', 'Er is een fout opgetreden bij het toevoegen van de levering');
        }
    }

    /**
     * Display paginated list of suppliers for editing (Wijzigen Leveranciers)
     */
    public function wijzigen(Request $request)
    {
        // Get all suppliers with contact info
        $allLeveranciers = DB::select('
            SELECT 
                l.Id,
                l.Naam,
                l.ContactPersoon,
                l.LeverancierNummer,
                l.Mobiel,
                c.Straat,
                c.Huisnummer,
                c.Postcode,
                c.Stad
            FROM Leverancier l
            INNER JOIN Contact c ON l.ContactId = c.Id
            WHERE l.IsActief = 1
            ORDER BY l.Naam
        ');

        // Convert to collection for pagination
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 4; // Max 4 records per page as per requirement
        $items = collect($allLeveranciers);
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $leveranciers = new LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('leveranciers.wijzigen', compact('leveranciers'));
    }

    /**
     * Display supplier details for editing
     */
    public function show($id)
    {
        $result = DB::select('CALL sp_GetLeverancierWithContactById(?)', [$id]);
        
        if (empty($result)) {
            abort(404, 'Leverancier niet gevonden');
        }
        
        $leverancier = (object) $result[0];
        
        return view('leveranciers.details', compact('leverancier'));
    }

    /**
     * Show the form for editing the specified supplier
     */
    public function edit($id)
    {
        $result = DB::select('CALL sp_GetLeverancierWithContactById(?)', [$id]);
        
        if (empty($result)) {
            abort(404, 'Leverancier niet gevonden');
        }
        
        $leverancier = (object) $result[0];
        
        return view('leveranciers.edit', compact('leverancier'));
    }

    /**
     * Update the specified supplier
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'naam' => 'required|string|max:100',
            'contactpersoon' => 'required|string|max:100',
            'leveranciernummer' => 'required|string|max:50',
            'mobiel' => 'required|string|max:15',
            'straat' => 'required|string|max:100',
            'huisnummer' => 'required|string|max:10',
            'postcode' => 'required|string|max:10',
            'stad' => 'required|string|max:100'
        ]);

        try {
            // Use stored procedure to update supplier
            DB::statement('CALL sp_UpdateLeverancier(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->naam,
                $request->contactpersoon,
                $request->leveranciernummer,
                $request->mobiel,
                $request->straat,
                $request->huisnummer,
                $request->postcode,
                $request->stad
            ]);

            return redirect()
                ->route('leveranciers.edit', $id)
                ->with('success', 'De wijzigingen zijn doorgevoerd')
                ->with('redirect_after', 3)
                ->with('redirect_url', route('leveranciers.show', $id));

        } catch (\Exception $e) {
            // Redirect back to edit page with error message, then redirect to details after 3 seconds
            return redirect()
                ->route('leveranciers.edit', $id)
                ->with('error', 'Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens')
                ->with('redirect_after', 3)
                ->with('redirect_url', route('leveranciers.show', $id));
        }
    }
}
