<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\View;

use Fennek\Framework\View\Exception\UnknownHelperException;
use Fennek\Framework\View\Helper\HelperInterface;


/**
 * Interface ViewInterface
 *
 * @package Bank\View
 */
interface ViewInterface
{
    /**
     * The file to render.
     *
     * @param string $file
     *
     * @return $this
     */
    public function setId($file);

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function assign($name, $value);

    /**
     * Renders the view with given parameters.
     *
     * @return string
     */
    public function render();

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getBasePath();

    /**
     * @codeCoverageIgnore
     *
     * @param string $basePath
     *
     * @return $this
     */
    public function setBasePath($basePath);

    /**
     * Adds a helper to the view.
     *
     * @param HelperInterface $helper
     *
     * @return $this;
     */
    public function addHelper(HelperInterface $helper);

    /**
     * @param array $helpers
     *
     * @return $this
     */
    public function setHelpers(array $helpers);

    /**
     * Returns the helper by given name. If not found, an exception is thrown.
     *
     * @param string $name
     *
     * @return HelperInterface
     * @throws UnknownHelperException if the given name is not exists.
     */
    public function getHelper($name);

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getParams();

    /**
     * @codeCoverageIgnore
     * @return Helper\HelperInterface[]
     */
    public function getHelpers();

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getId();

}