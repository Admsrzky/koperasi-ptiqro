<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Peminjaman;
use App\Models\Penggajian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards Data
        $totalAnggota = Karyawan::count();
        $totalGajiKaryawan = Karyawan::sum('gaji_pokok') + Karyawan::sum('tunjangan');
        $totalPinjaman = Peminjaman::whereIn('status', ['disetujui', 'dicairkan'])->sum('jumlah_pinjaman');
        $totalKeuntungan = Penggajian::sum('bonus');

        // Perubahan Bulanan
        $lastMonthAnggota = Karyawan::where('created_at', '>=', now()->subMonth())->count();
        $lastMonthPinjaman = Peminjaman::whereIn('status', ['disetujui', 'dicairkan'])
            ->where('created_at', '>=', now()->subMonth())->sum('jumlah_pinjaman');
        $lastMonthKeuntungan = Penggajian::where('created_at', '>=', now()->subMonth())->sum('bonus');

        $anggotaChange = $totalAnggota > 0 ? round(($lastMonthAnggota / $totalAnggota) * 100, 2) : 0;
        $pinjamanChange = $totalPinjaman > 0 ? round(($lastMonthPinjaman / $totalPinjaman) * 100, 2) : 0;
        $keuntunganChange = $totalKeuntungan > 0 ? round(($lastMonthKeuntungan / $totalKeuntungan) * 100, 2) : 0;

        // Recent Activities (Peminjaman dan Penggajian)
        $peminjaman = Peminjaman::with('karyawan')
            ->select('id', 'karyawan_id', 'jumlah_pinjaman', 'status', 'created_at', DB::raw('"peminjaman" as type'))
            ->whereIn('status', ['pengajuan', 'disetujui', 'dicairkan'])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'karyawan_nama' => $item->karyawan->nama,
                    'status' => $item->status,
                    'jumlah' => $item->jumlah_pinjaman,
                    'created_at' => $item->created_at,
                ];
            });

        $penggajian = Penggajian::with('karyawan')
            ->select('id', 'karyawan_id', 'total_gaji', 'status', 'created_at', DB::raw('"penggajian" as type'))
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'karyawan_nama' => $item->karyawan->nama,
                    'status' => $item->status,
                    'jumlah' => $item->total_gaji,
                    'created_at' => $item->created_at,
                ];
            });

        $recentActivities = $peminjaman->merge($penggajian)
            ->sortByDesc('created_at')
            ->take(4);

        // Top Members
        $topMembers = Karyawan::with('penggajian')->orderBy('gaji_pokok', 'desc')->take(4)->get();

        return view('dashboard', compact(
            'totalAnggota',
            'totalGajiKaryawan',
            'totalPinjaman',
            'totalKeuntungan',
            'anggotaChange',
            'pinjamanChange',
            'keuntunganChange',
            'recentActivities',
            'topMembers'
        ));
    }

    public function revenueData(Request $request)
    {
        $period = $request->query('period', '6months');
        $months = $period === '1year' ? 12 : 6;

        $data = Peminjaman::selectRaw('DATE_FORMAT(tanggal_pengajuan, "%Y-%m") as month, SUM(jumlah_pinjaman) as total')
            ->whereIn('status', ['disetujui', 'dicairkan'])
            ->where('tanggal_pengajuan', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Generate all months in the period to ensure no gaps in the chart
        $labels = [];
        $totals = [];
        $currentDate = now()->subMonths($months);
        for ($i = 0; $i < $months; $i++) {
            $month = $currentDate->format('Y-m');
            $labels[] = $month;
            $totals[] = $data->where('month', $month)->first()->total ?? 0;
            $currentDate->addMonth();
        }

        return response()->json([
            'labels' => $labels,
            'data' => $totals
        ]);
    }

    public function memberGrowthData(Request $request)
    {
        $period = $request->query('period', '6months');
        $months = $period === '1year' ? 12 : 6;

        $data = Karyawan::selectRaw('DATE_FORMAT(tanggal_masuk, "%Y-%m") as month, COUNT(*) as total')
            ->where('tanggal_masuk', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Generate all months in the period to ensure no gaps in the chart
        $labels = [];
        $totals = [];
        $currentDate = now()->subMonths($months);
        for ($i = 0; $i < $months; $i++) {
            $month = $currentDate->format('Y-m');
            $labels[] = $month;
            $totals[] = $data->where('month', $month)->first()->total ?? 0;
            $currentDate->addMonth();
        }

        return response()->json([
            'labels' => $labels,
            'data' => $totals
        ]);
    }
}