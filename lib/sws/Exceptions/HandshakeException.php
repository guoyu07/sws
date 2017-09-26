<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-03-27
 * Time: 9:14
 */

namespace Sws\Exceptions;

use Inhere\WebSocket\protocols\Protocol;

/**
 * Class HandshakeException
 * @package Inhere\WebSocket\client
 */
class HandshakeException extends \Exception
{
    /**
     * @param string    $message
     * @param int       $code
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        if ($code === null) {
            $code = Protocol::HTTP_SERVER_ERROR;
        }

        parent::__construct($message, $code, $previous);
    }
}
