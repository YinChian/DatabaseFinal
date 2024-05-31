<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerInteractionsRequest;
use App\Models\CustomerInteractions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerInteractionsController extends Controller
{
    public function index ()
    {
        $interactions = CustomerInteractions::all();

        return response()->json($interactions);
    }

    public function store (CustomerInteractionsRequest $request)
    {
        $interaction = CustomerInteractions::create($request->all());

        return response()->json(['success' => true, 'CustomerInteractions_id' => $interaction->id], 200);
    }

    public function show ($id)
    {
        // $interaction = CustomerInteractions::find($id);
        $interaction = CustomerInteractions::where('CustomerID', $id)->get();
        return response()->json($interaction);
    }

    public function update (CustomerInteractionsRequest $request, $id)
    {
        $interaction = CustomerInteractions::findOrFail($id);
        $interaction->update($request->all());

        return response()->json(['success' => true,
                                'CustomerInteractions_id' => $interaction->id], 200);
    }

    public function destroy ($id)
    {
        CustomerInteractions::find($id)->delete();

        return response()->json(['success' => true], 200);
    }
}
