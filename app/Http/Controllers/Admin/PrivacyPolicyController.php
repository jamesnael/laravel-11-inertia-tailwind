<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Exception;

class PrivacyPolicyController extends Controller
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
                'text' => 'Privacy Policy',
                'route' => route('admin.privacy-policy.index')
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
        $policy = PrivacyPolicy::find(1);

        return Inertia::render('Admin/DataMaster/PrivacyPolicy/Index', [
            'breadcrumbs' => $this->breadcrumbs,
            'policy'      => $policy
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrivacyPolicy $policy
     * @return \Illuminate\Http\Response
     */
    public function edit(PrivacyPolicy $policy)
    {
        $this->breadcrumbs[] = [
            'text' => 'Edit Privacy Policy',
            'route' => route('admin.privacy-policy.edit', [$policy->id])
        ];

        return Inertia::render('Admin/DataMaster/PrivacyPolicy/Edit', [
            'breadcrumbs'    => $this->breadcrumbs,
            'policy' => $policy
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrivacyPolicy  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrivacyPolicy $policy)
    {
        $request->validate($this->validationRules($policy));

        DB::beginTransaction();
        try {
            $policy->update($request->all());

            $policy->save();

            log_activity(
                'Edit Data Privacy Policy ' . $policy->id,
                $policy
            );

            DB::commit();
            return redirect()->route('admin.privacy-policy.index')->with('alertState', 'success')->with('alertMessage', 'Privacy Policy successfully updated.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validationRules($policy = null)
    {
        return [
            'title'   => 'required',
            'content' => 'required',
        ];
    }
}