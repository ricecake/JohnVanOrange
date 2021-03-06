<?php
require_once(ROOT_DIR.'/classes/base.class.php');
require_once(ROOT_DIR.'/classes/user.class.php');

class Theme extends Base {
 
 private $user;
 
 public function __construct() {
  parent::__construct();
  $this->user = new User;
 }
 
 public function set($options=array()) {
  switch ($options['theme']) {
   case 'light':
   case 'dark':
   break;
   default:
    throw new Exception('Not a valid theme');
   break;
  }
  $user = $this->user->current();
  if ($user) {
   $sql = 'UPDATE users SET theme = :theme WHERE id = :user';
   $val = array(
    ':theme' => $options['theme'],
    ':user' => $user['id']
   );
   $this->db->fetch($sql,$val);
  }
  else {
   setcookie('theme', $options['theme'], time()+60*60*24*365, '/');
  }
  return array(
   'message' => 'Theme updated.'
  );
 }
 
 public function get($options=array()) {
  $user = $this->user->current();
  if ($user) {
   return $user['theme'];
  }
  if ($_COOKIE['theme']) {
   return $_COOKIE['theme'];
  }
  return 'dark';
 }
 
}
?>