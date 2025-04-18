<?php

namespace MagicObject\Database;

use PDO;

/**
 * Class PicoDatabaseQueryBuilder
 * 
 * A query builder for constructing SQL statements programmatically. This class 
 * facilitates the creation of various SQL commands including SELECT, INSERT, 
 * UPDATE, and DELETE, while managing database-specific nuances.
 * 
 * **Example:**
 * ```php
 * <?php
 * $id = 100;
 * $db = new PicoDatabase($credentials);
 * $db->connect();
 * $query = new PicoDatabaseQueryBuilder($db);
 * $query
 *     ->select("*")
 *     ->from("client")
 *     ->where("client_id = ?", $id)
 * ;
 * $data = $db->fetch($query);
 * echo $data['client_id']."\r\n"; // Client ID
 * echo $data['name']."\r\n"; // Client name 
 * ```
 *
 * @author Kamshory
 * @package MagicObject\Database
 * @link https://github.com/Planetbiru/MagicObject
 */
class PicoDatabaseQueryBuilder // NOSONAR
{
	/**
     * Buffer to hold the constructed SQL query.
     *
     * @var string
     */
    private $buffer = "";

    /**
     * Indicates whether limit and offset have been set.
     *
     * @var bool
     */
    private $limitOffset = false;

    /**
     * The limit for the number of results.
     *
     * @var int
     */
    private $limit = 0;

    /**
     * The offset for the results.
     *
     * @var int
     */
    private $offset = 0;

    /**
     * The type of database being used.
     *
     * @var string
     */
    private $databaseType = "mysql";

    /**
     * Flag indicating if values have been set.
     *
     * @var bool
     */
    private $hasValues = false;

    /**
     * Initializes a new instance of the PicoDatabaseQueryBuilder class.
     *
     * This constructor accepts various types of database connections:
     * - If a `PicoDatabase` instance is provided, the database type is retrieved from it.
     * - If a `PDO` instance is provided, the driver name is used to determine the database type.
     * - If a string is provided, it is assumed to be the database type.
     *
     * @param PicoDatabase|PDO|string $database The database connection or type.
     */
    public function __construct($database)
    {
        if ($database instanceof PicoDatabase) {
            $this->databaseType = $database->getDatabaseType();
        } elseif ($database instanceof PDO) {
            $driver = $database->getAttribute(PDO::ATTR_DRIVER_NAME);
            $this->databaseType = PicoDatabase::getDbType($driver);
        } elseif (is_string($database)) {
            $this->databaseType = $database;
        }
    }

    /**
     * Get the value of the database type.
     *
     * @return string The database type.
     */
    public function getDatabaseType()
    {
        return $this->databaseType;
    }

    /**
     * Check if the database type is MySQL or MariaDB.
     *
     * @return bool true if the database type is MySQL or MariaDB, false otherwise.
     */
    public function isMySql()
    {
        return strcasecmp($this->databaseType, PicoDatabaseType::DATABASE_TYPE_MYSQL) == 0 || 
               strcasecmp($this->databaseType, PicoDatabaseType::DATABASE_TYPE_MARIADB) == 0;
    }

    /**
     * Check if the database type is PostgreSQL.
     *
     * @return bool true if the database type is PostgreSQL, false otherwise.
     */
    public function isPgSql()
    {
        return strcasecmp($this->databaseType, PicoDatabaseType::DATABASE_TYPE_PGSQL) == 0;
    }

	/**
     * Check if the database type is SQLite.
     *
     * @return bool true if the database type is SQLite, false otherwise.
     */
    public function isSqlite()
    {
        return strcasecmp($this->databaseType, PicoDatabaseType::DATABASE_TYPE_SQLITE) == 0;
    }
	
	/**
     * Check if the database type is SQL Server.
     *
     * @return bool true if the database type is SQLite, false otherwise.
     */
    public function isSqlServer()
    {
        return strcasecmp($this->databaseType, PicoDatabaseType::DATABASE_TYPE_SQLSERVER) == 0;
    }

