<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\CompanyBilling;
use Tests\TestCase;

class billingaddressControllertest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function 会社請求先情報の登録の際にvalidationエラーになる()
    {
        $company = Company::factory()->create();
        $params = $this->params();
        $params['name'] = null;

        $res = $this->postJson(route('api.company.billing.create', $company->id), $params);

        $res->assertStatus(422);
    }

    /**
     * @test
     */
    public function 会社請求先情報の登録の際に会社が存在しない()
    {
        $company = Company::factory()->create();
        $params = $this->params();

        $res = $this->postJson(route('api.company.billing.create', $company->id + 1), $params);

        $res->assertStatus(404);
    }

    /**
     * @test
     */
    public function 会社請求先情報だけ取得する際にデータが存在しない()
    {
        $billing = CompanyBilling::factory()->create();
        $res = $this->getJson(route('api.company.billing.show', $billing->id + 1));

        $res->assertStatus(404);
    }

    /**
     * @test
     */
    public function 会社請求先情報の更新を行う際にvalidationエラーになる()
    {
        $billing = CompanyBilling::factory()->create();
        $params = $this->params();
        $params['name'] = null;

        $res = $this->putJson(route('api.company.billing.update', $billing->id), $params);

        $res->assertStatus(422);
    }

    /**
     * @test
     */
    public function 会社請求先情報の削除を行う際にデータが存在しない()
    {
        $billing = CompanyBilling::factory()->create();

        $res = $this->deleteJson(route('api.company.billing.delete', $billing->id + 1));

        $res->assertStatus(404);
    }

    /**
     * @test
     */
    public function 会社請求先情報の登録()
    {
        $company = Company::factory()->create();
        $params = $this->params();

        $res = $this->postJson(route('api.company.billing.create', $company->id), $params);

        $res->assertOk();
        $data = $res->json();
        $this->assertTrue(collect($params)->every(function($v, $k) use ($data) {
            return $data -> $k === $v;
        }));
    }

    /**
     * @test
     */
    public function 会社請求先情報だけの取得を行う()
    {
        $billing = CompanyBilling::factory()->create();
        $res = $this->getJson(route('api.company.billing.show', $billing->id));

        $res->assertOk();
        $data = $res->json();

        $this->assertTrue(collect($billing->toArray())->every(function($v, $k) use ($data) {
            return $v === $data -> $k;
        }));
    }

    /**
     * @test
     */
    public function 会社請求先情報の更新を行う()
    {
        $billing = CompanyBilling::factory()->create();
        $params = $this->params();

        $res = $this->putJson(route('api.company.billing.update', $billing->id), $params);

        $res->assertOk();
        $data = $res->json();
        $this->assertTrue(collect($params)->every(function($v, $k) use ($data) {
            return $data -> $k === $v;
        }));
    }

    /**
     * @test
     */
    public function 会社請求先情報の削除を行う()
    {
        $billing = CompanyBilling::factory()->create();

        $res = $this->deleteJson(route('api.company.billing.delete', $billing->id));

        $res->assertOk();
    }

    private function params()
    {
        return [
            'name' => '請求先社名',
            'kana_name' => 'せいきゅうさきしゃめい',
            'post_code' => '333-2222',
            'prefecture' => '',
            'address' => '東京都渋谷区',
            'tel' => '01234567899',
            'department' => '宛先部署',
            'BillingDepartment' => '会社代表者名',
            'kana_BillingDepartment' => 'かいしゃだいひょうしゃ',
        ];
    }

}