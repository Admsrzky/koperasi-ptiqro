<?php


// app/Http/Controllers/PenggajianController.php
namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Karyawan;
use App\Models\Peminjaman;
use App\Models\DetailPotonganPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = Penggajian::with('karyawan')->orderBy('periode', 'desc')->paginate(10);
        return view('penggajian.index', compact('penggajian'));
    }

    public function create()
    {
        $karyawan = Karyawan::where('status', 'aktif')->get();
        $periode = date('Y-m');
        return view('penggajian.create', compact('karyawan', 'periode'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'periode' => 'required|string',
    //         'karyawan_ids' => 'required|array',
    //         'karyawan_ids.*' => 'exists:karyawan,id'
    //     ]);

    //     foreach ($request->karyawan_ids as $karyawanId) {
    //         $karyawan = Karyawan::find($karyawanId);

    //         // Cek apakah sudah ada penggajian untuk periode ini
    //         $existingPenggajian = Penggajian::where('karyawan_id', $karyawanId)
    //             ->where('periode', $request->periode)
    //             ->first();

    //         if ($existingPenggajian) {
    //             continue;
    //         }

    //         // Hitung potongan pinjaman
    //         $potonganPinjaman = $this->hitungPotonganPinjaman($karyawanId, $request->periode);

    //         $penggajian = Penggajian::create([
    //             'karyawan_id' => $karyawanId,
    //             'periode' => $request->periode,
    //             'gaji_pokok' => $karyawan->gaji_pokok,
    //             'tunjangan' => $karyawan->tunjangan,
    //             'lembur' => 0,
    //             'bonus' => 0,
    //             'potongan_pinjaman' => $potonganPinjaman['total'],
    //             'potongan_lain' => 0,
    //             'total_gaji' => 0
    //         ]);

    //         $penggajian->hitungTotalGaji();
    //         $penggajian->save();

    //         // Simpan detail potongan pinjaman
    //         foreach ($potonganPinjaman['detail'] as $detail) {
    //             DetailPotonganPinjaman::create([
    //                 'penggajian_id' => $penggajian->id,
    //                 'peminjaman_id' => $detail['peminjaman_id'],
    //                 'jumlah_potong' => $detail['jumlah_potong']
    //             ]);
    //         }
    //     }

    //     return redirect()->route('penggajian.index')->with('success', 'Penggajian berhasil dibuat');
    // }



    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'periode' => 'required|string',
    //         'karyawan_ids' => 'required|array',
    //         'karyawan_ids.*' => 'exists:karyawan,id',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         foreach ($request->karyawan_ids as $karyawanId) {
    //             $karyawan = Karyawan::findOrFail($karyawanId);

    //             // Check if payroll already exists for this employee and period
    //             if (Penggajian::where('karyawan_id', $karyawanId)->where('periode', $request->periode)->exists()) {
    //                 continue; // Skip if payroll already exists
    //             }

    //             // Initialize payroll data
    //             $penggajian = new Penggajian();
    //             $penggajian->karyawan_id = $karyawanId;
    //             $penggajian->periode = $request->periode;
    //             $penggajian->gaji_pokok = $karyawan->gaji_pokok ?? 0;
    //             $penggajian->tunjangan = $karyawan->tunjangan ?? 0;
    //             $penggajian->lembur = 0;
    //             $penggajian->bonus = 0;
    //             $penggajian->potongan_lain = 0;
    //             $penggajian->status = 'draft'; // Updated from 'pending' to match ENUM

    //             // Calculate loan deductions
    //             $activeLoans = Peminjaman::where('karyawan_id', $karyawanId)
    //                 ->whereIn('status', ['disetujui', 'dicairkan'])
    //                 ->get();

    //             $totalPotonganPinjaman = 0;
    //             $detailPotonganRecords = [];

    //             foreach ($activeLoans as $loan) {
    //                 // Calculate remaining loan amount
    //                 $remainingLoan = $loan->jumlah_pinjaman - $loan->detailPotongan()->sum('jumlah_potong');
    //                 if ($remainingLoan <= 0) {
    //                     continue; // Skip fully paid loans
    //                 }

    //                 // Set deduction amount (e.g., fixed 100,000 or remaining loan, whichever is smaller)
    //                 $deductionAmount = min(100000, $remainingLoan);
    //                 $totalPotonganPinjaman += $deductionAmount;

    //                 // Store deduction details for later saving
    //                 $detailPotonganRecords[] = [
    //                     'peminjaman_id' => $loan->id,
    //                     'jumlah_potong' => $deductionAmount,
    //                 ];
    //             }

    //             // Set potongan_pinjaman and calculate total_gaji
    //             $penggajian->potongan_pinjaman = $totalPotonganPinjaman;
    //             $penggajian->hitungTotalGaji();

    //             // Validate total_gaji is not negative
    //             if ($penggajian->total_gaji < 0) {
    //                 throw new \Exception("Total gaji untuk karyawan ID {$karyawanId} menjadi negatif.");
    //             }

    //             // Save penggajian
    //             $penggajian->save();

    //             // Save detail potongan records
    //             foreach ($detailPotonganRecords as $detail) {
    //                 DetailPotonganPinjaman::create([
    //                     'penggajian_id' => $penggajian->id,
    //                     'peminjaman_id' => $detail['peminjaman_id'],
    //                     'jumlah_potong' => $detail['jumlah_potong'],
    //                 ]);
    //             }
    //         }

    //         DB::commit();

    //         return redirect()->route('penggajian.index')->with('success', 'Penggajian berhasil ditambahkan.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Gagal menambahkan penggajian: ' . $e->getMessage());
    //     }
    // }



    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'karyawan_ids' => 'required|array',
            'karyawan_ids.*' => 'exists:karyawan,id',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->karyawan_ids as $karyawanId) {
                $karyawan = Karyawan::findOrFail($karyawanId);

                // Check if payroll already exists for this employee and period
                if (Penggajian::where('karyawan_id', $karyawanId)->where('periode', $request->periode)->exists()) {
                    continue; // Skip if payroll already exists
                }

                // Initialize payroll data
                $penggajian = new Penggajian();
                $penggajian->karyawan_id = $karyawanId;
                $penggajian->periode = $request->periode;
                $penggajian->gaji_pokok = $karyawan->gaji_pokok ?? 0;
                $penggajian->tunjangan = $karyawan->tunjangan ?? 0;
                $penggajian->lembur = 0;
                $penggajian->bonus = 0;
                $penggajian->potongan_lain = 0;
                $penggajian->status = 'draft'; // Matches ENUM('draft', 'final')

                // Calculate loan deductions
                $activeLoans = Peminjaman::where('karyawan_id', $karyawanId)
                    ->whereIn('status', ['disetujui', 'dicairkan'])
                    ->get();

                $totalPotonganPinjaman = 0;
                $detailPotonganRecords = [];

                foreach ($activeLoans as $loan) {
                    // Calculate remaining loan amount
                    $remainingLoan = $loan->jumlah_pinjaman - $loan->detailPotongan()->sum('jumlah_potong');
                    if ($remainingLoan <= 0) {
                        continue; // Skip fully paid loans
                    }

                    // Deduct the full remaining loan amount
                    $deductionAmount = $remainingLoan;
                    $totalPotonganPinjaman += $deductionAmount;

                    // Store deduction details for later saving
                    $detailPotonganRecords[] = [
                        'peminjaman_id' => $loan->id,
                        'jumlah_potong' => $deductionAmount,
                    ];
                }

                // Set potongan_pinjaman and calculate total_gaji
                $penggajian->potongan_pinjaman = $totalPotonganPinjaman;
                $penggajian->hitungTotalGaji();

                // Validate total_gaji is not negative
                if ($penggajian->total_gaji < 0) {
                    throw new \Exception("Total gaji untuk karyawan ID {$karyawanId} menjadi negatif karena potongan pinjaman (Rp {$totalPotonganPinjaman}) melebihi gaji.");
                }

                // Save penggajian
                $penggajian->save();

                // Save detail potongan records and update loan status
                foreach ($detailPotonganRecords as $detail) {
                    DetailPotonganPinjaman::create([
                        'penggajian_id' => $penggajian->id,
                        'peminjaman_id' => $detail['peminjaman_id'],
                        'jumlah_potong' => $detail['jumlah_potong'],
                    ]);

                    // Update loan status to 'dicairkan' if fully paid
                    $loan = Peminjaman::find($detail['peminjaman_id']);
                    $remainingAfterDeduction = $loan->jumlah_pinjaman - $loan->detailPotongan()->sum('jumlah_potong');
                    if ($remainingAfterDeduction <= 0) {
                        $loan->status = 'dicairkan'; // Or consider a new status like 'lunas' (paid)
                        $loan->save();
                    }
                }
            }

            DB::commit();

            return redirect()->route('penggajian.index')->with('success', 'Penggajian berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan penggajian: ' . $e->getMessage());
        }
    }


    public function edit(Penggajian $penggajian)
    {
        return view('penggajian.edit', compact('penggajian'));
    }

    public function update(Request $request, Penggajian $penggajian)
    {
        $request->validate([
            'lembur' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'potongan_lain' => 'nullable|numeric|min:0'
        ]);

        $penggajian->update($request->only(['lembur', 'bonus', 'potongan_lain']));
        $penggajian->hitungTotalGaji();
        $penggajian->save();

        return redirect()->route('penggajian.index')->with('success', 'Penggajian berhasil diperbarui');
    }

    public function printSlip(Penggajian $penggajian)
    {
        return view('penggajian.slip', compact('penggajian'));
    }

    private function hitungPotonganPinjaman($karyawanId, $periode)
    {
        $pinjaman = Peminjaman::where('karyawan_id', $karyawanId)
            ->where('status', 'dicairkan')
            ->get();

        $totalPotongan = 0;
        $detailPotongan = [];

        foreach ($pinjaman as $pinjam) {
            // Logika sederhana: potong 200rb per bulan
            $jumlahPotong = min(200000, $pinjam->jumlah_pinjaman);
            $totalPotongan += $jumlahPotong;

            $detailPotongan[] = [
                'peminjaman_id' => $pinjam->id,
                'jumlah_potong' => $jumlahPotong
            ];
        }

        return [
            'total' => $totalPotongan,
            'detail' => $detailPotongan
        ];
    }
}