    /**
     * Initialize a new SQL query by resetting the buffer, limit, and offset.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function newQuery()
    {
        $this->buffer = "";
        $this->limitOffset = false;
        $this->hasValues = false;
        return $this;
    }

    /**
     * Create an insert statement.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function insert()
    {
        $this->buffer = "INSERT \r\n";
        return $this;
    }

    /**
     * Specify the table to insert into.
     *
     * @param string $query The name of the table.
     * @return self Returns the current instance for method chaining.
     */
    public function into($query)
    {
        $this->buffer .= "INTO $query\r\n";
        return $this;
    }

    /**
     * Specify the fields to insert values into.
     *
     * @param mixed $query The field names (string or array).
     * @return self Returns the current instance for method chaining.
     */
    public function fields($query)
    {
        if (is_array($query)) {
            $this->buffer .= "(".implode(", ", $query).") \r\n";
        } else {
            $this->buffer .= "$query \r\n";
        }
        return $this;
    }

    /**
     * Specify the values to be inserted.
     *
     * @param mixed $query The values to insert (string, array, or multiple parameters).
     * @return self Returns the current instance for method chaining.
     */
    public function values($query)
    {
        $count = func_num_args();
        $isArray = is_array($query) && $count === 1;
        $values = "";

        if ($isArray) {
            $vals = array_map(array($this, 'escapeValue'), $query);
            $values = "(".implode(", ", $vals).")";
        } else {
            if ($count > 1) {
                $params = array();
                for ($i = 0; $i < $count; $i++) {
                    $params[] = func_get_arg($i);
                }
                $values = $this->createMatchedValue($params);
            } else {
                $values = $query;
            }
        }

        if ($this->hasValues) {
            $this->buffer .= ",\r\n$values";
        } else {
            $this->buffer .= "VALUES $values";
        }

        $this->hasValues = true;
        return $this;
    }

    /**
     * Create a select statement.
     *
     * @param string $query The fields to select (optional).
     * @return self Returns the current instance for method chaining.
     */
    public function select($query = "")
    {
        $this->buffer .= "SELECT $query\r\n";
        return $this;
    }

    /**
     * Create an alias for a field or table.
     *
     * @param string $query The alias to use.
     * @return self Returns the current instance for method chaining.
     */
    public function alias($query)
    {
        $this->buffer .= "AS $query\r\n";
        return $this;
    }

    /**
     * Create a delete statement.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function delete()
    {
        $this->buffer .= "DELETE \r\n";
        return $this;
    }

    /**
     * Specify the source table for the query.
     *
     * @param string $query The name of the table.
     * @return self Returns the current instance for method chaining.
     */
    public function from($query)
    {
        $this->buffer .= "FROM $query \r\n";
        return $this;
    }

    /**
     * Create a join statement.
     *
     * @param string $query The join details.
     * @return self Returns the current instance for method chaining.
     */
    public function join($query)
    {
        $this->buffer .= "JOIN $query \r\n";
        return $this;
    }

    /**
     * Create an inner join statement.
     *
     * @param string $query The join details.
     * @return self Returns the current instance for method chaining.
     */
    public function innerJoin($query)
    {
        $this->buffer .= "INNER JOIN $query \r\n";
        return $this;
    }

    /**
     * Create an outer join statement.
     *
     * @param string $query The join details.
     * @return self Returns the current instance for method chaining.
     */
    public function outerJoin($query)
    {
        $this->buffer .= "OUTER JOIN $query \r\n";
        return $this;
    }

    /**
     * Create a left outer join statement.
     *
     * @param string $query The join details.
     * @return self Returns the current instance for method chaining.
     */
    public function leftOuterJoin($query)
    {
        $this->buffer .= "LEFT OUTER JOIN $query \r\n";
        return $this;
    }

    /**
     * Create a left join statement.
     *
     * @param string $query The join details.
     * @return self Returns the current instance for method chaining.
     */
    public function leftJoin($query)
    {
        $this->buffer .= "LEFT JOIN $query \r\n";
        return $this;
    }

    /**
     * Create a right join statement.
     *
     * @param string $query The join details.
     * @return self Returns the current instance for method chaining.
     */
    public function rightJoin($query)
    {
        $this->buffer .= "RIGHT JOIN $query \r\n";
        return $this;
    }

