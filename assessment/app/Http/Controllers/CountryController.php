<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CountryController
{
    use ApiResponser;

    public function index()
    {
        $countries = Country::select('id', 'name')->get();
        return $this->showOne($countries, 200);

        return response()->json($countries);
    }
}
