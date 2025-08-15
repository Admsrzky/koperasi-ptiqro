<?php 



// app/Http/Controllers/PeminjamanController.php
namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('karyawan')->orderBy('created_at', 'desc')->paginate(10);
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $karyawan = Karyawan::where('status', 'aktif')->get();
        return view('peminjaman.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'jumlah_pinjaman' => 'required|numeric|min:500000|max:1000000',
            'keperluan' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'file_pengajuan' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        // Validasi batas waktu pengajuan (10-13 tanggal)
        $tanggal = Carbon::parse($request->tanggal_pengajuan)->day;
        if ($tanggal < 10 || $tanggal > 13) {
            return back()->withErrors(['tanggal_pengajuan' => 'Pengajuan hanya dapat dilakukan pada tanggal 10-13']);
        }

        $data = $request->all();
        $data['nomor_pengajuan'] = Peminjaman::generateNomorPengajuan();

        if ($request->hasFile('file_pengajuan')) {
            $data['file_pengajuan'] = $request->file('file_pengajuan')->store('pengajuan', 'public');
        }

        Peminjaman::create($data);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil disubmit');
    }

    public function show(Peminjaman $peminjaman)
    {
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function approve(Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'status' => 'disetujui',
            'tanggal_cair' => $peminjaman->tanggal_cair_otomatis
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil disetujui');
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditolak');
    }

    public function disburse(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dicairkan']);
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicairkan');
    }

    public function printPengajuan(Peminjaman $peminjaman)
    {
        return view('peminjaman.print', compact('peminjaman'));
    }

    // public function reportPeminjam()
    // {
    //     $peminjam = Karyawan::whereHas('peminjaman', function($query) {
    //         $query->whereIn('status', ['disetujui', 'dicairkan']);
    //     })->with(['peminjaman' => function($query) {
    //         $query->whereIn('status', ['disetujui', 'dicairkan']);
    //     }])->get();

    //     return view('peminjaman.report', compact('peminjam'));
    // }



     public function reportPeminjam(Request $request)
    {
        $search = $request->input('search');

        $peminjam = Karyawan::whereHas('peminjaman', function ($query) {
            $query->whereIn('status', ['disetujui', 'dicairkan']);
        })
            ->with([
                'peminjaman' => function ($query) {
                    $query->whereIn('status', ['disetujui', 'dicairkan']);
                }
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('nip', 'like', '%' . $search . '%')
                        ->orWhereHas('peminjaman', function ($q) use ($search) {
                            $q->where('jumlah_pinjaman', 'like', '%' . $search . '%');
                        });
                });
            })
            ->get();

        return view('peminjaman.report', compact('peminjam'));
    }
}