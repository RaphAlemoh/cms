<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController
{
    use ApiResponser;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $service = Service::create([
            'name' => $request->name,
            'company_id' => $request->company_id,
        ]);

        return $this->showOne($service, 200);

    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $service->update([
            'name' => $request->name,
        ]);

        return $this->showOne($service, 200);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return $this->showOne('Service deleted successfully', 200);
    }
}
