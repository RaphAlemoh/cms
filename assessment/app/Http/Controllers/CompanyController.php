<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController
{
    use ApiResponser;

    public function index(Request $request)
    {
        $companies =  $request->user()->companies()->with('services')->get();
        return $this->showOne($companies, 200);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:companies',
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $company = $request->user()->companies()->create([
            'name' => $request->name,
            'email' => $request->email,
            'country_id' => $request->country_id,
        ]);

        return $this->showOne($company, 200);
    }

    public function show($id)
    {
        $company = Company::with('services')->findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:companies,email,' . $company->id,
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'country_id' => $request->country_id,
        ]);

        return $this->showOne($company, 200);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        $company->delete();

        return $this->showOne('Company deleted successfully', 200);
    }
}
