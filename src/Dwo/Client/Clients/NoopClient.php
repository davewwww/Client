<?php

namespace Dwo\Client\Clients;

use Dwo\Client\Response;

/**
 * Class NoopClient
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class NoopClient extends AbstractClient
{
    /**
     * {@inheritdoc}
     */
    public function send($method, $url, array $options = array())
    {
        return new Response(200);
    }
}
