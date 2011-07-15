<?
abstract class Base
{
	
	protected $db;
	
	protected $data;

	public function __construct()
	{
		$this->db = new DB();
	}
	
	public final function __set($var, $value)
	{
		$this->data[$var] = $value;
	}

	public final function __get($var)
	{
		if (isset($this->data[$var]))
		{
			return $this->data[$var];
		}
		throw new Exception('Object property was not found');
	}

	public final function getDbData($table, $columns = '*', $where = null, $order = null, $onlyone = false)
	{
		$query = "select $columns from `$table`";

		if (!is_null($where))
		{
			$query .= " where $where ";
		}

		if (!is_null($order))
		{
			$query .= " order by $order";
		}

		if ($onlyone)
		{
			return $this->db->getRow($query, array());
		}
		else
		{
			return $this->db->getArray($query, array());
		}
	}
}