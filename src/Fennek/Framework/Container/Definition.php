<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\Container;


abstract class Definition
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var bool
     */
    protected $shared = true;

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param array $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return boolean
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param boolean $shared
     *
     * @return $this
     */
    public function setShared($shared)
    {
        $this->shared = $shared;

        return $this;
    }
}