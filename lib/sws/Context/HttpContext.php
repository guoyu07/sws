<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-08-31
 * Time: 15:16
 */

namespace Sws\Context;

use Sws\Http\Request;
use Sws\Http\Response;

use inhere\server\helpers\ServerHelper;
use Swoole\Http\Request as SwRequest;
use Swoole\Http\Response as SwResponse;

use Sws\Components\HttpHelper;

/**
 * Class HttpContext
 * @package Sws\Context
 */
class HttpContext extends Context
{
    /**
     * @var array
     */
    private $args = [];

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var SwRequest
     */
    private $swRequest;

    /**
     * @var SwResponse
     */
    private $swResponse;

    /**
     * @param SwRequest $swRequest
     * @param SwResponse $swResponse
     * @return static
     */
    public static function make(SwRequest $swRequest, SwResponse $swResponse)
    {
        return new static($swRequest, $swResponse);
    }

    /**
     * Context constructor.
     * @param SwRequest $swRequest
     * @param SwResponse $swResponse
     */
    public function __construct(SwRequest $swRequest, SwResponse $swResponse)
    {
        parent::__construct(ServerHelper::genRequestId($swRequest->fd));

        $this->request = HttpHelper::createRequest($swRequest);
        $this->response = HttpHelper::createResponse();

        $this->swRequest = $swRequest;
        $this->swResponse = $swResponse;
    }

    public function getLogger()
    {

    }

    /*******************************************************************************
     * getter/setter methods
     ******************************************************************************/

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return SwRequest
     */
    public function getSwRequest(): SwRequest
    {
        return $this->swRequest;
    }

    /**
     * @param SwRequest $swRequest
     */
    public function setSwRequest(SwRequest $swRequest)
    {
        $this->swRequest = $swRequest;
    }

    /**
     * @return SwResponse
     */
    public function getSwResponse(): SwResponse
    {
        return $this->swResponse;
    }

    /**
     * @param SwResponse $swResponse
     */
    public function setSwResponse(SwResponse $swResponse)
    {
        $this->swResponse = $swResponse;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args)
    {
        $this->args = $args;
    }
}