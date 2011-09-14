<?
require APP_LIB . 'config.php';

class Core_DB
{
    private $_db;

    public $dataset;

    private $_conf;

    private $_dbUsed;

    public function __construct()
    {
        require APP_CONF . 'config.php';

        $this->_conf = $db;
        
        $this->_db = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
        
        //mysqli_select_db($db['name'], $this->_db);
    }

    private function _convertResult($result)
    {
        if ($this->_db->affected_rows > 0)
        {
            $rs = array();
            while ($data = $result->fetch_assoc())
            {
                $rs[] = $data;
            }

            return $rs;
        }

        return array();
    }

    private function _execute($query, $returndata = true)
    {
        //		$result = mysql_query($query, $this->_db) or die(mysql_error($this->_db) . "<br/>\nyour query: <b>". $query . "</b>");
        $result = $this->_db->query($query) or trigger_error($this->_db->error . "<br/>\nyour query: <b>". $query . '</b>', E_USER_ERROR);

        if($returndata)
        {
            return $this->_convertResult($result);
        }
    }

    private function _createSql($query, $data = array())
    {
        // replace ? in $query with $data values
        for($i = 0; $i < count($data); ++$i)
        {
            $replaceString = $data[$i];
            if (is_string($data[$i]))
            {
                $replaceString = "'" . $data[$i] . "'";
            }

            $y = strpos($query, '?');
            if ($y !== false)
            $query = substr($query, 0, $y) . $replaceString . substr($query, $y + 1);
        }

        return $query;
    }

    public function getRow($query, $data = array())
    {
        $query = $this->_createSql($query, $data);
        $rs = $this->_execute($query);

        if (count($rs) > 0)
        {
            return $rs[0];
        }
        return $rs;
    }

    public function getArray($query, $data = array())
    {
        $query = $this->_createSql($query, $data);
        $rs = $this->_execute($query);
        return $rs;
    }

    public function execute($query, $data = array())
    {
        $query = $this->_createSql($query, $data);
        $rs = $this->_execute($query, false);
    }

    private function _createSqlInsert($table, $data)
    {
        // create query based on $data
        $query = "INSERT INTO `$table` (";
        $values = ' VALUES (';
        foreach ($data as $key => $value)
        {
            $query .= "`$key`, ";
            $values .= "'$value', ";
        }
        $query = substr($query, 0, strlen($query) - 2) . ')';
        $values = substr($values, 0, strlen($values) - 2) . ')';

        return $query . $values;
    }

    private function _createSqlUpdate($table, $data, $index)
    {
        $query = "UPDATE `$table` SET ";
        foreach ($data as $key => $value)
        {
            is_string($value) ? $query .= "`$key` = '$value', " : $query .= "`$key` = $value, ";
        }
        $query = substr($query, 0, strlen($query) - 2);

        // add where clause
        $where = ' WHERE ';
        $and = '';
        foreach ($index as $key => $value)
        {
            $where .= $and . "`$key` = '$value'";
            $and = ' AND ';
        }

        return $query . $where;
    }

    public function autoexecute($table, $data, $index = null)
    {
        if (is_null($index))
        {
            // insert
            $query = $this->_createSqlInsert($table, $data);
        }
        else
        {
            // update
            $query = $this->_createSqlUpdate($table, $data, $index);
        }

        $this->_execute($query, false);

        if (is_null($index))
        {
            return mysqli_insert_id();
        }
    }

    public function tryQuery($query)
    {
    	$this->_db->query($query);

    	if (mysqli_errno() === 0)
    	{
    		return true;
    	}
    	return false;
    }

    /**
	 * Class Destructor that unsets the db and dataset properties
	 *
	 */
    public function __destruct()
    {
    	$this->_db->close();
        unset($this->_db);
        unset($this->dataset);
    }

}