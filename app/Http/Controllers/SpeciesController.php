<?php

namespace App\Http\Controllers;

use App\Clinic;
use App\Species;
use Illuminate\Http\Request;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Clinic $clinic)
    {
        $species = Species::where('clinic_id', '=', $clinic->id)->get();
        // $species = Species::leftJoin('lives', 'species.tsn', '=', 'lives.tsn')->get();
        // $clinic = Clinic::findOrFail($clinic_id);
        return view('species.index')->with('clinic', $clinic)->with('species', $species);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Clinic $clinic)
    {
        $request->validate([
            'tsn' => 'required',
            'familiar_name' => 'required|max:255',
        ]);

        $species = new Species();
        $species->tsn = $request->tsn;
        $species->clinic_id = $clinic->id;
        $species->familiar_name = $request->familiar_name;

        try {
            $species->save();
            return redirect()->route('clinics.species.index', $clinic)->with('success', __('message.specie_create_success'));
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('clinics.species.index', $clinic)->with('error', __('message.specie_create_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function show(Clinic $clinic, Species $species)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function edit(Species $species)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clinic $clinic, Species $species)
    {
        // validate
        $request->validate([
            'familiar_name' => 'required|max:255',
        ]);

        // $clinic = Clinic::find($clinic_id);
        // $specie = Specie::find($specie_id);


        $species->familiar_name = $request->familiar_name;

        $species->save();
        try {
            return redirect()->route('clinics.species.index', $clinic)->with('success', __('message.specie_edit_success'));
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('clinics.species.index', $clinic)->with('error', __('message.specie_edit_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Species $species)
    {
        //
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, Species $species)
    {
        $response = array(
            "id" => $species->id,
            "tsn" => $species->tsn,
            "complete_name" => $species->life()->first()->complete_name,
            "familiar_name" => $species->familiar_name
        );

        echo json_encode($response);
        exit;
    }
}