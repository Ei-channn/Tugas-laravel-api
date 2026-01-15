<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    public function index() {
        return response()->json(Item::all());
    }

    public function store(Request $request) {
        $validator = validator::make($request->all(), [
            'kode' => 'required|string',
            'nama_barang' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 442);
        };

        $item = Item::create($request->all());

        return new ItemResource($item, true, 'Data Item Berhasil Diterima');
    }

    public function show($id){
        $item = Item::find($id);

        return new ItemResource($item, true, 'Data Item Berhasil Ditampilkan');
    }

    public function update(Request $request, $id){
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return new ItemResource($item, true, 'Data Item Berhasil Diupdate');
    }

    public function destroy($id) {

        $item = Item::findOrFail($id);

        if (is_null($item)) {
            return response()->json(['message' => 'Data Transaksi Tidak Diterima'], 404);
        }

        $item->delete();

        return new ItemResource($item, true, 'Data Item Berhasil Dihapus');
    }

}
