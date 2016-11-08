<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\Container;

/**
 * Class FactoryDefinition
 *
 * @package Fennek\Framework\Container
 */
class FactoryDefinition extends Definition
{
    /**
     * @var callable
     */
    protected $callable;

    /**
     * FactoryDefinition constructor.
     *
     * @param string   $id
     * @param callable $callable
     */
    public function __construct($id, callable $callable)
    {
        $this->id       = $id;
        $this->callable = $callable;
    }

    /**
     * @codeCoverageIgnore
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function setCallable(callable $callable)
    {
        $this->callable = $callable;

        return $this;
    }


}