<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    function index()
    {
        $employer = Employer::all();
        return response()->json($employer,200);

    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $employer = Employer::where('user_id', $user->user_id)->first();

        if (!$employer) {
            return response()->json(['message' => 'Employer not found'], 404);
        }

        $validatedData = $request->validate([
            'company_name'=> 'sometimes|string|max:255',
            'industry'=> 'sometimes|string|max:255',
            'established_date'=> 'sometimes|date',
            'company_size'=> 'sometimes|string|in:1-10,11-50,51-200,201-500,501-1000,1000+',
            'description'=> 'sometimes|string',
        ]);


        $employer->update($validatedData);

        return response()->json(['message' => 'updated successfully', 'employer' => $employer]);

    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo_url' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $employer = Employer::where('user_id', $user->user_id)->first();

        if (!$employer) {
            return response()->json(['error' => 'Employer not found'], 404);
        }

        $path = $request->file('logo_url')->store('employerLogos', 'public');

        $employer->logo_url = $path;
        $employer->save();

        return response()->json(['logo_url' => $path]);
    }



    function show(){
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $employer = Employer::where('user_id', $user->user_id)->first();

        if (!$employer) {
            return response()->json(['message' => 'Employer not found'], 404);
        }

        return response()->json($employer, 200);
    }

    function destroy(){
        $user = Auth::user();

        $employer = Employer::where('user_id', $user->user_id);

        if (!$employer) {
            return response()->json(['message' => 'Employer not found'], 404);
        }

        $employer->delete();
        return response()->json(null,204);
    }
}
