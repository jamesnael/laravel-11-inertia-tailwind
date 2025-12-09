<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProvinceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function city(Request $request)
  {
    $data = Province::where('name', $request->province)->orderBy('city', 'ASC')->distinct('city')->pluck('city');

    return response_json(true, null, 'Data retrieved.', $data);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function district(Request $request)
  {
    $data = Province::where('name', $request->province)->where('city', $request->city)->orderBy('district', 'ASC')->distinct('district')->pluck('district');

    return response_json(true, null, 'Data retrieved.', $data);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function subdistrict(Request $request)
  {
    $data = Province::where('name', $request->province)->where('city', $request->city)->where('district', $request->district)->orderBy('subdistrict', 'ASC')->select('subdistrict AS value', 'post AS postal_code')->get();

    return response_json(true, null, 'Data retrieved.', $data);
  }
}
