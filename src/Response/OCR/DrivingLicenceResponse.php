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

class DrivingLicenceResponse extends Response
{
    public function getName()
    {
        return $this->getData()['name'] ?? '';
    }

    public function getSex()
    {
        return $this->getData()['sex'] ?? '';
    }

    public function getBirthday()
    {
        return $this->getData()['birthday'] ?? '';
    }

    public function getNationality()
    {
        return $this->getData()['nationality'] ?? '';
    }

    public function getAddress()
    {
        return $this->getData()['address'] ?? '';
    }

    public function getType()
    {
        return $this->getData()['type'] ?? '';
    }

    public function getNumber()
    {
        return $this->getData()['number'] ?? '';
    }

    public function getIssueDate()
    {
        return $this->getData()['issueDate'] ?? '';
    }

    public function getDriveType()
    {
        return $this->getData()['driveType'] ?? '';
    }

    public function getFileNumber()
    {
        return $this->getData()['fileNumber'] ?? '';
    }

    public function getValidTime()
    {
        return $this->getData()['validTime'] ?? '';
    }

    public function getRecord()
    {
        return $this->getData()['record'] ?? '';
    }
}
