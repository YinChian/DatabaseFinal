<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerInteractionsRequest;
use App\Models\CustomerInteractions;

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

        return response()->json($interaction, 201);
    }

    public function show ($id)
    {
        $interaction = CustomerInteractions::find($id);
        return response()->json($interaction);
    }

    public function update (CustomerInteractionsRequest $request, $id)
    {
        $interaction = CustomerInteractions::findOrFail($id);
        $interaction->update($request->all());

        return response()->json($interaction);
    }

    public function destroy ($id)
    {
        CustomerInteractions::find($id)->delete();

        return response()->json(null, 204);
    }
}
