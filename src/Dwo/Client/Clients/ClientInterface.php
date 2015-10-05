<?php

namespace Dwo\Client\Clients;

use Dwo\Client\Response;

/**
 * Interface Client
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
interface ClientInterface
{
    const OPTION_QUERY = 'query';
    const OPTION_BODY = 'body';
    const OPTION_AUTH = 'auth';
    const OPTION_HEADERS = 'headers';

    /**
     * @param string $url
     * @param array  $options
     *
     * @return Response
     */
    public function get($url, array $options = array());

    /**
     * @param string $method
     * @param string $url
     * @param array  $options
     *
     * @return Response
     */
    public function send($method, $url, array $options = array());
}
