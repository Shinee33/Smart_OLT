<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'dyinggasp') {
                $query->whereIn('status', ['dyinggasp', 'dying']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('olt_id', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'timestamp');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $pelanggan = $query->paginate(20)->withQueryString();

        // Statistik
        $stats = [
            'total' => Pelanggan::count(),
            'online' => Pelanggan::where('status', 'online')->count(),
            'los' => Pelanggan::whereIn('status', ['los', 'offline'])->count(),
            'dyinggasp' => Pelanggan::whereIn('status', ['dyinggasp', 'dying'])->count(),
        ];

        return view('pelanggan.index', compact('pelanggan', 'stats'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:pelanggan,serial_number',
            'olt_id' => 'nullable|string',
            'board' => 'nullable|integer',
            'pon' => 'nullable|integer',
            'onu_id' => 'nullable|integer',
            'onu_type' => 'nullable|string',
            'rx_power' => 'nullable|numeric',
            'tx_power' => 'nullable|numeric',
            'status' => 'required|in:online,offline,los,dyinggasp,dying,unknown',
            'gpon_optical_distance' => 'nullable|integer',
            'offline_reason' => 'nullable|string',
            'description' => 'nullable|string',
            'ip_address' => 'nullable|string',
            'health' => 'nullable|string',
        ]);

        // Set last_online atau last_offline berdasarkan status
        if ($validated['status'] === 'online') {
            $validated['last_online'] = now();
        } else {
            $validated['last_offline'] = now();
        }

        // Set timestamp
        $validated['timestamp'] = now();

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:pelanggan,serial_number,' . $pelanggan->id,
            'olt_id' => 'nullable|string',
            'board' => 'nullable|integer',
            'pon' => 'nullable|integer',
            'onu_id' => 'nullable|integer',
            'onu_type' => 'nullable|string',
            'rx_power' => 'nullable|numeric',
            'tx_power' => 'nullable|numeric',
            'status' => 'required|in:online,offline,los,dyinggasp,dying,unknown',
            'gpon_optical_distance' => 'nullable|integer',
            'offline_reason' => 'nullable|string',
            'uptime' => 'nullable|string',
            'description' => 'nullable|string',
            'ip_address' => 'nullable|string',
            'health' => 'nullable|string',
        ]);

        // Update last_online/last_offline jika status berubah
        if ($pelanggan->status !== $validated['status']) {
            if ($validated['status'] === 'online') {
                $validated['last_online'] = now();
            } else {
                $validated['last_offline'] = now();
            }
        }

        // Update timestamp
        $validated['timestamp'] = now();

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diupdate');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus');
    }
}