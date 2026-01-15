<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\InvoiceResource; 

class InvoiceController extends Controller
{

    public function index() {
        $invoice = Invoice::with('items')->get();

        return new InvoiceResource($invoice, true, 'Data Invoice Berhasil Ditampilkan');
    }

    public function store(Request $request){

        $validator = validator::make($request->all(), [
            'no_nota' => 'required|string',
            'tanggal' => 'required|date',
            'total_harga' => 'required|numeric',
            'items' => 'required|array',
            'items.*.kode' => 'required|exists:items,kode',
            'items.*.jumlah' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 442);
        };

        $invoice = Invoice::create([
            'no_nota' => $request->no_nota,
            'tanggal' => $request->tanggal,
            'total_harga' => $request->total_harga,
        ]);

        foreach ($request->items as $item ) {
            $itemData = Item::where('kode', $item['kode'])->firstOrFail();
            $invoice->items()->attach($itemData->id, [
                'jumlah' => $item['jumlah'],
                'total_harga' => $itemData->harga * $item['jumlah'],
            ]);
        }
    
        return new InvoiceResource($invoice, true, 'Data Invoice Berhasil Diterima');
    }

    public function show($id) {
        $invoice = Invoice::with('items')->findOrFail($id);

        if (is_null($invoice)) {
            return response()->json(['message' => 'Data Invoice Tidak Diterima']);
        }
        
        return new InvoiceResource($invoice, true, 'Data Invoice Berhasil Ditampilkan');
    }
}
