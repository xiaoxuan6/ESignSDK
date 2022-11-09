<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Response\OCR;

use Vinhson\EsignSdk\Response\Response;

class BankCardResponse extends Response
{
    /**
     * @return string
     */
    public function getBankCardNo(): string
    {
        return $this->getData()['bankCardNo'] ?? '';
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->getData()['bankName'] ?? '';
    }

    /**
     * @return string
     */
    public function getBankCardType(): string
    {
        return $this->getData()['bankCardType'] ?? '';
    }
}
