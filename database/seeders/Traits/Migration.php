<?php

namespace Database\Seeders\Traits;

use Closure;
use DB;
use Illuminate\Database\Migrations\Migration as IlluminateMigration;

/**
 * Abstract Migration class.
 *
 * @extends IlluminateMigration
 */
abstract class Migration extends IlluminateMigration
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The table name.
     *
     * @var string|null
     */
    protected $table;

    /**
     * The table prefix.
     *
     * @var string|null
     */
    protected $prefix;

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    protected function getSchemaBuilder()
    {
        /** @var \Illuminate\Database\DatabaseManager $db */
        $db = app()->make('db');

        return $db->connection($this->hasConnection() ? $this->getConnection() : null)
            ->getSchemaBuilder();
    }

    /**
     * Set the migration connection name.
     *
     * @param  string  $connection
     * @return self
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Get the prefixed table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->hasPrefix() ? $this->prefix.$this->table : $this->table;
    }

    /**
     * Set the table name.
     *
     * @param  string  $table
     * @return self
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Set the prefix name.
     *
     * @param  string  $prefix
     * @return self
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Migrate to database.
     */
    abstract public function up();

    /**
     * Rollback the migration.
     */
    public function down()
    {
        $this->getSchemaBuilder()->dropIfExists($this->getTableName());
    }

    /**
     * Create Table Schema.
     *
     * @param  \Closure  $blueprint
     */
    protected function createSchema(Closure $blueprint)
    {
        $this->getSchemaBuilder()->create($this->getTableName(), $blueprint);
    }

    /**
     * Modify a table on the schema.
     *
     * @param  \Closure  $callback
     */
    protected function table(Closure $callback)
    {
        $this->getSchemaBuilder()->table($this->getTableName(), $callback);
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if connection exists.
     *
     * @return bool
     */
    protected function hasConnection()
    {
        return $this->isNotEmpty($this->getConnection());
    }

    /**
     * Check if table has prefix.
     *
     * @return bool
     */
    protected function hasPrefix()
    {
        return $this->isNotEmpty($this->prefix);
    }

    /**
     * Check if the value is not empty.
     *
     * @param  string  $value
     * @return bool
     */
    private function isNotEmpty($value)
    {
        return ! (is_null($value) || empty($value));
    }

    /**
     * Get jsonable column data type.
     */
    protected function jsonable(): string
    {
        $driverName = DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);
        $dbVersion = DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION);
        $isOldVersion = version_compare($dbVersion, '5.7.8', 'lt');

        return $driverName === 'mysql' && $isOldVersion ? 'text' : 'json';
    }
}
