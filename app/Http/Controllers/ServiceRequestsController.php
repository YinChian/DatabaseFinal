<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestsRequest;
use App\Models\ServiceRequests;
use App\Models\CustomerInteractions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceRequestsController extends Controller
{
    public function index()
    {
        $service_requests = ServiceRequests::all();
        // $customer_interactions = CustomerInteractions::all();

        // return response()->json("Service Requests: $service_requests, Customer Interactions: $customer_interactions");

        return response()->json($service_requests);
    }

    public function store (Request $request)
    {
        DB::beginTransaction();
        try{
            $serviceRequests = ServiceRequests::create([
                'CustomerID' => $request->CustomerID,
                'ProductID' => $request->ProductID,
                'IssueDescription' => $request->IssueDescription,
                'ResolutionDate' => null,
                'Status' => "Pending",
            ]);

            DB::commit();
            return response()->json(['success' => true, 'ServiceRequests_id' => $serviceRequests->id], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the service request.'], 500);
        }
    }

    public function show ($id)
    {
        // $request = ServiceRequests::find($id);
        $request = ServiceRequests::where('CustomerID', $id)->get();

        return response()->json($request);
    }

    public function update(Request $request, $id)
    {
        $service_requests = ServiceRequests::findOrFail($id);
        DB::beginTransaction();
        try {
            $service_requests->update([
                // 'CustomerID' => $request->CustermerID,
                // 'ProductID' => $request->ProductID,
                // 'IssueDescription' => $request->IssueDescription,
                'ResolutionDate' => $request->ResolutionDate,
                'Status' => $request->Status,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'ServiceRequests_id' => $service_requests->id], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the service request.'], 500);
        }
    }

    public function destroy ($id)
    {
        ServiceRequests::find($id)->delete();

        return response()->json(['success' => true,
                                'deleted_id' => $id], 200);
    }
}
