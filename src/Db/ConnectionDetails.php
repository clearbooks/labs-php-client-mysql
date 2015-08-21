<?php
namespace Clearbooks\Labs\Db;

interface ConnectionDetails
{
    /**
     * @return string
     */
    public function getHost();

    /**
     * @return int
     */
    public function getPort();

    /**
     * @return string
     */
    public function getDatabaseName();

    /**
     * @return string
     */
    public function getUser();

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @return string
     */
    public function getDriver();

    /**
     * @return string
     */
    public function getCharset();
}
