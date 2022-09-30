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

class LicenseResponse extends Response
{
    public function getName()
    {
        return $this->getData()['name'] ?? '';
    }

    public function getCertNo()
    {
        return $this->getData()['certNo'] ?? '';
    }

    public function getType()
    {
        return $this->getData()['type'] ?? '';
    }

    public function getAddress()
    {
        return $this->getData()['address'] ?? '';
    }

    public function getLegalRepName()
    {
        return $this->getData()['legalRepName'] ?? '';
    }

    public function getCapital()
    {
        return $this->getData()['capital'] ?? '';
    }

    public function getEstablishDate()
    {
        return $this->getData()['establishDate'] ?? '';
    }

    public function getValidTerm()
    {
        return $this->getData()['validTerm'] ?? '';
    }

    public function getScope()
    {
        return $this->getData()['scope'] ?? '';
    }
}
