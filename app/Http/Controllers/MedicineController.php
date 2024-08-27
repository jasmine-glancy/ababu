<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of medicines available based on the country.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, Clinic $clinic)
    {
        $search = $request->search;

        if ($search == '') {
            $medicines = Medicine::where('country_id', '=', $clinic->country_id)->orderby('name', 'asc')->select('id', 'name')->limit(5)->get();
        } else {
            $medicines = Medicine::where('country_id', '=', $clinic->country_id)->orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($medicines as $medicine) {
            $response[] = array(
                "id" => $medicine->id,
                "text" => $medicine->name
            );
        }

        echo json_encode(["results" => $response]);

        exit;
    }
}
