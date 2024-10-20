<?php

namespace MagicObject\Util\Database;

use Exception;
use MagicObject\Database\PicoDatabase;
use MagicObject\Database\PicoDatabaseQueryBuilder;
use MagicObject\Database\PicoDatabaseType;
use MagicObject\Database\PicoPageData;
use MagicObject\Database\PicoTableInfo;
use MagicObject\MagicObject;
use MagicObject\SecretObject;
use PDO;

/**
 * Class PicoDatabaseUtilMySql
 *
 * Utility class for managing MySQL database operations in the framework.
 * This class provides methods for retrieving table structures, generating SQL
 * statements for creating tables, dumping data into SQL insert statements,
 * and importing data from one database to another.
 *
 * Key Functionalities:
 * - Retrieve and display column information for tables.
 * - Generate SQL statements to create tables based on existing structures.
 * - Dump data from various sources into SQL insert statements.
 * - Facilitate the import of data between source and target databases, including
 *   handling pre and post-import scripts.
 * - Ensure data integrity by fixing types during the import process.
 *
 * @author Kamshory
 * @package MagicObject\Util\Database
 * @link https://github.com/Planetbiru/MagicObject
 */
class PicoDatabaseUtilMySql //NOSONAR
{
    const KEY_NAME = "name";

    /**
     * Retrieves a list of columns for a specified table.
     *
     * @param PicoDatabase $database Database connection.
     * @param string $picoTableName Table name.
     * @return array An array of column details.
     */
    public static function getColumnList($database, $picoTableName)
    {
        $sql = "SHOW COLUMNS FROM $picoTableName";
        return $database->fetchAll($sql);
    }

    /**
     * Gets the auto-increment keys from the provided table information.
     *
     * @param PicoTableInfo $tableInfo Table information.
     * @return array An array of auto-increment key names.
     */
    public static function getAutoIncrementKey($tableInfo)
    {
        $autoIncrement = $tableInfo->getAutoIncrementKeys();
        $autoIncrementKeys = array();
        if(is_array($autoIncrement) && !empty($autoIncrement))
        {
            foreach($autoIncrement as $col)
            {
                if($col["strategy"] == 'GenerationType.IDENTITY')
                {
                    $autoIncrementKeys[] = $col["name"];
                }
            }
        }
        return $autoIncrementKeys;
    }

    /**
     * Dumps the structure of a table as a SQL statement.
     *
     * @param PicoTableInfo $tableInfo Table information.
     * @param string $picoTableName Table name.
     * @param bool $createIfNotExists Whether to add "IF NOT EXISTS" in the create statement.
     * @param bool $dropIfExists Whether to add "DROP TABLE IF EXISTS" before the create statement.
     * @param string $engine Storage engine (default is 'InnoDB').
     * @param string $charset Character set (default is 'utf8mb4').
     * @return string SQL statement to create the table.
     */
    public static function dumpStructure($tableInfo, $picoTableName, $createIfNotExists = false, $dropIfExists = false, $engine = 'InnoDB', $charset = 'utf8mb4')
    {
        $query = array();
        $columns = array();
        if($dropIfExists)
        {
            $query[] = "-- DROP TABLE IF EXISTS `$picoTableName`;";
            $query[] = "";
        }
        $createStatement = "";

        $createStatement = "CREATE TABLE";
        if($createIfNotExists)
        {
            $createStatement .= " IF NOT EXISTS";
        }

        $autoIncrementKeys = self::getAutoIncrementKey($tableInfo);

        $query[] = "$createStatement `$picoTableName` (";

        foreach($tableInfo->getColumns() as $column)
        {
            $columns[] = self::createColumn($column);
        }
        $query[] = implode(",\r\n", $columns);
        $query[] = ") ENGINE=$engine DEFAULT CHARSET=$charset;";

        $pk = $tableInfo->getPrimaryKeys();
        if(isset($pk) && is_array($pk) && !empty($pk))
        {
            $query[] = "";
            $query[] = "ALTER TABLE `$picoTableName`";
            foreach($pk as $primaryKey)
            {
                $query[] = "\tADD PRIMARY KEY (`$primaryKey[name]`)";
            }
            $query[] = ";";
        }

        foreach($tableInfo->getColumns() as $column)
        {
            if(isset($autoIncrementKeys) && is_array($autoIncrementKeys) && in_array($column[self::KEY_NAME], $autoIncrementKeys))
            {
                $query[] = "";
                $query[] = "ALTER TABLE `$picoTableName` \r\n\tMODIFY ".trim(self::createColumn($column), " \r\n\t ")." AUTO_INCREMENT";
                $query[] = ";";
            }
        }

        return implode("\r\n", $query);
    }

