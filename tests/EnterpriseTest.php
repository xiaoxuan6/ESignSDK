<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Tests;

use Mockery;
use Vinhson\EsignSdk\Enterprise\Client;
use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Response\Enterprise\DetailResponse;

class EnterpriseTest extends TestCase
{
    /**
     * @var Mockery\Mock | Client
     */
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class . '[post]', [$this->app])->shouldAllowMockingProtectedMethods();
    }

    /**
     * @throws GuzzleException
     */
    public function testDetail()
    {
        $data = [
            "requestId" => "d42a2315-0011-46cc-0100-857abc249c6f",
            "name" => "杭州XX信息科技有限公司",
            "econKind" => "有限责任公司(自然人投资或控股)",
            "registCapi" => "6788.8573 万人民币",
            "address" => "浙江省杭州市西湖区西斗门路3号天堂软件园D幢19层",
            "scope" => "一般项目：技术服务、技术开发、技术咨询、技术交流、技术转让、技术推广；信息系统集成服务；计算机软硬件及辅助设备批发；计算机软硬件及辅助设备零售；软件开发；信息咨询服务（不含许可类信息咨询服务）；计算机系统服务(除依法须经批准的项目外，凭营业执照依法自主开展经营活动)。许可项目：第二类增值电信业务；公章刻制(依法须经批准的项目，经相关部门批准后方可开展经营活动，具体经营项目以审批结果为准)。",
            "termStart" => "2002-12-01",
            "termEnd" => "9999-09-09",
            "operName" => "金XX",
            "startDate" => "2002-12-01",
            "status" => "存续",
            "codeUSC" => "9133XXXX8306077",
            "codeREG" => "33010XXXX3512",
            "codeORG" => "74XXX0607"
        ];
        $this->client->shouldReceive('post')
            ->with(
                Mockery::on(function ($api) {
                    return $api == '/v2/identity/auth/api/meta/enterprise/detail';
                }),
                Mockery::on(function ($params) {
                    return array_key_exists('keyword', $params) && ! empty($params['keyword']);
                })
            )
            ->andReturn(
                [
                    "code" => 0,
                    "message" => "成功",
                    "data" => $data
                ],
                [
                    "code" => 30503127,
                    "message" => "OCR识别失败",
                ]
            )
            ->times(2);

        $response = $this->client->detail('杭州XX信息科技有限公司');
        $this->assertInstanceOf(DetailResponse::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->assertSame('杭州XX信息科技有限公司', $response->getData()['name']);

        $response = $this->client->detail('杭州XX信息科技有限公司');
        $this->assertInstanceOf(DetailResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('OCR识别失败', $response->getReason());
    }
}
