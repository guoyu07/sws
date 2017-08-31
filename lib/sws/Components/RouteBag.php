<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-08-17
 * Time: 9:29
 */

namespace Sws\components;

use Sws\Module\ModuleInterface;

/**
 * Class RouteBag
 * @package Sws\components
 */
class RouteBag
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var int
     */
    public $index;

    /**
     * @var ModuleInterface
     */
    public $handler;
}