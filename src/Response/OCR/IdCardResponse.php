<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Response\OCR;

use Vinhson\EsignSdk\Response\Response;

class IdCardResponse extends Response
{
    public function getName()
    {
        return $this->getData()['name'] ?? '';
    }

    public function getIdNo()
    {
        return $this->getData()['idNo'] ?? '';
    }

    public function getGender()
    {
        return $this->getData()['gender'] ?? '';
    }

    public function getBirthDay()
    {
        return $this->getData()['birthDay'] ?? '';
    }

    public function getNation()
    {
        return $this->getData()['nation'] ?? '';
    }

    public function getAddress()
    {
        return $this->getData()['address'] ?? '';
    }

    public function getValidityPeriod()
    {
        return $this->getData()['validityPeriod'] ?? '';
    }

    public function getIssuedBy()
    {
        return $this->getData()['issuedBy'] ?? '';
    }
}
