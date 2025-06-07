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
        $employer = Employer::create([
            'user_id' => $request->user_id,
            'company_name'=>$request->company_name,
            'description'=>$request->description ,
            'industry'=>$request->industry,
            'logo_url'=>$request->logo_url,
            'company_size'=>$request->company_size,
            'established_date'=>$request->established_date,

        ]);
        return response()->json($employer,201);
    }

    function update(Request $request,$id)
    {
        $employer = Employer::findOrFail($id);
        $employer->update(
            $request->only('company_name', 'description', 'industry', 'logo_url', 'company_size', 'established_date')
        );

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
