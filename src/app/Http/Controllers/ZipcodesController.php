<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zipcodes;

class ZipcodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "OK";
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zipcodes  $zipcodes
     * @return \Illuminate\Http\Response
     */
    public function show(Zipcodes $zipcodes,$id)
    {
        $zipData=$zipcodes->where('zip_code','=',$id."")->first();
        if($zipData){
            return response()->json($zipData);
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zipcodes  $zipcodes
     * @return \Illuminate\Http\Response
     */
    public function edit(Zipcodes $zipcodes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zipcodes  $zipcodes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zipcodes $zipcodes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zipcodes  $zipcodes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zipcodes $zipcodes)
    {
        //
    }

    public function headFile($path,$rows=1){
        $fileObject = new \SplFileObject($path);

        //if(!is_file($path)) return false;

        $lines = '';
        for ($i = 0; $i < $rows && $fileObject->valid(); ++$i) {
            $lines .= $fileObject->current();
            $fileObject->next();
        }

        return $lines;
    }
}
