<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Log;
use OpenTelemetry\SDK\Trace\TracerProvider;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TracerProvider $tracerProvider)
    {
        $tracer = $tracerProvider->getTracer('laravel-app');
        $span = $tracer->spanBuilder('items.index')->startSpan();
        Log::info('Mengambil semua item');
        // Metrics sederhana: hitung jumlah item
        $count = Item::count();
        $span->setAttribute('items.count', $count);
        $items = Item::all();
        $span->end();
        return response()->json(['data' => $items, 'count' => $count]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TracerProvider $tracerProvider)
    {
        $tracer = $tracerProvider->getTracer('laravel-app');
        $span = $tracer->spanBuilder('items.store')->startSpan();
        Log::info('Membuat item baru', ['payload' => $request->all()]);
        $item = Item::create($request->all());
        $span->setAttribute('item.id', $item->id);
        $span->end();
        return response()->json(['data' => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id, TracerProvider $tracerProvider)
    {
        $tracer = $tracerProvider->getTracer('laravel-app');
        $span = $tracer->spanBuilder('items.show')->startSpan();
        $item = Item::findOrFail($id);
        Log::info('Menampilkan item', ['id' => $id]);
        $span->setAttribute('item.id', $id);
        $span->end();
        return response()->json(['data' => $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, TracerProvider $tracerProvider)
    {
        $tracer = $tracerProvider->getTracer('laravel-app');
        $span = $tracer->spanBuilder('items.update')->startSpan();
        $item = Item::findOrFail($id);
        $item->update($request->all());
        Log::info('Update item', ['id' => $id, 'payload' => $request->all()]);
        $span->setAttribute('item.id', $id);
        $span->end();
        return response()->json(['data' => $item]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, TracerProvider $tracerProvider)
    {
        $tracer = $tracerProvider->getTracer('laravel-app');
        $span = $tracer->spanBuilder('items.destroy')->startSpan();
        $item = Item::findOrFail($id);
        $item->delete();
        Log::info('Hapus item', ['id' => $id]);
        $span->setAttribute('item.id', $id);
        $span->end();
        return response()->json(['message' => 'Item deleted']);
    }
}
