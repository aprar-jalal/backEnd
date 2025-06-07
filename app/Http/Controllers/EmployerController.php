<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{

    function index()
    {
        $employer = Employer::all();
        return response()->json($employer,200);

    }
    function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'company_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry' => 'nullable|string',
            'company_size' => 'nullable|string',
            'established_date' => 'nullable|date',
            'logo_url' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);


        if ($request->hasFile('logo_url')) {
            $validated['logo_url'] = $request->file('logo_url')->store('employersLogos', 'public');
        }

        $employer = Employer::create($validated);

        return response()->json([
            'message' => "Employer created",
            'employer' => $employer,
        ], 201);

    }

//    function update(Request $request,$id = 1)
//    {
//        $employer = Employer::findOrFail($id);
//        $employer->update(
//            $request->only('company_name', 'description', 'industry', 'logo_url', 'company_size', 'established_date')
//        );
//
//    }

    public function update(Request $request, $id = 1)
    {
        $employer = Employer::findOrFail(1);

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


    function show($id){
        $employer = Employer::findOrFail($id);
        return response()->json($employer,200);
    }

    function destroy($id){
        $employer = Employer::findOrFail($id);
        $employer->delete();
        return response()->json(null,204);

    }
}
