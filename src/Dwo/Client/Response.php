<?php

namespace Dwo\Client;

/**
 * Class Response
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class Response
{
    /**
     * @var int|null
     */
    protected $statusCode;

    /**
     * @var string|null
     */
    protected $content;

    /**
     * @var array|null
     */
    protected $header;

    /**
     * @param int|null    $statusCode
     * @param string|null $content
     * @param array|null  $header
     */
    public function __construct($statusCode = null, $content = null, array $header = null)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->header = $header;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return array|null
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param array|null $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->content;
    }
}
