<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Leverancier;
use App\Models\Product;

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
}
