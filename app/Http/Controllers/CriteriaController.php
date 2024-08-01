<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criteria = Criteria::all();
        return view('criteria.list', compact('criteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('criteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Criteria::insert([
            'name' => $request->name,
            'weight' => $request->weight,
            'type' => $request->type,
        ]);

        return redirect()->route('criteria.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $criteria = Criteria::findOrFail($id);
        return view('criteria.edit', compact('criteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $criteria = Criteria::find($id);
        $criteria->name = $request->name;
        $criteria->weight = $request->weight;
        $criteria->type = $request->type;
        $criteria->save();

        return redirect()->route('criteria.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $criteria = Criteria::findOrFail($id);
        $criteria->alternates()->delete();
        $criteria->finals()->delete();
        $criteria->delete();

        return redirect()->route('criteria.index');
    }

    public function sync()
    {
        $criteria = Criteria::all();

        foreach ($criteria as $value) {
            $criteriaFind = Criteria::find($value['id']);
            $sum = collect($criteria)->sum('weight');
            $criteriaFind->normal_weight = $value->type == 'benefit' ? round($value->weight / $sum, 2) * 1 : round($value->weight / $sum, 2) * -1;
            $criteriaFind->save();
        }

        return redirect()->route('criteria.index');
    }
}
