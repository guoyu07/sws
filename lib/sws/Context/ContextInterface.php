<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-08-31
 * Time: 15:19
 */

namespace Sws\Context;

/**
 * Interface ContextInterface
 * @package Sws\Context
 *
 * @property string $id The request context unique ID
 */
interface ContextInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param  string $id
     */
    public function setId($id);

    /**
     * destroy something ...
     */
    public function destroy();
}