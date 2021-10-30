<?php

/** Simple database classfrom
 *
 * @url // https://codeshack.io/super-fast-php-mysql-database-class/
 * Class DB
 */
class DB {
    const SERVER = "";
    const DBUSER = "";
    const DATABASE = "";
    const PASSWORD = "";

    /**
     * @var mysqli
     */
    protected mysqli $connection;

    /**
     * @var mysqli_stmt
     */
    protected mysqli_stmt $query;

    /**
     * @var int
     */
    public int $query_count = 0;

    /**
     * @var int
     */
    private int $insert_id = -1;

    /**
     * @var bool
     */
    private bool $transaction_started = false;

    public function __construct(string $dbhost = DB::SERVER, string $dbuser = DB::DBUSER, string $dbpass = DB::PASSWORD, string $dbname = DB::DATABASE, string $charset = 'utf8')
    {
        $this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($this->connection->connect_error) {
            die('Failed to connect to MySQL - ' . $this->connection->connect_error);
        }
        $this->connection->set_charset($charset);
    }

    public function query($query) : DB
    {
        if ($this->query = $this->connection->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
                $types = '';
                $args_ref = array();

                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        foreach ($args[$k] as $j => &$a) {
                            $types .= $this->_gettype($args[$k][$j]);
                            $args_ref[] = &$a;
                        }
                    } else {
                        $types .= $this->_gettype($args[$k]);
                        $args_ref[] = &$arg;
                    }
                }
                array_unshift($args_ref, $types);
                call_user_func_array(array($this->query, 'bind_param'), $args_ref);
            }

            $this->query->execute();
            if ($this->query->errno) {
                die('Unable to process MySQL query (check your params) - ' . $this->query->error);
            }

            $this->query_count++;
        } else {
            die('Unable to prepare statement (check your syntax) - ' . $this->connection->error);
        }

        return $this;
    }

    /** Starts a transaction Use commitTransaction to commit or rollback to revert changes.
     * @param int $flags
     */
    public function startTransaction(int $flags = MYSQLI_TRANS_START_READ_WRITE) : void
    {
        $this->connection->autocommit(false);
        $this->connection->begin_transaction($flags);
        $this->transaction_started = true;
    }

    /**
     * Commit transaction
     */
    public function commitTransaction() : void
    {
        if($this->transaction_started)
        {
            $this->connection->commit();
            $this->connection->autocommit(true);
        }
    }

    /**
     * Rollback transaction
     */
    public function rollback() : void
    {
        if($this->transaction_started)
        {
            $this->connection->rollback();
        }
    }

    public function fetchAll() : array
    {
        $params = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            $r = array();
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }
            $result[] = $r;
        }
        $this->query->close();

        return $result;
    }

    public function fetchArray() : array
    {
        $params = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            foreach ($row as $key => $val) {
                $result[$key] = $val;
            }
        }
        $this->query->close();

        return $result;
    }

    public function numRows() : int
    {
        $this->query->store_result();
        return $this->query->num_rows;
    }

    public function close() : bool
    {
        return $this->connection->close();
    }

    public function affectedRows() : int
    {
        return $this->query->affected_rows;
    }

    private function _gettype($var) : string
    {
        if(is_string($var)) return 's';
        if(is_float($var)) return 'd';
        if(is_int($var)) return 'i';
        return 'b';
    }

    public function getLastInsertId() : int
    {
        return $this->connection->insert_id;
    }
}