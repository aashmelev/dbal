<?php

namespace Doctrine\Tests\DBAL\Driver\SQLSrv;

use Doctrine\DBAL\Driver\AbstractSQLServerDriver;
use Doctrine\DBAL\Driver\SQLSrv\Driver;
use Doctrine\Tests\DBAL\Driver\AbstractSQLServerDriverTest;
use function extension_loaded;

class DriverTest extends AbstractSQLServerDriverTest
{
    public function testReturnsName()
    {
        self::assertSame('sqlsrv', $this->driver->getName());
    }

    protected function createDriver()
    {
        return new Driver();
    }

    protected function checkForSkippingTest(AbstractSQLServerDriver $driver) : void
    {
        if (extension_loaded('sqlsrv') && $driver instanceof Driver) {
            return;
        }

        $this->markTestSkipped('The test is only for the sqlsrv drivers');
    }
}
