<?php

namespace Dwo\Client\Clients;

use Dwo\Client\Response;
use Symfony\Component\Process\Process;

/**
 * Class PhantomJsClient
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class PhantomJsClient extends AbstractClient
{
    const ARGUMENTS = 'arguments';
    const OPTIONS = 'options';

    /**
     * @var string
     */
    protected $pathPhantomJs;

    /**
     * @var string
     */
    protected $pathScript;

    /**
     * @var array
     */
    protected $scriptOptions;

    /**
     * @param string $pathPhantomJs
     * @param string $pathScript
     * @param array  $scriptOptions
     */
    public function __construct($pathPhantomJs, $pathScript, array $scriptOptions = array())
    {
        $this->pathPhantomJs = $pathPhantomJs;
        $this->pathScript = $pathScript;
        $this->scriptOptions = $scriptOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function send($method, $url, array $options = array())
    {
        if (!is_file($this->pathPhantomJs)) {
            throw new \Exception('can not open phantomJS: '.$this->pathPhantomJs);
        }
        if (!is_file($this->pathScript)) {
            throw new \Exception('can not open script: '.$this->pathScript);
        }

        $scriptOptions = (array) $this->scriptOptions;
        if (isset($options[self::OPTIONS])) {
            $scriptOptions = array_merge($scriptOptions, (array) $options[self::OPTIONS]);
        };

        $scriptArguments = (array) $url;
        if (isset($options[self::ARGUMENTS])) {
            $scriptArguments = array_merge($scriptArguments, (array) $options[self::ARGUMENTS]);
        };

        $process = new Process(
            sprintf(
                '%s %s %s "%s"',
                $this->pathPhantomJs,
                implode(' ', $scriptOptions),
                $this->pathScript,
                implode('" "', $scriptArguments)
            )
        );
        $process->run();

        if (!is_array($result = json_decode($process->getOutput(), 1))) {
            throw new \Exception('phantom js response is not a valid json: '.$process->getErrorOutput());
        }
        if (!isset($result['headers'])) {
            $result['headers'] = array();
        }

        return new Response($result['status'], $result['content'], $this->rebuildHeader($result['headers']));
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    private function rebuildHeader(array $headers)
    {
        $header = [];

        foreach ($headers as $entry) {
            $header[$entry['name']][] = $entry['value'];
        }

        return $header;
    }
}


