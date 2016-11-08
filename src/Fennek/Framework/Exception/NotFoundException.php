<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\Exception;


use Fennek\Framework\Request;

/**
 * Class NotFoundException
 *
 * @package Bank\Exception
 */
class NotFoundException extends Exception implements \Interop\Container\Exception\NotFoundException
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @codeCoverageIgnore
     *
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }
}