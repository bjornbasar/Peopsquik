<?
class ACL
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
		$this->_db = new DB();
	}

	public function authenticate($username, $password)
	{
		$query = "select * from `users` where `username` = ? and `userpassword` = ?";
		$result = $this->_db->getRow($query, array($username, $password));

		if (count($result) < 1)
		{
			$this->signOut();
			return false;
		}

		// add user info to session
		unset($result['password']);
		unset($result['status']);

		Helper::updateSession('user', $result);
		$this->_user = $result;

		return true;
	}

	public function signOut()
	{
		Helper::clearSession('user');
		Helper::clearSession('permissions');
	}

	public function isSignedIn()
	{
		if (!is_null(Helper::getSession('user')))
		{
			return true;
		}
		return false;
	}
	
	public function getUser()
	{
		return Helper::getSession('user');
	}

	public function __destruct()
	{
		unset($this->_db);
	}

}