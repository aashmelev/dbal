<?php

namespace Doctrine\Tests\DBAL\Driver\PDOSqlsrv;

use Doctrine\DBAL\Driver\PDOSqlsrv\Driver;
use Doctrine\Tests\DBAL\Driver\AbstractSQLServerDriverTest;

class DriverTest extends AbstractSQLServerDriverTest
{
    public function testReturnsName()
    {
        self::assertSame('pdo_sqlsrv', $this->driver->getName());
    }

    /**
     * Testing of obtaining DSN parameters
     */
    public function testReturnsDsnParams() : void
    {
        $driver       = new \ReflectionClass($this->driver);
        $getDsnParams = $driver->getMethod('getDsnParams');
        $getDsnParams->setAccessible(true);

        $params = [
            'NotDsnParam' => 'The parameter should not be',
            'app' => 'The parameter must be in uppercase',
            'MultipleActiveResultSets' => 'The parameter must be unchanged',
        ];

        self::assertSame([
            'APP' => 'The parameter must be in uppercase',
            'MultipleActiveResultSets' => 'The parameter must be unchanged',
        ], $getDsnParams->invokeArgs($this->driver, [$params]));
    }

    protected function createDriver()
    {
        return new Driver();
    }
}
