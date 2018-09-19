<?php
/**
 * Created by PhpStorm.
 * User: DUTSIK
 * Date: 9/19/2018
 * Time: 11:21
 */

namespace Integration;


interface ServiceAdapterInterface
{

    /**
     * @param array $request
     *
     * @throws \HttpResponseException
     * @return string
     */
    public function get(array $request);
}