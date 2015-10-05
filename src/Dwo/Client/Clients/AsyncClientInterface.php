<?php

namespace Dwo\Client\Clients;

use Dwo\Client\Response;

/**
 * Interface AsyncClient
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
interface AsyncClientInterface
{
    /**
     * @param array $urls
     * @param array $options
     *
     * @return Response[]
     */
    public function sendAsync(array $urls, array $options = array());
}
