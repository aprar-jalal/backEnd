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
            'company_size'=> 'sometimes|string|max:255',
            'description'=> 'sometimes|string',
            'logo_url'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo_url')) {
            $file = $request->file('logo_url');
            $path = $file->store('employersLogos', 'public');
            $employer->logo_url = $path;
        }

        $employer->update($validatedData);

        return response()->json(['message' => 'updated successfully', 'employer' => $employer]);

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
