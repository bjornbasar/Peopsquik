<?
class Core_ACL
{

	protected $_permissions;
	protected $_user;
	protected $_db;

	/**
     * Class Constructor
     *
     */
	public function __construct()
	{
		$this->_db = new Core_DB();
	}

	public function authenticate($username, $password)
	{
		$query = "select * from `users` where `username` = ? and `password` = ?";
		$result = $this->_db->getRow($query, array($username, $password));

		if (count($result) < 1)
		{
			$this->signOut();
			return false;
		}

		// add user info to session
		unset($result['password']);
		unset($result['status']);

		Core_Helper::updateSession('user', $result);
		$this->_user = $result;

		return true;
	}

	public function signOut()
	{
		Core_Helper::clearSession('user');
		Core_Helper::clearSession('permissions');
	}

	public function isSignedIn()
	{
		if (!is_null(Core_Helper::getSession('user')))
		{
			return true;
		}
		return false;
	}
	
	public function getUser()
	{
		return Core_Helper::getSession('user');
	}

	public function __destruct()
	{
		unset($this->_db);
	}

}