	/**
	 * Create an ON statement for JOIN operations.
	 *
	 * @param mixed $query The join condition(s).
	 * @return self Returns the current instance for method chaining.
	 */
	public function on($query)
	{
		$count = func_num_args();
		if ($count > 1) {
			$params = array();
			for ($i = 0; $i < $count; $i++) {
				$params[] = func_get_arg($i);
			}
			$buffer = $this->createMatchedValue($params);
			$this->buffer .= "ON $buffer \r\n";
		} else {
			$this->buffer .= "ON $query \r\n";
		}
		return $this;
	}

	/**
	 * Create an UPDATE statement for a specified table.
	 *
	 * @param string $query The name of the table to update.
	 * @return self Returns the current instance for method chaining.
	 */
	public function update($query)
	{
		$this->buffer .= "UPDATE $query \r\n";
		return $this;
	}

	/**
	 * Specify the fields and values to set in the UPDATE statement.
	 *
	 * @param mixed $query The field(s) and value(s) to set.
	 * @return self Returns the current instance for method chaining.
	 */
	public function set($query)
	{
		$count = func_num_args();
		if ($count > 1) {
			$params = array();
			for ($i = 0; $i < $count; $i++) {
				$params[] = func_get_arg($i);
			}
			$buffer = $this->createMatchedValue($params);
			$this->buffer .= "SET $buffer \r\n";
		} else {
			$this->buffer .= "SET $query \r\n";
		}
		return $this;
	}

	/**
	 * Create a WHERE statement for filtering results.
	 *
	 * @param string $query The condition(s) for the WHERE clause.
	 * @return self Returns the current instance for method chaining.
	 */
	public function where($query)
	{
		$count = func_num_args();
		if ($count > 1) {
			$params = array();
			for ($i = 0; $i < $count; $i++) {
				$params[] = func_get_arg($i);
			}
			$buffer = $this->createMatchedValue($params);
			$this->buffer .= "WHERE $buffer \r\n";
		} else {
			$this->buffer .= "WHERE $query \r\n";
		}
		return $this;
	}

	/**
     * Binds SQL parameters by replacing placeholders with actual values.
     *
     * This function accepts multiple arguments, where the first argument 
     * is expected to be a SQL string containing `?` placeholders, and 
     * subsequent arguments are the values to replace them.
     *
     * @return string The formatted SQL query with values replaced.
     */
    public function bindSqlParams()
    {
        $count = func_num_args();
        if ($count > 1) {
            $params = array();
            for ($i = 0; $i < $count; $i++) {
                $params[] = func_get_arg($i);
            }
            return $this->createMatchedValue($params);
        }
        return "";
    }

	/**
	 * Create a matched value string from the given arguments.
	 *
	 * @param array $args The arguments to match.
	 * @return string The formatted string.
	 */
	public function createMatchedValue($args)
	{
		$result = "";
		if (count($args) > 1) {
			$format = $args[0];
			$formats = explode('?', $format);
			$len = count($args) - 1;
			$values = array();
			for ($i = 0; $i < $len; $i++) {
				$j = $i + 1;
				$values[$i] = $this->escapeValue($args[$j]);
			}
			for ($i = 0; $i < $len; $i++) {
				$result .= $formats[$i];
				if ($j <= $len) {
					$result .= $values[$i];
				}
			}
			$result .= $formats[$i];
		}
		return $result;
	}

	/**
	 * Create an INSERT query for a specified table.
	 *
	 * @param string $table The name of the table.
	 * @param array $data The data to be inserted.
	 * @return string The constructed INSERT query.
	 */
	public function createInsertQuery($table, $data)
	{
		$fields = array_keys($data);
		$values = array_values($data);

		$valuesFixed = array_map(array($this, 'escapeValue'), $values);
		$fieldList = implode(", ", $fields);
		$valueList = implode(", ", $valuesFixed);
		return "INSERT INTO $table \r\n($fieldList)\r\nVALUES($valueList)\r\n";
	}

	/**
	 * Create an UPDATE query for a specified table.
	 *
	 * @param string $table The name of the table.
	 * @param array $data The data to be updated.
	 * @param array $primaryKey The primary keys for the update condition.
	 * @return string The constructed UPDATE query.
	 */
	public function createUpdateQuery($table, $data, $primaryKey)
	{
		$set = array();
		$condition = array();
		foreach ($data as $field => $value) {
			$set[] = "$field = " . $this->escapeValue($value);
		}

		foreach ($primaryKey as $field => $value) {
			if ($value === null) {
				$condition[] = "$field IS NULL";
			} else {
				$condition[] = "$field = " . $this->escapeValue($value);
			}
		}

		$sets = implode(", ", $set);
		$where = implode(" AND ", $condition);
		return "UPDATE $table \r\nSET $sets \r\nWHERE $where\r\n";
	}

