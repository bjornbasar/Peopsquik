<?

class TableBase
{
	protected $table;

	protected $primary;
	
	protected $order;

	protected $db;
	
	protected $data;

	public function __construct()
	{
		$this->db = new Core_DB();
	}

	public function getAll()
	{
		$query = "select * from `" . $this->table . "`";
		if ($this->order)
		{
			$query .= ' order by ' . $this->order;
		}
		
		return $this->db->getArray($query, array());
	}

	public function get($id)
	{
		$query = "select * from `" . $this->table . "` where `" . $this->primary . "` = ?";
		return $this->db->getRow($query, array($id));
	}

	public function getBy($data = array())
	{
		if (count($data) > 0)
		{
			$condition = '1 ';

			foreach ($data as $key => $value)
			{
				$condition .= " and `$key` = '$value' ";
			}

			$query = "select * from `" . $this->table . "` where $condition";
			
			if ($this->order)
			{
				$query .= ' order by ' . $this->order;
			}

			return $this->db->getArray($query, array($value));
		}
		return array();
	}
	
	public function delete($id)
	{
		$query = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary . ' = ?';
		return $this->db->execute($query,array($id)); 
	}

	public function update($data)
	{
		if (isset($data[$this->primary]) && $data[$this->primary])
		{
			$primary = $data[$this->primary];
			unset($data[$this->primary]);
			$this->db->autoexecute($this->table, $data, array($this->primary => $primary));
			return $primary;
		}
		else
		{
			return $this->db->autoexecute($this->table, $data);
		}
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