    /**
     * Creates a column definition for a SQL statement.
     *
     * @param array $column Column details.
     * @return string SQL column definition.
     */
    public static function createColumn($column)
    {
        $col = array();
        $col[] = "\t";
        $col[] = "`".$column[self::KEY_NAME]."`";
        $col[] = $column['type'];
        if(isset($column['nullable']) && strtolower(trim($column['nullable'])) == 'true')
        {
            $col[] = "NULL";
        }
        else
        {
            $col[] = "NOT NULL";
        }
        if(isset($column['default_value']))
        {
            $defaultValue = $column['default_value'];
            $defaultValue = self::fixDefaultValue($defaultValue, $column['type']);
            $col[] = "DEFAULT $defaultValue";
        }
        return implode(" ", $col);
    }

    /**
     * Fixes the default value for SQL insertion based on its type.
     *
     * @param string $defaultValue Default value to fix.
     * @param string $type Data type of the column.
     * @return string Fixed default value.
     */
    public static function fixDefaultValue($defaultValue, $type)
    {
        if(strtolower($defaultValue) == 'true' || strtolower($defaultValue) == 'false' || strtolower($defaultValue) == 'null')
        {
            return $defaultValue;
        }
        if(stripos($type, 'enum') !== false || stripos($type, 'char') !== false || stripos($type, 'text') !== false || stripos($type, 'int') !== false || stripos($type, 'float') !== false || stripos($type, 'double') !== false)
        {
            return "'".$defaultValue."'";
        }
        return $defaultValue;
    }

    /**
     * Dumps data from various sources into SQL insert statements.
     *
     * @param array $columns Columns of the target table.
     * @param string $picoTableName Table name.
     * @param MagicObject|PicoPageData $data Data to dump.
     * @return string|null SQL insert statements or null if no data.
     */
    public static function dumpData($columns, $picoTableName, $data) //NOSONAR
    {
        if($data instanceof PicoPageData && isset($data->getResult()[0]))
        {
            return self::dumpRecords($columns, $picoTableName, $data->getResult());
        }
        else if($data instanceof MagicObject)
        {
            return self::dumpRecords($columns, $picoTableName, array($data));
        }
        else if(is_array($data) && isset($data[0]) && $data[0] instanceof MagicObject)
        {
            return self::dumpRecords($columns, $picoTableName, $data);
        }
        return null;
    }

    /**
     * Dumps multiple records into SQL insert statements.
     *
     * @param array $columns Columns of the target table.
     * @param string $picoTableName Table name.
     * @param MagicObject[] $data Data records.
     * @return string SQL insert statements.
     */
    public static function dumpRecords($columns, $picoTableName, $data)
    {
        $result = "";
        foreach($data as $record)
        {
            $result .= self::dumpRecord($columns, $picoTableName, $record).";\r\n";
        }
        return $result;
    }

    /**
     * Dumps a single record into an SQL insert statement.
     *
     * @param array $columns Columns of the target table.
     * @param string $picoTableName Table name.
     * @param MagicObject $record Data record.
     * @return string SQL insert statement.
     */
    public static function dumpRecord($columns, $picoTableName, $record)
    {
        $value = $record->valueArray();
        $rec = array();
        foreach($value as $key=>$val)
        {
            if(isset($columns[$key]))
            {
                $rec[$columns[$key][self::KEY_NAME]] = $val;
            }
        }
        $queryBuilder = new PicoDatabaseQueryBuilder(PicoDatabaseType::DATABASE_TYPE_MYSQL);
        $queryBuilder->newQuery()
            ->insert()
            ->into($picoTableName)
            ->fields(array_keys($rec))
            ->values(array_values($rec));

        return $queryBuilder->toString();
    }