	/**
	 * Create a HAVING statement for filtering aggregated results.
	 *
	 * @param string $query The condition(s) for the HAVING clause.
	 * @return self Returns the current instance for method chaining.
	 */
	public function having($query)
	{
		$count = func_num_args();
		if ($count > 1) {
			$params = array();
			for ($i = 0; $i < $count; $i++) {
				$params[] = func_get_arg($i);
			}
			$buffer = $this->createMatchedValue($params);
			$this->buffer .= "HAVING $buffer \r\n";
		} elseif (!empty($query)) {
			$this->buffer .= "HAVING $query \r\n";
		}
		return $this;
	}

	/**
	 * Create an ORDER BY statement for sorting results.
	 *
	 * @param string $query The field(s) to order by.
	 * @return self Returns the current instance for method chaining.
	 */
	public function orderBy($query)
	{
		if (!empty($query)) {
			$this->buffer .= "ORDER BY $query \r\n";
		}
		return $this;
	}

	/**
	 * Create a GROUP BY statement for grouping results.
	 *
	 * @param string $query The field(s) to group by.
	 * @return self Returns the current instance for method chaining.
	 */
	public function groupBy($query)
	{
		if (!empty($query)) {
			$this->buffer .= "GROUP BY $query \r\n";
		}
		return $this;
	}

	/**
	 * Set a limit on the number of results returned.
	 *
	 * @param int $limit The maximum number of results.
	 * @return self Returns the current instance for method chaining.
	 */
	public function limit($limit)
	{
		$this->limitOffset = true;
		$this->limit = $limit;
		return $this;
	}

	/**
	 * Set an offset for the results returned.
	 *
	 * @param int $offset The offset from the start of the result set.
	 * @return self Returns the current instance for method chaining.
	 */
	public function offset($offset)
	{
		$this->limitOffset = true;
		$this->offset = $offset;
		return $this;
	}

	/**
	 * Create a LOCK TABLES statement for database locking.
	 *
	 * @param string $tables Comma-separated table names to lock.
	 * @return string|null The LOCK TABLES statement or null if not supported.
	 */
	public function lockTables($tables)
	{
		if ($this->isMySql() || $this->isPgSql()) {
			return "LOCK TABLES $tables";
		}
		elseif ($this->isSqlServer()) {
			return "BEGIN TRANSACTION";
		}
		return null;
	}

	/**
	 * Create an UNLOCK TABLES statement to release table locks.
	 *
	 * @return string|null The UNLOCK TABLES statement or null if not supported.
	 */
	public function unlockTables()
	{
		if ($this->isMySql() || $this->isPgSql()) {
			return "UNLOCK TABLES";
		}
		elseif ($this->isSqlServer()) {
			return "COMMIT TRANSACTION";
		}
		return null;
	}

	/**
	 * Create a START TRANSACTION statement for initiating a transaction.
	 *
	 * @return string|null The START TRANSACTION statement or null if not supported.
	 */
	public function startTransaction() 
	{
		if ($this->isMySql() || $this->isPgSql()) {
			return "START TRANSACTION";
		}
		elseif ($this->isSqlite() || $this->isSqlServer()) {
			return "BEGIN TRANSACTION";
		}
		return null;
	}

	/**
	 * Create a COMMIT statement to finalize a transaction.
	 *
	 * @return string|null The COMMIT statement or null if not supported.
	 */
	public function commit()
	{
		if ($this->isMySql() || $this->isPgSql() || $this->isSqlite()) {
			return "COMMIT";
		}
		elseif ($this->isSqlServer()) {
			return "COMMIT TRANSACTION"; // Finalizing transaction in SQL Server
		}
		return null;
	}

	/**
	 * Create a ROLLBACK statement to revert a transaction.
	 *
	 * @return string|null The ROLLBACK statement or null if not supported.
	 */
	public function rollback()
	{
		if ($this->isMySql() || $this->isPgSql() || $this->isSqlite()) {
			return "ROLLBACK";
		}
		elseif ($this->isSqlServer()) {
			return "ROLLBACK TRANSACTION"; // Reverting transaction in SQL Server
		}
		return null;
	}
	
