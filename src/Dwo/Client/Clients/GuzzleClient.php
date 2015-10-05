<?php

namespace Dwo\Client\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Request;
use Dwo\Client\Response;

/**
 * Class GuzzleClient
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class GuzzleClient extends AbstractClient implements AsyncClientInterface
{
    /**
     * @var GuzzleClientInterface
     */
    protected $client;

    /**
     * @param GuzzleClientInterface|null $client
     */
    public function __construct(GuzzleClientInterface $client = null)
    {
        $this->client = null !== $client ? $client : new Client([]);
    }

    /**
     * {@inheritdoc}
     */
    public function send($method, $url, array $options = array())
    {
        $request = new Request($method, $url);

        $optionsGuzzle = [
            'http_errors' => false
        ];
        if (isset($options[ClientInterface::OPTION_QUERY])) {
            $optionsGuzzle['query'] = $options[ClientInterface::OPTION_QUERY];
        }
        if (isset($options[ClientInterface::OPTION_BODY])) {
            $optionsGuzzle['form_params'] = $options[ClientInterface::OPTION_BODY];
        }
        if (isset($options[ClientInterface::OPTION_AUTH])) {
            $optionsGuzzle['auth'] = $options[ClientInterface::OPTION_AUTH];
        }
        if (isset($options[ClientInterface::OPTION_HEADERS])) {
            $optionsGuzzle['headers'] = $options[ClientInterface::OPTION_HEADERS];
        }

        $response = $this->client->send($request, $optionsGuzzle);

        return new Response($response->getStatusCode(), (string) $response->getBody(), $response->getHeaders());
    }

    /**
     * @return GuzzleClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function sendAsync(array $urls, array $options = array())
    {
        $options = array_merge(
            [
                'http_errors' => false
            ],
            $options
        );

        $promises = [];
        foreach ($urls as $id => $url) {
            $promises[$id] = $this->client->getAsync($url, $options);
        }

        /** @var \GuzzleHttp\Psr7\Response[] $results */
        $results = Promise\unwrap($promises);

        $responses = [];
        foreach ($results as $id => $result) {
            $responses[$id] = new Response(
                $result->getStatusCode(), (string) $result->getBody(), $result->getHeaders()
            );
        }

        return $responses;
    }
}