    /**
     * Shows the columns of a specified table.
     *
     * @param PicoDatabase $database Database connection.
     * @param string $tableName Table name.
     * @return string[] An associative array of column names and their types.
     */
    public static function showColumns($database, $tableName)
    {
        $sql = "SHOW COLUMNS FROM $tableName";
        $result = $database->fetchAll($sql, PDO::FETCH_ASSOC);

        $columns = array();
        foreach($result as $row)
        {
            $columns[$row['Field']] = $row['Type'];
        }
        return $columns;
    }

    /**
     * Autoconfigure import data
     *
     * @param SecretObject $config Configuration
     * @return SecretObject
     */
    public static function autoConfigureImportData($config)
    {
        $databaseConfigSource = $config->getDatabaseSource();
        $databaseConfigTarget = $config->getDatabaseTarget();

        $databaseSource = new PicoDatabase($databaseConfigSource);
        $databaseTarget = new PicoDatabase($databaseConfigTarget);
        try
        {
            $databaseSource->connect();
            $databaseTarget->connect();
            $tables = $config->getTable();

            $existingTables = array();
            foreach($tables as $tb)
            {
                $existingTables[] = $tb->getTarget();
            }

            $sourceTableList = $databaseSource->fetchAll("SHOW TABLES", PDO::FETCH_NUM);
            $targetTableList = $databaseTarget->fetchAll("SHOW TABLES", PDO::FETCH_NUM);

            $sourceTables = call_user_func_array('array_merge', $sourceTableList);
            $targetTables = call_user_func_array('array_merge', $targetTableList);

            foreach($targetTables as $target)
            {
                $tables = self::updateConfigTable($databaseSource, $databaseTarget, $tables, $sourceTables, $target, $existingTables);
            }
            $config->setTable($tables);
        }
        catch(Exception $e)
        {
            error_log($e->getMessage());
        }
        return $config;
    }

    /**
     * Automatically configures import data settings from one database to another.
     *
     * @param PicoDatabase $source Source database connection.
     * @param PicoDatabase $target Target database connection.
     * @param string $sourceTable Source table name.
     * @param string $targetTable Target table name.
     * @param array $options Additional options for import configuration.
     * @return array Configured options for import.
     */
    public static function updateConfigTable($databaseSource, $databaseTarget, $tables, $sourceTables, $target, $existingTables)
    {
        if(!in_array($target, $existingTables))
        {
            $tableInfo = new SecretObject();
            if(in_array($target, $sourceTables))
            {
                // ada di database sumber
                $tableInfo->setTarget($target);
                $tableInfo->setSource($target);
                $map = self::createMapTemplate($databaseSource, $databaseTarget, $target);
                if(isset($map) && !empty($map))
                {
                    $tableInfo->setMap($map);
                }
            }
            else
            {
                // tidak ada di database sumber
                $tableInfo->setTarget($target);
                $tableInfo->setSource("???");
            }
            $tables[] = $tableInfo;
        }
        return $tables;
    }

    /**
     * Create map template
     *
     * @param PicoDatabase $databaseSource Source database
     * @param PicoDatabase $databaseTarget Target database
     * @param string $target Target table
     * @return string[]
     */
    public static function createMapTemplate($databaseSource, $databaseTarget, $target)
    {
        $targetColumns = array_keys(self::showColumns($databaseTarget, $target));
        $sourceColumns = array_keys(self::showColumns($databaseSource, $target));
        $map = array();
        foreach($targetColumns as $column)
        {
            if(!in_array($column, $sourceColumns))
            {
                $map[] = "$column : ???";
            }
        }
        return $map;
    }