	/**
	 * Escape special characters in a SQL string.
	 *
	 * This method escapes special characters in a SQL query string to prevent SQL 
	 * injection and ensure proper execution across different database systems. 
	 * It handles various database types (SQLite, MySQL/MariaDB, PostgreSQL, and SQL Server) 
	 * by applying database-specific escaping techniques:
	 * - For MySQL/MariaDB, it uses `addslashes` for special characters and escapes 
	 *   newline characters.
	 * - For PostgreSQL and SQLite, it uses a custom quote replacement function and escapes 
	 *   newline characters.
	 * - For SQL Server, it doubles the single quote characters (`'`) to escape them.
	 *
	 * @param string $query The SQL query string to escape. This should be a valid 
	 *                      SQL statement that may contain special characters 
	 *                      requiring escaping.
	 * @return string The escaped SQL query string. This result can be safely used 
	 *                in database queries to avoid syntax errors and SQL injection 
	 *                vulnerabilities.
	 */
	public function escapeSQL($query)
	{
		if (stripos($this->databaseType, PicoDatabaseType::DATABASE_TYPE_MYSQL) !== false 
			|| stripos($this->databaseType, PicoDatabaseType::DATABASE_TYPE_MARIADB) !== false) {
			return str_replace(array("\r", "\n"), array("\\r", "\\n"), addslashes($query));
		}
		if (stripos($this->databaseType, PicoDatabaseType::DATABASE_TYPE_PGSQL) !== false 
			|| stripos($this->databaseType, PicoDatabaseType::DATABASE_TYPE_SQLITE) !== false
			|| stripos($this->databaseType, PicoDatabaseType::DATABASE_TYPE_SQLSERVER) !== false) {
			return str_replace(array("\r", "\n"), array("\\r", "\\n"), $this->replaceQuote($query));
		}
		return $query;
	}

	
	/**
	 * Escape a value for SQL queries.
	 *
	 * This method safely escapes different types of values (null, strings, booleans, 
	 * numeric values, arrays, and objects) to ensure that they can be safely used in 
	 * SQL queries. It prevents SQL injection by escaping potentially dangerous 
	 * characters in string values and converts arrays or objects to their JSON 
	 * representation.
	 *
	 * @param mixed $value The value to be escaped. Can be null, string, boolean, 
	 *                     numeric, array, or object.
	 * @return string The escaped value. This will be a string representation 
	 *                of the value, properly formatted for SQL usage.
	 */
	public function escapeValue($value)
	{
		$result = null;
		if ($value === null) {
			// Null value
			$result = 'NULL';
		} elseif (is_string($value)) {
			// Escape the string value
			$result = "'" . $this->escapeSQL($value) . "'";
		} elseif (is_bool($value)) {
			// Boolean value
			$result = $this->createBoolean($value);
		} elseif (is_numeric($value)) {
			// Numeric value
			$result = (string)$value;
		} elseif (is_array($value) || is_object($value)) {
			// Convert array or object to JSON and escape
			return $this->escapedJSONValues($value);
		} else {
			// Force convert to string and escape
			$result = "'" . $this->escapeSQL((string)$value) . "'";
		}
		return $result;
	}

	/**
	 * Escapes the JSON-encoded values.
	 *
	 * This function takes an input value, encodes it into JSON format, and then escapes
	 * the resulting JSON string to ensure it is safe for use (e.g., preventing injection or
	 * special character issues).
	 *
	 * @param mixed $values The input values to be encoded into JSON and escaped.
	 * @return string The escaped JSON string.
	 */
	public function escapedJSONValues($values)
	{
		return $this->escapeValue(json_encode($values));
	}
	
	/**
	 * Convert a value to its boolean representation for SQL.
	 *
	 * For SQLite, returns '1' for true and '0' for false.
	 * For other databases, returns 'TRUE' for true and 'FALSE' for false.
	 *
	 * @param mixed $value The value to be converted.
	 * @return string The boolean representation as a string.
	 */
	public function createBoolean($value)
	{
		if($this->isSqlite())
		{
			return $value ? '1' : '0';
		}
		return $value ? 'TRUE' : 'FALSE';
	}

