<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->input('date', date('Y-m-d'));
        $isToday = $selectedDate === date('Y-m-d');
        
        // Inisialisasi variabel
        $todayAdded = 0;
        $todayDeleted = 0;
        $totalData = 0;
        $online = 0;
        $dyinggasp = 0;
        $offline = 0;
        $onlineStats = [];
        $dyinggaspStats = [];
        $losStats = [];
        $timeRangeStart = '';
        $timeRangeEnd = '';

        try {
            $dateStart = Carbon::parse($selectedDate)->startOfDay();
            $dateEnd = Carbon::parse($selectedDate)->endOfDay();

            // ===============================
            // CARD STATISTICS
            // ===============================
            if (DB::getSchemaBuilder()->hasTable('pelanggan')) {
                
                if ($isToday) {
                    // MODE REAL-TIME: Ambil status saat ini
                    $totalData = Pelanggan::count();
                    $online = Pelanggan::where('status', 'online')->count();
                    $dyinggasp = Pelanggan::whereIn('status', ['dyinggasp', 'dying gasp', 'dying'])->count();
                    $offline = Pelanggan::whereIn('status', ['offline', 'los'])->count();
                    
                } else {
                    // MODE HISTORIS: Ambil data snapshot dari tanggal yang dipilih
                    // Ambil total pelanggan yang ada pada tanggal tersebut (created_at <= dateEnd)
                    $totalData = Pelanggan::where('created_at', '<=', $dateEnd)->count();
                    
                    // Ambil statistik berdasarkan updated_at pada tanggal yang dipilih
                    // Untuk mendapatkan "snapshot" status pada akhir hari
                    $online = Pelanggan::where('status', 'online')
                        ->where('updated_at', '<=', $dateEnd)
                        ->where(function($query) use ($dateStart) {
                            $query->where('updated_at', '>=', $dateStart)
                                  ->orWhere('created_at', '>=', $dateStart);
                        })
                        ->count();
                    
                    $dyinggasp = Pelanggan::whereIn('status', ['dyinggasp', 'dying gasp', 'dying'])
                        ->where('updated_at', '<=', $dateEnd)
                        ->where(function($query) use ($dateStart) {
                            $query->where('updated_at', '>=', $dateStart)
                                  ->orWhere('created_at', '>=', $dateStart);
                        })
                        ->count();
                    
                    $offline = Pelanggan::whereIn('status', ['offline', 'los'])
                        ->where('updated_at', '<=', $dateEnd)
                        ->where(function($query) use ($dateStart) {
                            $query->where('updated_at', '>=', $dateStart)
                                  ->orWhere('created_at', '>=', $dateStart);
                        })
                        ->count();
                }
                
                // Pelanggan yang ditambahkan pada tanggal yang dipilih
                $todayAdded = Pelanggan::whereBetween('created_at', [$dateStart, $dateEnd])->count();
                
                // Pelanggan yang offline pada tanggal yang dipilih
                $todayDeleted = Pelanggan::whereBetween('updated_at', [$dateStart, $dateEnd])
                    ->whereIn('status', ['offline', 'los', 'dyinggasp', 'dying gasp', 'dying'])
                    ->count();
            }

            // ===============================
            // GRAFIK STATISTICS
            // ===============================
            if ($isToday) {
                // MODE REAL-TIME: Per 3 menit, 1 jam terakhir (20 interval)
                $intervalsToShow = 20;
                $intervalMinutes = 3;

                for ($i = $intervalsToShow - 1; $i >= 0; $i--) {
                    $intervalStart = Carbon::now()->subMinutes($i * $intervalMinutes);
                    
                    // Untuk mode real-time, ambil data saat ini (tidak berubah per interval)
                    $onlineCount = Pelanggan::where('status', 'online')->count();
                    $dyinggaspCount = Pelanggan::whereIn('status', ['dyinggasp', 'dying gasp', 'dying'])->count();
                    $losCount = Pelanggan::whereIn('status', ['los', 'offline'])->count();

                    $timeLabel = $intervalStart->format('H:i');

                    $onlineStats[] = ['period' => $timeLabel, 'count' => $onlineCount];
                    $dyinggaspStats[] = ['period' => $timeLabel, 'count' => $dyinggaspCount];
                    $losStats[] = ['period' => $timeLabel, 'count' => $losCount];
                }

                $timeRangeStart = Carbon::now()->subHour()->format('H:i');
                $timeRangeEnd = Carbon::now()->format('H:i');

            } else {
                // MODE HISTORIS: Per jam, 24 jam penuh (24 interval)
                $intervalsToShow = 24;

                for ($hour = 0; $hour < $intervalsToShow; $hour++) {
                    $intervalStart = Carbon::parse($selectedDate)->startOfDay()->addHours($hour);
                    $intervalEnd = $intervalStart->copy()->addHour();

                    $onlineCount = 0;
                    $dyinggaspCount = 0;
                    $losCount = 0;

                    if (DB::getSchemaBuilder()->hasTable('pelanggan')) {
                        // Hitung pelanggan yang statusnya berubah/diupdate pada interval ini
                        $onlineCount = Pelanggan::where('status', 'online')
                            ->whereBetween('updated_at', [$intervalStart, $intervalEnd])
                            ->count();

                        $dyinggaspCount = Pelanggan::whereIn('status', ['dyinggasp', 'dying gasp', 'dying'])
                            ->whereBetween('updated_at', [$intervalStart, $intervalEnd])
                            ->count();

                        $losCount = Pelanggan::whereIn('status', ['los', 'offline'])
                            ->whereBetween('updated_at', [$intervalStart, $intervalEnd])
                            ->count();
                    }

                    $timeLabel = $intervalStart->format('H:00');

                    $onlineStats[] = ['period' => $timeLabel, 'count' => $onlineCount];
                    $dyinggaspStats[] = ['period' => $timeLabel, 'count' => $dyinggaspCount];
                    $losStats[] = ['period' => $timeLabel, 'count' => $losCount];
                }

                $timeRangeStart = '00:00';
                $timeRangeEnd = '23:59';
            }

        } catch (\Exception $e) {
            logger()->error('Dashboard data error: ' . $e->getMessage());
        }

        return view('pages.dashboard', compact(
            'todayAdded',
            'todayDeleted',
            'totalData',
            'online',
            'dyinggasp',
            'offline',
            'onlineStats',
            'dyinggaspStats',
            'losStats',
            'timeRangeStart',
            'timeRangeEnd'
        ));
    }

    // API endpoint untuk AJAX refresh (hanya untuk mode real-time)
    public function refreshData(Request $request)
    {
        try {
            $todayStart = Carbon::today();
            $todayEnd = Carbon::tomorrow();

            $data = [
                'totalData' => 0,
                'todayAdded' => 0,
                'todayDeleted' => 0,
                'online' => 0,
                'dyinggasp' => 0,
                'offline' => 0,
                'onlineStats' => [],
                'dyinggaspStats' => [],
                'losStats' => [],
                'lastUpdate' => now()->format('Y-m-d H:i:s')
            ];

            if (DB::getSchemaBuilder()->hasTable('pelanggan')) {
                $data['totalData'] = Pelanggan::count();
                $data['online'] = Pelanggan::where('status', 'online')->count();
                $data['dyinggasp'] = Pelanggan::whereIn('status', ['dyinggasp', 'dying gasp', 'dying'])->count();
                $data['offline'] = Pelanggan::whereIn('status', ['offline', 'los'])->count();
                
                $data['todayAdded'] = Pelanggan::whereBetween('created_at', [$todayStart, $todayEnd])->count();
                $data['todayDeleted'] = Pelanggan::whereBetween('updated_at', [$todayStart, $todayEnd])
                    ->whereIn('status', ['offline', 'los', 'dyinggasp', 'dying gasp', 'dying'])
                    ->count();

                // Ambil data 1 jam terakhir (20 interval x 3 menit)
                $intervalsToShow = 20;
                $intervalMinutes = 3;

                for ($i = $intervalsToShow - 1; $i >= 0; $i--) {
                    $intervalStart = Carbon::now()->subMinutes($i * $intervalMinutes);
                    
                    // Hitung status SAAT INI
                    $online = Pelanggan::where('status', 'online')->count();
                    $dyinggasp = Pelanggan::whereIn('status', ['dyinggasp', 'dying gasp', 'dying'])->count();
                    $los = Pelanggan::whereIn('status', ['los', 'offline'])->count();

                    $timeLabel = $intervalStart->format('H:i');

                    $data['onlineStats'][] = ['period' => $timeLabel, 'count' => $online];
                    $data['dyinggaspStats'][] = ['period' => $timeLabel, 'count' => $dyinggasp];
                    $data['losStats'][] = ['period' => $timeLabel, 'count' => $los];
                }
            }

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function analytics()
    {
        return view('pages.analytics');
    }

    public function fintech()
    {
        return view('pages.fintech');
    }
}