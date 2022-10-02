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
use Mockery\Mock;
use Vinhson\EsignSdk\Account\Client;
use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Kernel\Support\IdType;
use Vinhson\EsignSdk\Response\Account\{PersonAccountCreateResponse, PersonAccountModifyResponse};

class AccountTest extends TestCase
{
    /**
     * @var Mock | Client
     */
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class . '[request]', [$this->app])->shouldAllowMockingProtectedMethods();
    }

    /**
     * @throws GuzzleException
     */
    public function testPersonAccountCreate()
    {
        $expected = [
            'name' => 'vinhson',
            'mobile' => '18888888888',
            'email' => '18888888888@163.com',
            'idType' => IdType::ID_TYPE_IDCARD,
            'idNumber' => '',
            'thirdPartyUserId' => time(),
        ];

        $data = [
            "accountId" => "1eaf205d5d6d4e579a9d221d775xxx"
        ];

        $this->client->shouldReceive('request')
            ->with(
                Mockery::on(function ($api) {
                    return $api == '/v1/accounts/createByThirdPartyUserId';
                }),
                'POST',
                Mockery::on(function ($params) use ($expected) {
                    ksort($params['json']);
                    ksort($expected);

                    return $expected == $params['json'];
                })
            )
            ->andReturn(
                [
                    "code" => 0,
                    "message" => "成功",
                    "data" => $data
                ],
                [
                    "code" => 30500004,
                    "message" => "error",
                ]
            )
            ->twice();

        $response = $this->client->personAccountCreate($expected['thirdPartyUserId'], $expected['name'], $expected['idType'], $expected['idNumber'], $expected['mobile'], $expected['email']);
        $this->assertInstanceOf(PersonAccountCreateResponse::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->assertNotEmpty($response->getAccountId());

        $response = $this->client->personAccountCreate($expected['thirdPartyUserId'], $expected['name'], $expected['idType'], $expected['idNumber'], $expected['mobile'], $expected['email']);
        $this->assertInstanceOf(PersonAccountCreateResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('error', $response->getReason());
    }

    /**
     * @throws GuzzleException
     */
    public function testPersonAccountModify()
    {
        $name = 'vinhson';
        $accountId = '1eaf205d5d6d4e579a9d221d775xxxx';

        $this->client->shouldReceive('request')
            ->with(
                Mockery::on(function ($api) use ($accountId) {
                    return $api == "/v1/accounts/{$accountId}";
                }),
                'PUT',
                Mockery::on(function ($params) use ($name) {
                    return $params['json']['name'] == $name;
                })
            )
            ->andReturn(
                [
                    "code" => 0,
                    "message" => "成功",
                    "data" => [
                        "mobile" => "182681xxxx",
                        "email" => "test@esign.cn",
                        "cardNo" => null,
                        "name" => $name,
                        "accountId" => $accountId,
                        "idType" => "CRED_PSN_CH_IDCARD",
                        "idNumber" => "372482xxxxxxxx3829",
                        "thirdPartyUserId" => "20190923103830111",
                        "thirdPartyUserType" => "_DEFAULT_USER"
                    ]
                ],
                [
                    "code" => 30500004,
                    "message" => "error",
                ]
            )
            ->twice();

        $response = $this->client->personAccountModify($accountId, $name);
        self::assertInstanceOf(PersonAccountModifyResponse::class, $response);
        $this->assertTrue($response->isSuccess());

        $response = $this->client->personAccountModify($accountId, $name);
        $this->assertInstanceOf(PersonAccountModifyResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('error', $response->getReason());
    }
}