    /**
     * Imports data from the source database to the target database.
     *
     * @param PicoDatabase $source Source database connection.
     * @param PicoDatabase $target Target database connection.
     * @param string $sourceTable Source table name.
     * @param string $targetTable Target table name.
     * @param array $options Options for import operation.
     * @return void
     */
    public static function importData($config, $callbackFunction)
    {
        $databaseConfigSource = $config->getDatabaseSource();
        $databaseConfigTarget = $config->getDatabaseTarget();

        $databaseSource = new PicoDatabase($databaseConfigSource);
        $databaseTarget = new PicoDatabase($databaseConfigTarget);
        try
        {
            $databaseSource->connect();
            $databaseTarget->connect();
            $tables = $config->getTable();
            $maxRecord = $config->getMaximumRecord();

            // query pre import data
            foreach($tables as $tableInfo)
            {
                $tableNameTarget = $tableInfo->getTarget();
                $tableNameSource = $tableInfo->getSource();
                $preImportScript = $tableInfo->getPreImportScript();
                if(self::isNotEmpty($preImportScript))
                {
                    foreach($preImportScript as $sql)
                    {
                        call_user_func($callbackFunction, $sql, $tableNameSource, $tableNameTarget);
                    }
                }
            }

            // import data
            foreach($tables as $tableInfo)
            {
                $tableNameTarget = $tableInfo->getTarget();
                $tableNameSource = $tableInfo->getSource();
                self::importDataTable($databaseSource, $databaseTarget, $tableNameSource, $tableNameTarget, $tableInfo, $maxRecord, $callbackFunction);
            }

            // query post import data
            foreach($tables as $tableInfo)
            {
                $tableNameTarget = $tableInfo->getTarget();
                $tableNameSource = $tableInfo->getSource();
                $postImportScript = $tableInfo->getPostImportScript();
                if(self::isNotEmpty($postImportScript))
                {
                    foreach($postImportScript as $sql)
                    {
                        call_user_func($callbackFunction, $sql, $tableNameSource, $tableNameTarget);
                    }
                }
            }
        }
        catch(Exception $e)
        {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Check if array is not empty
     *
     * @param array $array Array to be checked
     * @return bool
     */
    public static function isNotEmpty($array)
    {
        return $array != null && is_array($array) && !empty($array);
    }

    /**
     * Import table
     *
     * @param PicoDatabase $databaseSource Source database
     * @param PicoDatabase $databaseTarget Target database
     * @param string $tableName Table name
     * @param SecretObject $tableInfo Table information
     * @param int $maxRecord Maximum record per query
     * @param callable $callbackFunction Callback function
     * @return bool
     */
    public static function importDataTable($databaseSource, $databaseTarget, $tableNameSource, $tableNameTarget, $tableInfo, $maxRecord, $callbackFunction)
    {
        $maxRecord = self::getMaxRecord($tableInfo, $maxRecord);
        try
        {
            $columns = self::showColumns($databaseTarget, $tableNameTarget);
            $queryBuilderSource = new PicoDatabaseQueryBuilder($databaseSource);
            $sourceTable = $tableInfo->getSource();
            $queryBuilderSource->newQuery()
                ->select("*")
                ->from($sourceTable);
            $stmt = $databaseSource->query($queryBuilderSource);
            $records = array();
            while($data = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
            {
                $data = self::processDataMapping($data, $columns, $tableInfo->getMap());
                if(count($records) < $maxRecord)
                {
                    $records[] = $data;
                }
                else
                {
                    if(isset($callbackFunction) && is_callable($callbackFunction))
                    {
                        $sql = self::insert($tableNameTarget, $records);
                        call_user_func($callbackFunction, $sql, $tableNameSource, $tableNameTarget);
                    }
                    // reset buffer
                    $records = array();
                }
            }
            if(!empty($records) && isset($callbackFunction) && is_callable($callbackFunction))
            {
                $sql = self::insert($tableNameTarget, $records);
                call_user_func($callbackFunction, $sql, $tableNameSource, $tableNameTarget);
            }
        }
        catch(Exception $e)
        {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Get maximum record
     *
     * @param SecretObject $tableInfo Table information
     * @param int $maxRecord Maximum record per query
     * @return int
     */
    public static function getMaxRecord($tableInfo, $maxRecord)
    {
        if($tableInfo->getMaximumRecord() != null)
        {
            $maxRecord = $tableInfo->getMaximumRecord();
        }
        if($maxRecord < 1)
        {
            $maxRecord = 1;
        }
        return $maxRecord;
    }

    /**
     * Process data mapping
     *
     * @param array $data
     * @param SecretObject[] $maps Maps
     * @return array
     */
    public static function processDataMapping($data, $columns, $maps)
    {
        if(isset($maps) && is_array($maps))
        {
            foreach($maps as $map)
            {
                $arr = explode(':', $map, 2);
                $target = trim($arr[0]);
                $source = trim($arr[1]);
                $data[$target] = $data[$source];
                unset($data[$source]);
            }
        }
        $data = array_intersect_key($data, array_flip(array_keys($columns)));
        $data = self::fixImportData($data, $columns);
        return $data;
    }

    /**
     * Fix import data
     *
     * @param mixed[] $data Data
     * @param string[] $columns Columns
     * @return mixed[]
     */
    public static function fixImportData($data, $columns)
    {
        foreach($data as $name=>$value)
        {
            if(isset($columns[$name]))
            {
                $type = $columns[$name];
                if(strtolower($type) == 'tinyint(1)' || strtolower($type) == 'boolean' || strtolower($type) == 'bool')
                {
                    $data = self::fixBooleanData($data, $name, $value);
                }
                else if(stripos($type, 'integer') !== false || stripos($type, 'int(') !== false)
                {
                    $data = self::fixIntegerData($data, $name, $value);
                }
                else if(stripos($type, 'float') !== false || stripos($type, 'double') !== false || stripos($type, 'decimal') !== false)
                {
                    $data = self::fixFloatData($data, $name, $value);
                }
            }
        }
        return $data;
    }

    /**
     * Fix data
     *
     * @param mixed $value Value
     * @return string
     */
    public static function fixData($value)
    {
        $ret = null;
        if (is_string($value))
        {
            $ret = "'" . addslashes($value) . "'";
        }
        else if(is_bool($value))
        {
            $ret = $value === true ? 'true' : 'false';
        }
        else if ($value === null)
        {
            $ret = "null";
        }
        else
        {
            $ret = $value;
        }
        return $ret;
    }

    /**
     * Fix boolean data
     *
     * @param mixed[] $data Data
     * @param string $name Name
     * @param mixed $value Value
     * @return mixed[]
     */
    public static function fixBooleanData($data, $name, $value)
    {
        if($value === null || $value === '')
        {
            $data[$name] = null;
        }
        else
        {
            $data[$name] = $data[$name] == 1 ? true : false;
        }
        return $data;
    }

    /**
     * Fix integer data
     *
     * @param mixed[] $data Data
     * @param string $name Name
     * @param mixed $value Value
     * @return mixed[]
     */
    public static function fixIntegerData($data, $name, $value)
    {
        if($value === null || $value === '')
        {
            $data[$name] = null;
        }
        else
        {
            $data[$name] = intval($data[$name]);
        }
        return $data;
    }

    /**
     * Fix float data
     *
     * @param mixed[] $data Data
     * @param string $name Name
     * @param mixed $value Value
     * @return mixed[]
     */
    public static function fixFloatData($data, $name, $value)
    {
        if($value === null || $value === '')
        {
            $data[$name] = null;
        }
        else
        {
            $data[$name] = floatval($data[$name]);
        }
        return $data;
    }

    /**
     * Create query insert with multiple record
     *
     * @param string $tableName Table name
     * @param array $data Data
     * @return string
     */
    public static function insert($tableName, $data)
    {
        // Kumpulkan semua kolom
        $columns = array();
        foreach ($data as $record) {
            $columns = array_merge($columns, array_keys($record));
        }
        $columns = array_unique($columns);

        // Buat placeholder untuk prepared statement
        $placeholdersArr = array_fill(0, count($columns), '?');
        $placeholders = '(' . implode(', ', $placeholdersArr) . ')';

        // Buat query INSERT
        $query = "INSERT INTO $tableName (" . implode(', ', $columns) . ") \r\nVALUES \r\n".
        implode(",\r\n", array_fill(0, count($data), $placeholders));

        // Siapkan nilai untuk bind
        $values = array();
        foreach ($data as $record) {
            foreach ($columns as $column) {
                $values[] = isset($record[$column]) && $record[$column] !== null ? $record[$column] : null;
            }
        }

        // Fungsi untuk menambahkan single quote jika elemen adalah string

        // Format elemen array
        $formattedElements = array_map(function($element){
            return self::fixData($element);
        }, $values);

        // Ganti tanda tanya dengan elemen array yang telah diformat
        return vsprintf(str_replace('?', '%s', $query), $formattedElements);
    }
}