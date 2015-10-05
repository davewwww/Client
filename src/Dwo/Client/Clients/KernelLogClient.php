<?php

namespace Dwo\Client\Clients;

use Symfony\Component\HttpKernel\KernelInterface;
use Dwo\Client\Response;

/**
 * Class KernelLogClient
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class KernelLogClient extends AbstractClient
{
    const FILENAME = 'http_client_%s.log';

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return string
     */
    public static function createFileName()
    {
        return sprintf(self::FILENAME, date('Ymd'));
    }

    /**
     * {@inheritdoc}
     */
    public function send($method, $url, array $options = array())
    {
        $content = $url;

        if (isset($options[ClientInterface::OPTION_BODY])) {
            $content .= ' '.http_build_query($options[ClientInterface::OPTION_BODY]);
        }

        $log = $this->kernel->getCacheDir().'/'.self::createFileName();
        file_put_contents($log, $content.PHP_EOL, FILE_APPEND);

        return new Response(200);
    }
}
