<?php
/**
 * Created by PhpStorm.
 * User: DUTSIK
 * Date: 9/19/2018
 * Time: 11:24
 */

namespace Integration;

/*
 *  This class retrieves data from SomeService
 */
class SomeServiceAdapter implements ServiceAdapterInterface
{
    /**
     * var string
     */
    private $host;
    /**
     * var string
     */
    private $user;
    /**
     * var string
     */
    private $password;
    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param array $request
     * @return string
     */
    public function get(array $request)
    {
        return json_encode($request);
    }
}