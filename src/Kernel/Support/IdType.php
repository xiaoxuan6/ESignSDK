<?php

/*
 * This file is part of james.xue/esign-sdk.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\EsignSdk\Kernel\Support;

class IdType
{
    /**
     * 中国大陆身份证（默认值）
     */
    public const ID_TYPE_IDCARD = 'CRED_PSN_CH_IDCARD';

    /**
     * 台湾来往大陆通行证
     */
    public const ID_TYPE_TWCARD = 'CRED_PSN_CH_TWCARD';

    /**
     * 澳门来往大陆通行证
     */
    public const ID_TYPE_MACAO = 'CRED_PSN_CH_MACAO';

    /**
     * 香港来往大陆通行证
     */
    public const ID_TYPE_HONGKONG = 'CRED_PSN_CH_HONGKONG';

    /**
     * 护照
     */
    public const ID_TYPE_PASSPORT = 'CRED_PSN_CH_PASSPORT';
}
