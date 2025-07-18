<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name'  => 'required|string|max:100',
                'email'      => 'required|email',
                'phone'      => 'required|string|max:20',
                'message'    => 'nullable|string',
            ]);

            Contact::create($validated);

            return response()->json(['message' => 'Message envoyé avec succès.']);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur interne. Veuillez réessayer.',
            ], 500);
        }
    }
}
