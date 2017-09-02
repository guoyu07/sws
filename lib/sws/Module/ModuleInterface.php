<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/3/26 0026
 * Time: 15:35
 */

namespace Sws\Module;

use Sws\Application;
use Sws\Http\Request;
use Sws\Http\Response;
use Sws\Http\WSResponse;
use Sws\WebSocket\Connection;

/**
 * Interface ModuleInterface
 * @package Sws\Module
 */
interface ModuleInterface
{
    const SEND_PING = 'ping';
    const NOT_FOUND = 'notFound';
    const PARSE_ERROR = 'error';

    const DATA_JSON = 'json';
    const DATA_TEXT = 'text';

    /**
     * @param Request $request
     * @param Response $response
     * @return bool
     */
    public function validateRequest(Request $request, Response $response);

    /**
     * @param Request $request
     * @param Response $response
     */
    public function onHandshake(Request $request, Response $response);

    /**
     * @param int $id
     * @param Connection $conn
     */
    public function onOpen(int $id, Connection $conn);

    /**
     * @param int $id
     * @param Connection $conn
     * @return
     */
    public function onClose(int $id, Connection $conn);

    /**
     * @param Application $app
     * @param string $msg
     */
    public function onError(Application $app, string $msg);

    public function checkIsAllowedOrigin(string $from);

    /**
     * @param string $data
     * @param Connection $conn
     * @return mixed
     */
    public function dispatch(string $data, Connection $conn);

    /**
     * @param string $command
     * @param $handler
     * @return static
     */
    public function add(string $command, $handler);

    public function log(string $message, array $data = [], string $type = 'info');

    public function isJsonType();

    /**
     * @param $data
     * @param string $msg
     * @param int $code
     * @param bool $doSend
     * @return int|WSResponse
     */
    public function respond($data, string $msg = 'success', int $code = 0, bool $doSend = true);

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getOption(string $key, $default = null);

    /**
     * @param Application $app
     * @return static
     */
    public function setApp(Application $app);

    /**
     * @return Application
     */
    public function getApp(): Application;
}
