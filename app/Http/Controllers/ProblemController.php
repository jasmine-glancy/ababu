<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Owner;
use App\Models\Pet;
use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Clinic $clinic, Owner $owner, Pet $pet, Problem $problem)
    {
        $request->validate([
            'description' => 'required',
            'status_id' => 'required',
            'active_from' => 'required',
        ]);

        $is_key_problem = $request->has('key_problem') ? true : false;

        $problem = new Problem([
            'diagnosis_id' => $request->diagnosis_id,
            'pet_id' => $pet->id,
            'user_id' => auth()->user()->id,
            'status_id' => $request->status_id,
            'active_from' => $request->active_from,
            'key_problem' => $is_key_problem,
            'description' => $request->description,
            'notes' => $request->notes,

        ]);

        if($problem->save()) {
            $request->session()->flash('success', __('message.record_store_success'));
        } else {
            $request->session()->flash('error', 'message.record_store_error');
        }

        return redirect()->route('clinics.owners.pets.show', [$clinic, $owner, $pet]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function show(Problem $problem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function edit(Problem $problem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Problem $problem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Problem $problem)
    {
        //
    }
}
