<?php

namespace Doctrine\Tests\DBAL\Driver\PDOSqlsrv;

use Doctrine\DBAL\Driver\AbstractSQLServerDriver;
use Doctrine\DBAL\Driver\PDOSqlsrv\Driver;
use Doctrine\Tests\DBAL\Driver\AbstractSQLServerDriverTest;
use PDO;
use function extension_loaded;

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

    protected function checkForSkippingTest(AbstractSQLServerDriver $driver) : void
    {
        if (extension_loaded('pdo_sqlsrv') && $driver instanceof Driver) {
            return;
        }

        $this->markTestSkipped('The test is only for the pdo_sqlsrv drivers');
    }

    public function testDriverOptions() : void
    {
        $driver = $this->getDriver();
        $this->checkForSkippingTest($driver);
        $connection = $this->getConnection($driver, [PDO::ATTR_CASE => PDO::CASE_UPPER]);

        self::assertSame(PDO::CASE_UPPER, $connection->getAttribute(PDO::ATTR_CASE));
    }
}
