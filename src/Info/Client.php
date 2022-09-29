<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Info;

use GuzzleHttp\Exception\GuzzleException;
use Vinhson\EsignSdk\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 个人2要素信息比对
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号（大陆二代身份证）
     * @return mixed
     * @throws GuzzleException
     */
    public function personTwoElements(string $name, string $idNo)
    {
        return $this->post('/v2/identity/verify/individual/base', [
            'name' => $name,
            'idNo' => $idNo
        ]);
    }

    /**
     * 个人运营商3要素信息比对
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号（大陆二代身份证）
     * @param string $mobileNo 手机号（中国大陆3大运营商）
     * @return mixed
     * @throws GuzzleException
     */
    public function personThreeElements(string $name, string $idNo, string $mobileNo)
    {
        return $this->post('/v2/identity/verify/individual/telecom3Factors', [
            'name' => $name,
            'idNo' => $idNo,
            'mobileNo' => $mobileNo
        ]);
    }

    /**
     * 个人运营商3要素信息比对（详情版）
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号（大陆二代身份证）
     * @param string $mobileNo 手机号（中国大陆3大运营商）
     * @return mixed
     * @throws GuzzleException
     */
    public function personThreeElementsDetail(string $name, string $idNo, string $mobileNo)
    {
        return $this->post('/v2/identity/verify/individual/telecom3Factors/detail', [
            'name' => $name,
            'idNo' => $idNo,
            'mobileNo' => $mobileNo
        ]);
    }

    /**
     * 个人银行卡3要素信息比对
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号（大陆二代身份证）
     * @param string $cardNo 银行卡号（银联卡号）
     * @return mixed
     * @throws GuzzleException
     */
    public function personBankCard3Elements(string $name, string $idNo, string $cardNo)
    {
        return $this->post('/v2/identity/verify/individual/bank3Factors', [
            'name' => $name,
            'idNo' => $idNo,
            'cardNo' => $cardNo
        ]);
    }

    /**
     * 个人银行卡3要素信息比对（详情版）
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号（大陆二代身份证）
     * @param string $cardNo 银行卡号（银联卡号）
     * @return mixed
     * @throws GuzzleException
     */
    public function personBankCard3ElementsDetail(string $name, string $idNo, string $cardNo)
    {
        return $this->post('/v2/identity/verify/individual/bank3Factors/detail', [
            'name' => $name,
            'idNo' => $idNo,
            'cardNo' => $cardNo
        ]);
    }

    /**
     * 个人银行卡4要素信息比对
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号（大陆二代身份证）
     * @param string $cardNo 银行卡号（银联卡号）
     * @param string $mobileNo 手机号（中国大陆3大运营商）
     * @return mixed
     * @throws GuzzleException
     */
    public function personBankCard4Elements(string $name, string $idNo, string $cardNo, string $mobileNo)
    {
        return $this->post('/v2/identity/verify/individual/bank4Factors', [
            'name' => $name,
            'idNo' => $idNo,
            'cardNo' => $cardNo,
            'mobileNo' => $mobileNo
        ]);
    }

    /**
     * 个人银行卡4要素信息比对（详情版）
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号（大陆二代身份证）
     * @param string $cardNo 银行卡号（银联卡号）
     * @param string $mobileNo 手机号（中国大陆3大运营商）
     * @return mixed
     * @throws GuzzleException
     */
    public function personBankCard4ElementsDetail(string $name, string $idNo, string $cardNo, string $mobileNo)
    {
        return $this->post('/v2/identity/verify/individual/bank4Factors/detail', [
            'name' => $name,
            'idNo' => $idNo,
            'cardNo' => $cardNo,
            'mobileNo' => $mobileNo
        ]);
    }

    /**
     * 人脸照片核验比对
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号
     * @param string $faceImgBase64 人像照片Base64编码，注：不包含格式前缀
     * @return mixed
     * @throws GuzzleException
     */
    public function personFaceCompare(string $name, string $idNo, string $faceImgBase64)
    {
        return $this->post('/v2/identity/verify/individual/faceCompare/withoutSource', [
            'name' => $name,
            'idNo' => $idNo,
            'faceImgBase64' => $faceImgBase64,
        ]);
    }

    /**
     * 组织机构2要素信息比对
     *
     * @param string $name 组织机构名称
     * @param string $orgCode 组织机构证件号,支持15位工商注册号或统一社会信用代码
     * @return mixed
     * @throws GuzzleException
     */
    public function organization2Elements(string $name, string $orgCode)
    {
        return $this->post('/v2/identity/verify/organization/enterprise/base', [
            'name' => $name,
            'orgCode' => $orgCode
        ]);
    }

    /**
     * 组织机构3要素信息比对
     *
     * @param string $name 组织机构名称
     * @param string $orgCode 组织证件号:
     *                          工商企业支持15位工商注册号或统一社会信用代码
     *                          非工商组织仅支持统一社会信用代码校验
     * @param string $legalRepName 组织法定代表人姓名
     * @return mixed
     * @throws GuzzleException
     */
    public function organization3Elements(string $name, string $orgCode, string $legalRepName)
    {
        return $this->post('/v2/identity/verify/organization/verify', [
            'name' => $name,
            'orgCode' => $orgCode,
            'legalRepName' => $legalRepName
        ]);
    }

    public function enterprise3Elements()
    {
        return $this->post('', [

        ]);
    }
}
