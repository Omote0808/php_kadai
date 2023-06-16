<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyControllertest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function 会社情報登録がvalidationでひっかかる()
    {
       $params = $this->params();
       $params['name'] = null;

        $res = $this->postJson(route('api.company.create'), $params);

        $res->assertStatus(422);
    }

    /**
     * @test
     */
    public function 会社情報が存在しない()
    {
        $company = Company::factory()->create();

        $res = $this->getJson(route('api.company.show', $company->id + 1));

        $res->assertStatus(404);
    }

    /**
     * @test
     */
    public function 会社情報を更新でvalidationにひっかかる()
    {
        $company = Company::factory()->create();
        $params = $this->params();
        $params['name'] = null;
        $res = $this->putJson(route('api.company.update', $company->id), $params);

        $res->assertStatus(422);
    }  

    /**
     * @test
     */
    public function 会社情報を削除際、データが存在しない()
    {
        $company = Company::factory()->create();

        $res = $this->deleteJson(route('api.company.delete', $company->id + 1));

        $res->assertStatus(404);
    }




    /**
     * @test
     */
    public function 会社情報の登録を行うことができる()
    {
        $params = $this->params();

        $res = $this->postJson(route('api.company.create'), $params);

        $res->assertStatus(201);

        $companies = Company::all();

        $this->assertCount(1, $companies);
        $company = $companies->first();

        $this->assertTrue(collect($params)->every(function ($value, $key) use ($company) {
            return $company->$k === $v;
        }));
}

    /**
     * @test
     */
    public function 会社情報を更新する()
    {
        $company = Company::factory()->create();
        $params =$this->params();

        $res = $this->putJson(route('api.company.update', $company->id), $params);

        $res->assertOk();

        $data = $res->json();

        $this->assertTrue(collect($params)->every(function ($v, $k) use ($data) {
            return $data->$k === $v;
        }));
    }

 

     /**
     * @test
     */
    public function 会社情報を削除する()
    {
        $company = Company::factory()->create();

        $res = $this->deleteJson(route('api.company.delete', $company->id));

        $res->assertOk();

        $this->assertCount(0, Company::all());
    }



    private function params()
{
    return [
        'name' => '社名',
        'kana_name' => 'しゃめい',
        'post_code' => '111-2222',
        'address' => '東京都渋谷区',
        'tel' => '1234567',
        'representative' => '会社代表者名',
        'kana_representative' => 'かいしゃだいひょうかな',
    ];
}
}