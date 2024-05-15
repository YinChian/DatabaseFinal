<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestsRequest;
use App\Models\ServiceRequests;

class ServiceRequestsController extends Controller
{
    public function index()
    {
        return ServiceRequests::all();
    }

    public function store(ServiceRequestsRequest $request)
    {
        return ServiceRequests::create($request->validated());
    }

    public function show(ServiceRequests $serviceRequests)
    {
        return $serviceRequests;
    }

    public function update(ServiceRequestsRequest $request, ServiceRequests $serviceRequests)
    {
        $serviceRequests->update($request->validated());

        return $serviceRequests;
    }

    public function destroy(ServiceRequests $serviceRequests)
    {
        $serviceRequests->delete();

        return response()->json();
    }
}
