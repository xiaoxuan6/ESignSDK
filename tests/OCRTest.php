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
use Vinhson\EsignSdk\OCR\Client;
use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Response\OCR\{BankCardResponse,
    DrivingLicenceResponse,
    DrivingPermitResponse,
    IdCardResponse,
    LicenseResponse};

class OCRTest extends TestCase
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
    public function testIdCard()
    {
        $data = [
            "verifyId" => "79be36a7-96ba-4989-9b79-xx",
            "name" => "**",
            "idNo" => "330100xxxx15011",
            "gender" => "男",
            "birthDay" => "1990年1月1日",
            "nation" => "汉",
            "address" => "浙江省杭州市......",
            "validityPeriod" => "2019.01.01-2039.01.01",
            "issuedBy" => "XXX公安局"
        ];

        $this->client->shouldReceive('post')
            ->with(
                Mockery::on(function ($api) {
                    return $api == '/v2/identity/auth/api/ocr/idcard';
                }),
                Mockery::on(function ($params) {
                    return is_array($params) && ! empty($params);
                })
            )
            ->andReturn(
                [
                    "code" => 0,
                    "message" => "成功",
                    "data" => $data
                ],
                [
                    "code" => 30503129,
                    "message" => "身份证人像面识别失败",
                ]
            )
            ->twice();

        $response = $this->client->idCard('4AAQSkZJRgABAQEAS', '');
        $this->assertInstanceOf(IdCardResponse::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->checkData($data, $response);

        $response = $this->client->idCard('', '222');
        $this->assertInstanceOf(IdCardResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('身份证人像面识别失败', $response->getReason());
    }

    /**
     * @throws GuzzleException
     */
    public function testBankCard()
    {
        $data = [
            "verifyId" => "fcc8b05c-7f06-4275-a750-4f754070affa",
            "bankCardNo" => "623xxxxxxxxxxxx979",
            "bankName" => "杭州商业银行",
            "bankCardType" => "借记卡"
        ];

        $this->client->shouldReceive('post')
            ->with(
                Mockery::on(function ($api) {
                    return $api == '/v2/identity/auth/api/ocr/bankcard';
                }),
                Mockery::on(function ($params) {
                    return array_key_exists('img', $params) && ! empty($params['img']);
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
            ->twice();

        $response = $this->client->bankCard('/9j/4AAQSkZJRgABAQEAS');
        $this->assertInstanceOf(BankCardResponse::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->checkData($data, $response);

        $response = $this->client->bankCard('/9j/xxx');
        $this->assertInstanceOf(BankCardResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('OCR识别失败', $response->getReason());
    }

    /**
     * @throws GuzzleException
     */
    public function testLicense()
    {
        $data = [
            "verifyId" => "154a5416-5dee-4ee2-bb06-d4fabc83fd32",
            "name" => "XXX电子商务有限公司",
            "certNo" => "914101xxxxxxxx221J",
            "type" => "营业执照",
            "address" => "浙江省杭州市......",
            "legalRepName" => "张三",
            "capital" => "陆佰万圆整",
            "establishDate" => "2010年09月02日",
            "validTerm" => "2010年09月02日至2020年09月01日",
            "scope" => "网上贸易代理......"
        ];

        $this->client->shouldReceive('post')
            ->with(
                Mockery::on(function ($api) {
                    return $api == '/v2/identity/auth/api/ocr/license';
                }),
                Mockery::on(function ($params) {
                    return array_key_exists('img', $params) && ! empty($params);
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
            ->twice();

        $response = $this->client->license('/9j/4AAQSkZJRgABAQEAS');
        $this->assertInstanceOf(LicenseResponse::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->checkData($data, $response);

        $response = $this->client->license('/9j/xxx');
        $this->assertInstanceOf(LicenseResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('OCR识别失败', $response->getReason());
    }

    /**
     * @throws GuzzleException
     */
    public function testDrivingLicence()
    {
        $data = [
            "verifyId" => "ef291116-0001-41a3-8caa-7c4a6db7a179",
            "birthday" => "1996-03-12",
            "issueDate" => "2013-11-12",
            "sex" => "女",
            "address" => "XXXXXXXX",
            "nationality" => "中国",
            "name" => "张三",
            "validTime" => "2020-08-13至2030-08-13",
            "driveType" => "C1",
            "type" => "中华人民共和国机动车驾驶证",
            "number" => "2311XXXXXXXXX",
            "fileNumber" => "23XXXXXXX7",
            "record" => ""
        ];

        $this->client->shouldReceive('post')
            ->with(
                Mockery::on(function ($api) {
                    return $api == '/v2/identity/auth/api/ocr/drivinglicence';
                }),
                Mockery::on(function ($params) {
                    return array_key_exists('image', $params) && array_key_exists('backImage', $params) && ! empty($params['image']) && ! empty($params['backImage']);
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
            ->twice();

        $response = $this->client->drivingLicence('/9j/4AAQSkZJRgABAQEAS', '4AAQSkZJRgABAQEAS', time());
        $this->assertInstanceOf(DrivingLicenceResponse::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->checkData($data, $response);

        $response = $this->client->drivingLicence('/9j/xxx', '4AAQSkZJRgABAQEAS', time());
        $this->assertInstanceOf(DrivingLicenceResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('OCR识别失败', $response->getReason());
    }

    /**
     * @throws GuzzleException
     */
    public function testDrivingPermit()
    {
        $data = [
            "verifyId" => "64dfb0e1-0001-4f25-aab4-26fd9843f88e",
            "mainModel" => "XXX牌TVXXXX",
            "carType" => "小型轿车",
            "mainRegisterDate" => "2019-08-30",
            "address" => "XXXXXX",
            "owner" => "张三",
            "issueDate" => "2019-08-30",
            "mainUserCharacter" => "非营运",
            "mainEngineNo" => "LXXXXXX",
            "mainVin" => "LXXXXXXXXXXX",
            "mainPlateNum" => "浙AXXXXX",
            "fileNo" => "",
            "approvedPassengers" => "5人",
            "grossMass" => "1500kg",
            "unladenMass" => "1090kg",
            "approvedLoad" => "",
            "dimension" => "4420×1700×1490mm",
            "tractionMass" => "",
            "remarks" => "",
            "inspectionRecord" => "",
            "codeNumber" => "*233XXXXXXX22*"
        ];

        $this->client->shouldReceive('post')
            ->with(
                Mockery::on(function ($api) {
                    return $api == '/v2/identity/auth/api/ocr/drivingPermit';
                }),
                Mockery::on(function ($params) {
                    return array_key_exists('image', $params) && array_key_exists('backImage', $params) && ! empty($params['image']) && ! empty($params['backImage']);
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
            ->twice();

        $response = $this->client->drivingPermit('/9j/4AAQSkZJRgABAQEAS', '4AAQSkZJRgABAQEAS', time());
        $this->assertInstanceOf(DrivingPermitResponse::class, $response);
        $this->assertTrue($response->isSuccess());

        $response = $this->client->drivingPermit('/9j/xxx', '4AAQSkZJRgABAQEAS', time());
        $this->assertInstanceOf(DrivingPermitResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('OCR识别失败', $response->getReason());
    }
}
