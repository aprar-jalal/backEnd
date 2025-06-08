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

        if ($request->hasFile('logo_url')) {
            $file = $request->file('logo_url');
            $path = $file->store('employersLogos', 'public');
            $employer->logo_url = $path;
        }

        $employer->update($request->only(
            'company_name',
            'description',
            'industry',
            'company_size',
            'established_date'
        ));

        return response()->json($employer);
    }


    function show(){
        $user = Auth::user();
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
