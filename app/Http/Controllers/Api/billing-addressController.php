<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillingRequest;
use App\Models\Company;
use App\Models\billingaddress;

class billingaddressController extends Controller
{
    private Company $company;
    private billingaddress $billing;

    public function __construct(
        Company $company,
        CompanyBilling $billing
    ) {
        $this->company = $company;
        $this->billing = $billing;
    }

    public function store(BillingRequest $request, int $id)
    {
        $params = $request->validated();
        $company = $this->company->findOrFail($id);

        $company->billing()->create($params);
        return $company->load('billing');
    }

    public function show($id)
    {
        $billing = $this->billing->findOrFail($id);

        return $billing;
    }


    public function update(BillingRequest $request, int $id)
    {
        $params = $request->validated();
        $billing = $this->billing->findOrFail($id);

        $billing->update($params);

        return $billing;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        $this->billing->findOrFail($id)->delete();
        return ['message' => 'success'];
    }
}