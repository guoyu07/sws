<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/3/26 0026
 * Time: 15:35
 */

namespace Sws\DataParser;

use Sws\WebSocket\Module\ModuleInterface;

/**
 * Interface DataParserInterface
 * @package Sws\DataParser
 *
 */
interface DataParserInterface
{
    //
    const JSON_TO_RAW = 1;
    const JSON_TO_ARRAY = 2;
    const JSON_TO_OBJECT = 3;

    /**
     * @param string $data
     * @param int $index
     * @param ModuleInterface $module
     * @return array|false
     */
    public function parse(string $data, int $index, ModuleInterface $module);
}
