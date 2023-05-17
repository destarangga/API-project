<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $search = $request->search_nama;

        $limit = $request->limit;

        $rentals = Rental::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();

        if ($rentals) {
            return ApiFormatter::createApi(200, 'success', $rentals);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nis' => 'required|min:8',
                'nama' => 'required|min:3',
                'keperluan' => 'required',
                'tgl' => 'required',
                'jumlah' => 'required',
            ]);
            
            $rental = Rental::create([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'keperluan' => $request->keperluan,
                'tgl' => \Carbon\Carbon::parse($request->tgl)->format('Y-m-d'),
                'jumlah' => $request->jumlah,
            ]);

            $getDataSaved = Rental::where('id', $rental->id)->first();

            if ($getDataSaved){
                return ApiFormatter::createApi(200, 'success', $getDataSaved);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $eror) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $rentalDetail = Rental::where('id', $id)->first();

            if ($rentalDetail){
                return ApiFormatter::createApi(200, 'success', $rentalDetail);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $eror) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nis' => 'required|min:8',
                'nama' => 'required|min:3',
                'keperluan' => 'required',
                'tgl' => 'required',
                'jumlah' => 'required',
            ]);

            $rental = Rental::findOrFail($id);
            
            $rental->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'keperluan' => $request->keperluan,
                'tgl' => $request->tgl,
                'jumlah' => $request->jumlah,
            ]);

            $updatedRental = Rental::where('id', $rental->id)->first();

            if ($updatedRental){
                return ApiFormatter::createApi(200, 'success', $updatedRental);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $eror) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $rental = Rental::findOrFail($id);
            $proses = $rental->delete();

            if ($proses){
                return ApiFormatter::createApi(200, 'delete success',);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $eror) {
            return ApiFormatter::createApi(400, 'failed');

        }
    }

    public function trash(){
        try {
            $rentals = Rental::onlyTrashed()->get();

            if ($rentals){
                return ApiFormatter::createApi(200, 'success', $rentals);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $eror) {
            return ApiFormatter::createApi(400, 'eror', $eror->getMessage());
        }
    }

    public function restore ($id) {
        try{
            $rental = Rental::onlyTrashed()->where('id', $id);
            $rental->restore();
            $dataRestore = Rental::where('id', $id)->first();
            
            if ($dataRestore){
                return ApiFormatter::createApi(200, 'success', $dataRestore);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $eror) {
            return ApiFormatter::createApi(400, 'eror', $eror->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            $rental = Rental::onlyTrashed()->where('id', $id);
            $proses = $rental->forceDelete();

            if ($proses){
                return ApiFormatter::createApi(200, 'success', 'Data Terhapus Permanen');
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $eror) {
            return ApiFormatter::createApi(400, 'eror', $eror->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }
}
