<?php

/*
 * This file is part of esign sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Response\Account;

use Vinhson\EsignSdk\Response\Response;

class PersonAccountCreateResponse extends Response
{
    public function getAccountId()
    {
        return $this->getData()['accountId'] ?? '';
    }
}
