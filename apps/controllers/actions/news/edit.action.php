<?php
extract($_POST, EXTR_REFS);

$data = $_POST;

$date = date('Y-m-d H:i:s');

if (!$news_id)
{
	$data['date'] = $date;
}
$user = $this->acl->getUser();

$data['user_id'] = $user['users_id'];

$newsObj = new News();

$newsObj->update($data);
$this->forward('news');