<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Tests;

use Mockery;
use Vinhson\EsignSdk\AuthFlow\Client;
use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Response\AuthFlow\{AuthFlowDetailResponse, AuthFlowResponse};

class AuthenticationTest extends TestCase
{
    /**
     * @var Mockery\Mock | Client
     */
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class . '[get]', [$this->app])->shouldAllowMockingProtectedMethods();
    }

    /**
     * @throws GuzzleException
     */
    public function testAuthFlow()
    {
        $data = [
            "flowId" => "803719636976683872",
            "flowStatus" => "ING",
            "objectType" => "ORGANIZATION",
            "failReason" => null,
            "createTime" => 1562656814273,
            "modifyTime" => 1562656874000,
            "contextId" => "8ccce54b-4d40-4dcc-a7ac-464e41f2b468",
            "subFlows" => [
                [
                    "subFlowId" => "5ffbafb2-c3be-45ba-bfeb-fda1f8eb083d",
                    "subFlowType" => "ORGANIZATION_TRANSFER_RANDOM_AMOUNT",
                    "status" => "ING"
                ],
                [
                    "subFlowId" => "3bb55061-f98f-4c89-b236-96b3e7048839",
                    "subFlowType" => "ORGANIZATION_INFO_AUTH",
                    "status" => "ING"
                ]
            ],
            "relatedFlows" => [
                [
                    "flowId" => "802965095964494307",
                    "flowStatus" => "SUCCESS",
                    "objectType" => "INDIVIDUAL",
                    "failReason" => null,
                    "contextId" => "8ccce54b-4d40-4dcc-a7ac-464e41f2b468",
                    "subFlows" => [
                        [
                            "subFlowId" => "84322b8a-5baf-4835-82a7-07dbd74c3365",
                            "subFlowType" => "INDIVIDUAL_BANKCARD_4_FACTOR",
                            "status" => "SUCCESS"
                        ]
                    ]

                ]
            ],
        ];

        $this->client->shouldReceive('get')
            ->with(
                Mockery::on(function ($api) {
                    return str_contains($api, '/v2/identity/auth/api/common/') && str_contains($api, '/outline');
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
                    "message" => "认证流程不存在",
                ]
            )
            ->twice();

        $response = $this->client->authFlow('803719636976683872');
        $this->assertInstanceOf(AuthFlowResponse::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->assertSame('803719636976683872', $response->getData()['flowId']);

        $response = $this->client->authFlow('234');
        $this->assertInstanceOf(AuthFlowResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('认证流程不存在', $response->getReason());
    }

    /**
     * @throws GuzzleException
     */
    public function testAuthFlowDetail()
    {
        $data = [
            "flowId" => "1870616916160000000",
            "status" => "ING",
            "objectType" => "INDIVIDUAL",
            "authType" => "FACEAUTH_TECENT_CLOUD",
            "startTime" => 1626233456000,
            "endTime" => 1626777225000,
            "failReason" => null,
            "url" => "https://smlfront.esign.cn:8890/identity/login?appId=xxx&param=VhIKYXo%2BYZo4jH0dhEXXlPhMNeqMiefgsZuFFkaRLGSDkfG1t78agZcQlOr4b5SPkrUMtmeG%2By3Uh%2FHVJKjEbQ61%2FRkvCGdsj%2BaQqkHEUwssk2xttgrKAe0fDynMkcuyG5oLoqFI3X2LqJUclCZX60YcqlG9DJ%2BnPc55J3vdQasdmgAIidGjfSKPif6L%2F98LWJLp%2Ftd%2BjXXPfeN267A%2Fbclu6untFBYSJliWg0dP4o3Hunm1qR5%2BJEVEqJQWOywS%2F3ebVDWEwG4CavXegJzy%2B6EqdWb67ngJeIc45I&lang=zh-CN",
            "shortLink" => "https://smlt.esign.cn/aOX2s6hYy***",
            "organInfo" => null,
            "indivInfo" => [
                "accountId" => "3e3663a2360448b08f46c3514c8bc***",
                "name" => "**",
                "certNo" => "231182199403124***",
                "certType" => "INDIVIDUAL_CH_IDCARD",
                "nationality" => "MAINLAND",
                "mobileNo" => "1530465****",
                "bankCardNo" => "62202110301608****",
                "facePhotoUrl" => null,
                "facePhotoAllUrl" => null,
                "livingScore" => "0.0",
                "similarity" => "0.0"
            ]
        ];

        $this->client->shouldReceive('get')
            ->with(
                Mockery::on(function ($api) {
                    return str_contains($api, '/v2/identity/auth/api/common/') && str_contains($api, '/detail');
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
                    "message" => "认证流程不存在",
                ]
            )
            ->twice();

        $response = $this->client->authFlowDetail('1870616916160000000');
        $this->assertInstanceOf(AuthFlowDetailResponse::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->assertSame('1870616916160000000', $response->getData()['flowId']);

        $response = $this->client->authFlowDetail('234');
        $this->assertInstanceOf(AuthFlowDetailResponse::class, $response);
        $this->assertFalse($response->isSuccess());
        $this->assertSame('认证流程不存在', $response->getReason());
    }
}
