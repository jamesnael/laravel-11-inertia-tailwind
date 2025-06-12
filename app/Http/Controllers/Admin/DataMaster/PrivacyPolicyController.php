<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                'text' => 'Master Data',
                'route' => route('admin.data-master.privacy-policy.index')
            ],
            [
                'text' => 'Privacy Policies',
                'route' => route('admin.data-master.privacy-policy.index')
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
        $privacy_policy = PrivacyPolicy::find(1);

        return Inertia::render('Admin/DataMaster/PrivacyPolicy/Index', [
            'breadcrumbs'    => $this->breadcrumbs,
            'privacy_policy' => $privacy_policy
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrivacyPolicy $privacy_policy
     * @return \Illuminate\Http\Response
     */
    public function edit(PrivacyPolicy $privacy_policy)
    {
        $this->breadcrumbs[] = [
            'text' => 'Edit Privacy Policy',
            'route' => route('admin.data-master.privacy-policy.edit', [$privacy_policy->id])
        ];

        return Inertia::render('Admin/DataMaster/PrivacyPolicy/Edit', [
            'breadcrumbs'    => $this->breadcrumbs,
            'privacy_policy' => $privacy_policy
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrivacyPolicy  $privacy_policy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrivacyPolicy $privacy_policy)
    {
        $request->validate($this->validationRules($privacy_policy));

        DB::beginTransaction();
        try {
            $privacy_policy->update($request->all());

            $privacy_policy->save();

            log_activity(
                'Edit Data Privacy Policy ' . $privacy_policy->id,
                $privacy_policy
            );

            DB::commit();
            return redirect()->route('admin.data-master.privacy-policy.index')->with('alertState', 'success')->with('alertMessage', 'Privacy Policy successfully updated.');
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
    public function validationRules($privacy_policy = null)
    {
        return [
            'content' => 'required',
        ];
    }
}
