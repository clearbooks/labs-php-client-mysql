<?php
namespace Clearbooks\Labs\Db;

interface ConnectionDetails
{
    public function getHost(): string;

    public function getPort(): int;

    public function getDatabaseName(): string;

    public function getUser(): string;

    public function getPassword(): string;

    public function getDriver(): string;

    public function getCharset(): string;
}
