<?php

namespace Dwo\Client\Clients;

use Dwo\Client\Response;

/**
 * Class FixturesClient
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class FixturesClient extends AbstractClient
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * {@inheritdoc}
     */
    public function send($method, $url, array $options = array())
    {
        $response = new Response(200, $this->body);

        $this->body = null;

        return $response;
    }


}
