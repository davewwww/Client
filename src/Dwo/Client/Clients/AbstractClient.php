<?php

namespace Dwo\Client\Clients;

/**
 * Class AbstractClient
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
abstract class AbstractClient implements ClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($url, array $options = array())
    {
        return $this->send('GET', $url, $options);
    }
}
