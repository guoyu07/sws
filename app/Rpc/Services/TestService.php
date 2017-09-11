<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-08-30
 * Time: 16:47
 */

namespace App\Rpc;

use Sws\Annotations\Service;

/**
 * Class TestService
 *
 * @package App\Rpc
 *
 * @Service("test")
 */
class TestService
{
    public function index()
    {
        return 'hello, this is ' . __METHOD__;
    }
}
