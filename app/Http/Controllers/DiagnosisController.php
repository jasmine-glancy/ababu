<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diagnosis;
class DiagnosisController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $diagnoses = Diagnosis::orderby('term_name', 'asc')->select('id', 'term_name')->limit(5)->get();
        } else {
            $diagnoses = Diagnosis::orderby('term_name', 'asc')->select('id', 'term_name')->where('term_name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($diagnoses as $diagnosis) {
            $response[] = array(
                "id" => $diagnosis->id,
                "text" => $diagnosis->term_name
            );
        }

        echo json_encode($response);
        exit;
    }
}
