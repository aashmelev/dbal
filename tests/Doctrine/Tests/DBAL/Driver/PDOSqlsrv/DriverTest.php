<?php

namespace Doctrine\Tests\DBAL\Driver\PDOSqlsrv;

use Doctrine\DBAL\Driver\PDOSqlsrv\Driver;
use Doctrine\Tests\DBAL\Driver\AbstractSQLServerDriverTest;
use PDO;

class DriverTest extends AbstractSQLServerDriverTest
{
    public function testReturnsName()
    {
        self::assertSame('pdo_sqlsrv', $this->driver->getName());
    }

    protected function createDriver()
    {
        return new Driver();
    }

    public function testConnectionOptions()
    {
        $this->skipWhenNotUsingPdoSqlsrv();

        $connection = $this->getConnection(['APP' => 'APP_NAME']);
        $result     = $connection->query('select APP_NAME() as app')->fetch();

        self::assertSame('APP_NAME', $result['app']);
    }

    public function testDriverOptions()
    {
        $this->skipWhenNotUsingPdoSqlsrv();

        $connection = $this->getConnection([PDO::ATTR_CASE => PDO::CASE_UPPER]);

        self::assertSame(PDO::CASE_UPPER, $connection->getAttribute(PDO::ATTR_CASE));
    }

    private function getConnection($driverOptions)
    {
        return $this->createDriver()->connect(
            [
                'host' => $GLOBALS['db_host'],
                'port' => $GLOBALS['db_port'],
            ],
            $GLOBALS['db_username'],
            $GLOBALS['db_password'],
            $driverOptions
        );
    }

    /**
     * @throws \PHPUnit_Framework_SkippedTestError
     */
    private function skipWhenNotUsingPdoSqlsrv()
    {
        if (isset($GLOBALS['db_type']) && $GLOBALS['db_type'] === 'pdo_sqlsrv') {
            return;
        }

        $this->markTestSkipped('Test enabled only when using pdo_sqlsrv specific phpunit.xml');
    }
}
