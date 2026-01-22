<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized. Admin access required.');
        }
        
        $users = User::all(); 

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized. Admin access required.');
        }
        
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized. Admin access required.');
        }
        
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized. Admin access required.');
        }

        // Prevent admin from changing their own role
        if (Auth::user()->id === $user->id && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'U kunt uw eigen rol niet wijzigen. Voor veiligheidsredenen moet u altijd admin blijven.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,magazijn medewerker,inkoper,logistiek medewerker',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('users.index')->with('success', 'Gebruiker succesvol bijgewerkt.');
    }

    public function destroy(User $user)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized. Admin access required.');
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Gebruiker succesvol verwijderd.');
    }
}