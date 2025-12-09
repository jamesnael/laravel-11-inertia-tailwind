<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BeritaViewsExport;
use App\Http\Controllers\Controller;
use App\Models\BeritaViews;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
  /**
   *
   * Initiate controller instance
   *
   */
  function __construct()
  {
    $this->breadcrumbs = [
      [
        'text' => 'Dashboard',
        'route' => route('admin.dashboard.index')
      ]
    ];
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Inertia::render('Admin/Dashboard', [
      'breadcrumbs'      => $this->breadcrumbs,
    ]);
  }

  public function getChartData(Request $request)
  {
    $bulan = $request->query('bulan', \Carbon\Carbon::now()->month);
    $tahun = \Carbon\Carbon::now()->year;

    // Tanggal awal dan akhir bulan yang dipilih
    $startOfMonth = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
    $endOfMonth   = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->toDateString();

    // Ambil data view per hari
    $viewsPerDay = BeritaViews::select(
      DB::raw('DAY(created_at) as hari'),
      DB::raw('COUNT(*) as jumlah')
    )
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->groupBy('hari')
    ->orderBy('hari')
    ->get();

    // Buat label dan data lengkap
    $jumlahHari = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
    $labels     = [];
    $data       = [];

    for ($i = 1; $i <= $jumlahHari; $i++) {
      $labels[] = "Tgl " . $i;
      $data[]   = $viewsPerDay->firstWhere('hari', $i)->jumlah ?? 0;
    }

    // Nama bulan dalam Bahasa Indonesia (jika di-set lokal)
    $namaBulan = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

    // Kirim JSON ke frontend
    return response()->json([
      'labels'    => $labels,
      'data'      => $data,
      'namaBulan' => $namaBulan,
    ]);
  }
}
