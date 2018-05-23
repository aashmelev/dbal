<?php

namespace Doctrine\Tests\DBAL\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\AbstractSQLServerDriver;
use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Doctrine\DBAL\Platforms\SQLServer2008Platform;
use Doctrine\DBAL\Schema\SQLServerSchemaManager;

class AbstractSQLServerDriverTest extends AbstractDriverTest
{
    protected function createDriver()
    {
        return $this->getMockForAbstractClass('Doctrine\DBAL\Driver\AbstractSQLServerDriver');
    }

    protected function createPlatform()
    {
        return new SQLServer2008Platform();
    }

    protected function createSchemaManager(Connection $connection)
    {
        return new SQLServerSchemaManager($connection);
    }

    protected function getDatabasePlatformsForVersions()
    {
        return array(
            array('9', 'Doctrine\DBAL\Platforms\SQLServerPlatform'),
            array('9.00', 'Doctrine\DBAL\Platforms\SQLServerPlatform'),
            array('9.00.0', 'Doctrine\DBAL\Platforms\SQLServerPlatform'),
            array('9.00.1398', 'Doctrine\DBAL\Platforms\SQLServerPlatform'),
            array('9.00.1398.99', 'Doctrine\DBAL\Platforms\SQLServerPlatform'),
            array('9.00.1399', 'Doctrine\DBAL\Platforms\SQLServer2005Platform'),
            array('9.00.1399.0', 'Doctrine\DBAL\Platforms\SQLServer2005Platform'),
            array('9.00.1399.99', 'Doctrine\DBAL\Platforms\SQLServer2005Platform'),
            array('9.00.1400', 'Doctrine\DBAL\Platforms\SQLServer2005Platform'),
            array('9.10', 'Doctrine\DBAL\Platforms\SQLServer2005Platform'),
            array('9.10.9999', 'Doctrine\DBAL\Platforms\SQLServer2005Platform'),
            array('10.00.1599', 'Doctrine\DBAL\Platforms\SQLServer2005Platform'),
            array('10.00.1599.99', 'Doctrine\DBAL\Platforms\SQLServer2005Platform'),
            array('10.00.1600', 'Doctrine\DBAL\Platforms\SQLServer2008Platform'),
            array('10.00.1600.0', 'Doctrine\DBAL\Platforms\SQLServer2008Platform'),
            array('10.00.1600.99', 'Doctrine\DBAL\Platforms\SQLServer2008Platform'),
            array('10.00.1601', 'Doctrine\DBAL\Platforms\SQLServer2008Platform'),
            array('10.10', 'Doctrine\DBAL\Platforms\SQLServer2008Platform'),
            array('10.10.9999', 'Doctrine\DBAL\Platforms\SQLServer2008Platform'),
            array('11.00.2099', 'Doctrine\DBAL\Platforms\SQLServer2008Platform'),
            array('11.00.2099.99', 'Doctrine\DBAL\Platforms\SQLServer2008Platform'),
            array('11.00.2100', 'Doctrine\DBAL\Platforms\SQLServer2012Platform'),
            array('11.00.2100.0', 'Doctrine\DBAL\Platforms\SQLServer2012Platform'),
            array('11.00.2100.99', 'Doctrine\DBAL\Platforms\SQLServer2012Platform'),
            array('11.00.2101', 'Doctrine\DBAL\Platforms\SQLServer2012Platform'),
            array('12', 'Doctrine\DBAL\Platforms\SQLServer2012Platform'),
        );
    }

    protected function getDriver() : AbstractSQLServerDriver
    {
        return static::createDriver();
    }

    protected function checkForSkippingTest(AbstractSQLServerDriver $driver) : void
    {
        $this->markTestSkipped('The test is only for the sqlsrv and the pdo_sqlsrv drivers');
    }

    /**
     * @param mixed[] $driverOptions
     */
    protected function getConnection(AbstractSQLServerDriver $driver, array $driverOptions) : DriverConnection
    {
        return $driver->connect(
            [
                'host' => $GLOBALS['db_host'],
                'port' => $GLOBALS['db_port'],
            ],
            $GLOBALS['db_username'],
            $GLOBALS['db_password'],
            $driverOptions
        );
    }

    public function testConnectionOptions() : void
    {
        $driver = $this->getDriver();
        $this->checkForSkippingTest($driver);
        $connection = $this->getConnection($driver, ['APP' => 'APP_NAME']);
        $result     = $connection->query('select APP_NAME() as app')->fetch();

        self::assertSame('APP_NAME', $result['app']);
    }
}
