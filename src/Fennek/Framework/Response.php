<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework;

/**
 * Response.
 *
 * @package Bank\Util
 */
class Response
{

    const
        STATUS_OK = 200,
        STATUS_MOVED_TEMP = 302,
        STATUS_UNAUTHORIZED = 401,
        STATUS_NOT_FOUND = 404,
        STATUS_INTERNAL_SERVER_ERROR = 500;

    /**
     * @var int
     */
    protected $statusCode = self::STATUS_OK;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var boolean
     */
    protected $layoutDisabled = false;

    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     *
     */
    public function send()
    {
        if ($this->redirectUrl) {
            header('Location: ' . $this->redirectUrl, true, $this->statusCode);

        } else {
            http_response_code($this->statusCode);
            echo $this->body;
        }
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return boolean
     */
    public function isLayoutDisabled()
    {
        return $this->layoutDisabled;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param boolean $disabled
     *
     * @return $this
     */
    public function setLayoutDisabled($disabled)
    {
        $this->layoutDisabled = (bool) $disabled;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $redirectUrl
     *
     * @return $this
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
        $this->statusCode  = self::STATUS_MOVED_TEMP;

        return $this;
    }
}