	/**
	 * Convert an array to a comma-separated list of escaped values.
	 *
	 * @param array $values The array of values.
	 * @return string The comma-separated list.
	 */
	public function implodeValues($values)
	{
		foreach ($values as $key => $value) {
			$values[$key] = $this->escapeValue($value);
		}
		return implode(", ", $values);
	}

	/**
	 * Create a statement to execute a function.
	 *
	 * @param string $name The name of the function to execute.
	 * @param string $params The parameters for the function.
	 * @return string|null The SQL statement to execute the function or null if not supported.
	 */
	public function executeFunction($name, $params)
	{
		if ($this->isMySql() || $this->isPgSql() || $this->isSqlServer()) {
			return "SELECT $name($params)";
		}
		return null;
	}

	/**
	 * Create a statement to execute a stored procedure.
	 *
	 * @param string $name The name of the procedure to execute.
	 * @param string $params The parameters for the procedure.
	 * @return string|null The SQL statement to execute the procedure or null if not supported.
	 */
	public function executeProcedure($name, $params) // NOSONAR
	{
		if ($this->isMySql()) {
			return "CALL $name($params)";
		}
		elseif ($this->isPgSql()) {
			return "SELECT $name($params)";
		}
		elseif ($this->isSqlServer()) {
			return "EXEC $name $params"; // SQL Server uses EXEC to call stored procedures
		}
		return null;
	}

	/**
	 * Create a statement to retrieve the last inserted ID.
	 *
	 * @return self Returns the current instance for method chaining.
	 */
	public function lastID()
	{
		if ($this->isMySql()) {
			$this->buffer .= "LAST_INSERT_ID()\r\n";
		}
		else if ($this->isPgSql()) {
			$this->buffer .= "LASTVAL()\r\n";
		}
		else if ($this->isSqlite())
		{
			$this->buffer .= "last_insert_rowid()";
		}
		else if ($this->isSqlServer()) {
			$this->buffer .= "SCOPE_IDENTITY()"; // SQL Server uses SCOPE_IDENTITY() to get the last inserted ID
		}
		return $this;
	}

	/**
	 * Create a statement to get the current date.
	 *
	 * @return string|null The SQL statement for the current date or null if not supported.
	 */
	public function currentDate()
	{
		if ($this->isMySql() || $this->isPgSql() || $this->isSqlite()) {
			return "CURRENT_DATE";
		}
		else if ($this->isSqlServer()) {
			return "GETDATE()"; // SQL Server uses GETDATE() for current date
		}
		return null;
	}

	/**
	 * Create a statement to get the current time.
	 *
	 * @return string|null The SQL statement for the current time or null if not supported.
	 */
	public function currentTime()
	{
		if ($this->isMySql() || $this->isPgSql() || $this->isSqlite()) {
			return "CURRENT_TIME";
		}
		else if ($this->isSqlServer()) {
			return "CONVERT(TIME, GETDATE())"; // SQL Server uses CONVERT for current time
		}
		return null;
	}

	/**
	 * Create a statement to get the current timestamp.
	 *
	 * @return string|null The SQL statement for the current timestamp or null if not supported.
	 */
	public function currentTimestamp()
	{
		if ($this->isMySql() || $this->isPgSql() || $this->isSqlite()) {
			return "CURRENT_TIMESTAMP";
		}
		else if ($this->isSqlServer()) {
			return "GETDATE()"; // SQL Server uses GETDATE() for current timestamp as well
		}
		return null;
	}

	/**
	 * Create a NOW statement for the current time with optional precision.
	 *
	 * @param int $precision The decimal precision of seconds (default is 0).
	 * @return string The NOW statement with the specified precision.
	 */
	public function now($precision = 0)
	{
		if ($this->isSqlite()) {
			return "CURRENT_TIMESTAMP";
		}

		if ($this->isSqlServer()) {
			// SQL Server's equivalent to NOW() with precision, max precision is 7
			$precision = min($precision, 7); // Limit precision to 7 for SQL Server
			return $precision > 0 ? "SYSDATETIMEOFFSET($precision)" : "SYSDATETIMEOFFSET"; // SQL Server's equivalent to NOW() with precision
		}

		if ($precision > 6) {
			$precision = 6;
		}

		return $precision > 0 ? "NOW($precision)" : "NOW()";
	}

