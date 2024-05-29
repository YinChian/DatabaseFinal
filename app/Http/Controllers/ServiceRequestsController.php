<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestsRequest;
use App\Models\ServiceRequests;

class ServiceRequestsController extends Controller
{
    public function index()
    {
        $requests = ServiceRequests::all();
        return response()->json($requests);
    }

    public function store (ServiceRequestsRequest $request)
    {
        $request = ServiceRequests::create($request->all());
        return response()->json($request, 201);
    }

    public function show ($id)
    {
        $request = ServiceRequests::find($id);

        return response()->json($request);
    }

    public function update(ServiceRequestsRequest $request, $id)
    {
        $request = ServiceRequests::findOrFail($id);
        $request->update($request->all());

        return response()->json($request);
    }

    public function destroy ($id)
    {
        ServiceRequests::find($id)->delete();

        return response()->json(null, 204);
    }
}
