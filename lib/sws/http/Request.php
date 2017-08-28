<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/3/26 0026
 * Time: 18:02
 */

namespace sws\http;

/**
 * Class Request
 *
 * @property string $method
 * @property Uri $uri
 * @property-read string $origin
 *
 */
class Request extends BaseMessage
{
    /**
     * @var string
     */
    private $method;

    /**
     * The request URI object
     * @var Uri
     */
    private $uri;

    /**
     * Request constructor.
     * @param string $method
     * @param Uri $uri
     * @param string $protocol
     * @param string $protocolVersion
     * @param array $headers
     * @param string $body
     * @param array $cookies
     */
    public function __construct(
        string $method = 'GET', Uri $uri = null, string $protocol = 'HTTP',
        string $protocolVersion = '1.1', array $headers = [], array $cookies = [], string $body = ''
    )
    {
        parent::__construct($protocol, $protocolVersion, $headers, $cookies, $body);

        $this->method = $method ? strtoupper($method) : 'GET';
        $this->uri = $uri;

        if (!$this->headers->has('Host') || $this->uri->getHost() !== '') {
            $this->headers->set('Host', $this->uri->getHost());
        }
    }

    /**
     * @return string
     */
    protected function buildFirstLine()
    {
        // `GET /path HTTP/1.1`
        return sprintf(
            '%s %s %s/%s',
            $this->getMethod(),
            $this->uri->getPathAndQuery(),
            $this->getProtocol(),
            $this->getProtocolVersion()
        );
    }

    /**
     * build response data
     * @return string
     */
    public function toString()
    {
        // first line
        $output = $this->buildFirstLine() . self::EOL;

        // add headers
        $output .= $this->headers->toHeaderLines(1);

        // append cookies
        if ($cookie = $this->cookies->toRequestHeader()) {
            $output .= "Cookie: $cookie" . self::EOL;
        }

        $output .= self::EOL;

        return $output . $this->getBody();
    }

    /**
     * @param string $rawData
     * @return static
     */
    public static function makeByParseRawData(string $rawData)
    {
        if (!$rawData) {
            return new static();
        }

        // $rawData = trim($rawData);
        $two = explode("\r\n\r\n", $rawData, 2);

        if (!$rawHeader = $two[0] ?? '') {
            return new static();
        }

        $body = $two[1] ?? '';

        /** @var array $list */
        $list = explode("\n", trim($rawHeader));

        // e.g: `GET / HTTP/1.1`
        $first = array_shift($list);
        $data = array_map('trim', explode(' ', trim($first)));

        list($method, $uri, $protoStr) = $data;
        list($protocol, $protocolVersion) = explode('/', $protoStr);

        // other header info
        $headers = [];
        foreach ($list as $item) {
            if ($item) {
                list($name, $value) = explode(': ', trim($item));
                $headers[$name] = trim($value);
            }
        }

        $cookies = [];
        if (isset($headers['Cookie'])) {
            $cookieData = $headers['Cookie'];
            $cookies = Cookies::parseFromRawHeader($cookieData);
        }

        $port = 80;
        $host = '';
        if ($val = $headers['Host'] ?? '') {
            list($host, $port) = strpos($val, ':') ? explode(':', $val) : [$val, 80];
        }

        $path = $uri;
        $query = $fragment = '';
        if (strlen($uri) > 1) {
            $parts = parse_url($uri);
            $path = $parts['path'] ?? '';
            $query = $parts['query'] ?? '';
            $fragment = $parts['fragment'] ?? '';
        }

        $uri = new Uri($protocol, $host, (int)$port, $path, $query, $fragment);

        return new static($method, $uri, $protocol, $protocolVersion, $headers, $cookies, $body);
    }

    /**
     * `Origin: http://foo.example`
     * @return string
     */
    public function getOrigin()
    {
        return $this->headers->get('Origin', '');
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return Uri
     */
    public function getUri(): Uri
    {
        return $this->uri;
    }

    /**
     * @param Uri $uri
     */
    public function setUri(Uri $uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getUri()->getPath();
    }

}
