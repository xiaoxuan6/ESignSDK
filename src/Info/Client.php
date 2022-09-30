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

use Vinhson\EsignSdk\Kernel\BaseClient;
use GuzzleHttp\Exception\GuzzleException;

class Client extends BaseClient
{
    /**
     * 个人2要素信息比对
     *
     * @param string $name 姓名
     * @param string $idNo 身份证号（大陆二代身份证）
     * @return array
     * @throws GuzzleException
     */
    public function personTwoElements(string $name, string $idNo): array
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
     * @return array
     * @throws GuzzleException
     */
    public function personThreeElements(string $name, string $idNo, string $mobileNo): array
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
     * @return array
     * @throws GuzzleException
     */
    public function personThreeElementsDetail(string $name, string $idNo, string $mobileNo): array
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
     * @return array
     * @throws GuzzleException
     */
    public function personBankCard3Elements(string $name, string $idNo, string $cardNo): array
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
     * @return array
     * @throws GuzzleException
     */
    public function personBankCard3ElementsDetail(string $name, string $idNo, string $cardNo): array
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
     * @return array
     * @throws GuzzleException
     */
    public function personBankCard4Elements(string $name, string $idNo, string $cardNo, string $mobileNo): array
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
     * @return array
     * @throws GuzzleException
     */
    public function personBankCard4ElementsDetail(string $name, string $idNo, string $cardNo, string $mobileNo): array
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
     * @return array
     * @throws GuzzleException
     */
    public function personFaceCompare(string $name, string $idNo, string $faceImgBase64): array
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
     * @return array
     * @throws GuzzleException
     */
    public function organization2Elements(string $name, string $orgCode): array
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
     * @return array
     * @throws GuzzleException
     */
    public function organization3Elements(string $name, string $orgCode, string $legalRepName): array
    {
        return $this->post('/v2/identity/verify/organization/verify', [
            'name' => $name,
            'orgCode' => $orgCode,
            'legalRepName' => $legalRepName
        ]);
    }

    /**
     * 企业3要素信息比对
     *      注：适用于工商体系企业以及个体工商户进行企业3要素信息比对
     *
     * @param string $name
     * @param string $orgCode
     * @param string $legalRepName
     * @return array
     * @throws GuzzleException
     */
    public function enterprise3Elements(string $name, string $orgCode, string $legalRepName): array
    {
        return $this->post('/v2/identity/verify/organization/enterprise/bureau3Factors', [
            'name' => $name,
            'orgCode' => $orgCode,
            'legalRepName' => $legalRepName
        ]);
    }

    /**
     * 企业4要素信息比对
     *
     * @param string $name
     * @param string $orgCode
     * @param string $legalRepName
     * @param string $legalRepCertNo
     * @return array
     * @throws GuzzleException
     */
    public function enterprise4Elements(string $name, string $orgCode, string $legalRepName, string $legalRepCertNo): array
    {
        return $this->post('/v2/identity/verify/organization/enterprise/bureau4Factors', [
            'name' => $name,
            'orgCode' => $orgCode,
            'legalRepName' => $legalRepName,
            'legalRepCertNo' => $legalRepCertNo
        ]);
    }

    /**
     * 律所3要素信息比对
     *
     * @param string $name
     * @param string $codeUSC
     * @param string $legalRepName
     * @return array
     * @throws GuzzleException
     */
    public function lawyer3Elements(string $name, string $codeUSC, string $legalRepName): array
    {
        return $this->post('/v2/identity/verify/organization/lawFirm', [
            'name' => $name,
            'codeUSC' => $codeUSC,
            'legalRepName' => $legalRepName
        ]);
    }

    /**
     * 非工商组织3要素信息比对
     *
     * @param string $name
     * @param string $codeUSC
     * @param string $legalRepName
     * @return array
     * @throws GuzzleException
     */
    public function social3Elements(string $name, string $codeUSC, string $legalRepName): array
    {
        return $this->post('/v2/identity/verify/organization/social', [
            'name' => $name,
            'codeUSC' => $codeUSC,
            'legalRepName' => $legalRepName
        ]);
    }
}