	/**
	 * Replace single quotes with double single quotes in a SQL string for escaping.
	 *
	 * @param string $query The SQL query string to modify.
	 * @return string The modified SQL query string.
	 */
	public function replaceQuote($query)
	{
		return str_replace("'", "''", $query);
	}

	/**
	 * Add query parameters to a SQL statement.
	 *
	 * @param string $query The SQL query string.
	 * @return string The constructed SQL query with parameters.
	 */
	public function addQueryParameters($query)
	{
		$count = func_num_args();
		$buffer = "";
		if ($count > 1) {
			$params = array();
			for ($i = 0; $i < $count; $i++) {
				$params[] = func_get_arg($i);
			}
			$buffer = $this->createMatchedValue($params);
		} else {
			$buffer = $query;
		}
		return $buffer;
	}

	/**
	 * Adds pagination and sorting clauses to a native query string.
	 * 
	 * This function appends the appropriate `ORDER BY` and `LIMIT $limit OFFSET $offset` or `LIMIT $offset, $limit`
	 * clauses to the provided SQL query string based on the given pagination and sorting parameters.
	 * It supports various database management systems (DBMS) and adjusts the query syntax 
	 * accordingly (e.g., for PostgreSQL, SQLite, MySQL, MariaDB, etc.).
	 *
	 * @param string $queryString The original SQL query string to which pagination and sorting will be added.
	 * @param PicoPageable|null $pageable The pagination parameters, or `null` if pagination is not required.
	 * @param PicoSortable|null $sortable The sorting parameters, or `null` if sorting is not required.
	 * 
	 * @return string The modified SQL query string with added pagination and sorting clauses.
	 */
	public function addPaginationAndSorting($queryString, $pageable, $sortable)
	{
		if(!isset($pageable) && !isset($sortable))
		{
			return $queryString;
		}

		$queryString = rtrim($queryString, " \r\n\t; ");

		if(isset($sortable))
		{
			foreach($sortable->getSortable() as $sort)
			{
				$columnName = $sort->getSortBy();
				$sortType = $sort->getSortType();             				
				$sorts[] = $columnName . " " . $sortType;           
			}
			if(!empty($sorts))
			{
				$queryString .= "\r\nORDER BY ".implode(", ", $sorts);
			}
		}
		if(isset($pageable))
		{
			$limitOffset = $pageable->getOffsetLimit();
			$limit = $limitOffset->getLimit();
			$offset = $limitOffset->getOffset();
			if($this->isPgSql() || $this->isSqlite())
			{
				// PostgeSQL and SQLite
				$queryString .= "\r\nLIMIT $limit OFFSET $offset";
			}
			else if($this->isMySql())
			{
				// MariaDB and MySQL
				$queryString .= "\r\nLIMIT $offset, $limit";
			}
			else if($this->isSqlServer())
			{
				// SQL Server
				$queryString .= "\r\nOFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
			}
		}
		
		return $queryString;
	}
	
	/**
	 * Converts the current object to a string representation.
	 *
	 * This method casts the current object to a string. It relies on the magic method __toString()
	 * to provide a meaningful string representation of the object.
	 *
	 * @return string The string representation of the object.
	 */
	public function toString()
	{
		return (string) $this;
	}

	/**
	 * Magic method that converts the object to a string representation.
	 *
	 * This method generates a SQL query string based on the object's buffer and
	 * the limit/offset properties. The exact SQL syntax depends on the database
	 * type being used (MySQL, PostgreSQL, SQLite, or SQL Server).
	 *
	 * @return string The generated SQL query string with pagination (if applicable).
	 */
	public function __toString()
	{
		$sql = $this->buffer;
		if ($this->limitOffset) {
			if ($this->isMySql()) {
				$sql .= "LIMIT " . $this->offset . ", " . $this->limit;
			} else if ($this->isPgSql() || $this->isSqlite()) {
				$sql .= "LIMIT " . $this->limit . " OFFSET " . $this->offset;
			}
			else if ($this->isSqlServer()) {
				// SQL Server uses OFFSET-FETCH for pagination
				$sql .= " OFFSET " . $this->offset . " ROWS FETCH NEXT " . $this->limit . " ROWS ONLY";
			}
		}
		return $sql;
	}

}
