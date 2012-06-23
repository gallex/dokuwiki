<?php
/**
 * MySQLP authentication backend
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 * @author     Chris Smith <chris@jalakai.co.uk>
 * @author     Matthias Grimm <matthias.grimmm@sourceforge.net>
 */

class auth_ecp extends auth_basic {

    var $defaultgroup = "";

    /**
     * Constructor
     *
     * checks if the mysql interface is available, otherwise it will
     * set the variable $success of the basis class to false
     *
     * @author Matthias Grimm <matthiasgrimm@users.sourceforge.net>
     */
    function __construct() {
        if (method_exists($this, 'auth_basic')){
            parent::__construct();
        }
        $this->cando['external'] = true;
    }

    /**
     * Checks if the given user exists and the given plaintext password
     * is correct. Furtheron it might be checked wether the user is
     * member of the right group
     *
     * @param  $user  user who would like access
     * @param  $pass  user's clear text password to check
     * @return bool
     *
     */
    function checkPass($user,$pass){
        return true;
    }

    /**
     * [public function]
     *
     * Returns info about the given user needs to contain
     * at least these fields:
     *   name  string  full name of the user
     *   mail  string  email addres of the user
     *   grps  array   list of groups the user is in
     *
     * @param $user   user's nick to get data for
     *
     * @author  Andreas Gohr <andi@splitbrain.org>
     * @author  Matthias Grimm <matthiasgrimm@users.sourceforge.net>
     */
    function getUserData($user){
        $info=array('name'=>$_SESSION['CurrentUser']->name,'mail'=>'xx@sina.com','grps'=>array());
        return $info;
    }
    
    function trustExternal() {
    	if ($_SERVER['WIKI_DOMAIN']=='wiki') {
	      $user=$USERINFO['name'] = $_SESSION['CurrentUser']->id;   
	   }else{
		   $user=$USERINFO['name'] = $_SESSION['CurrentUser']->eid.'.'.$_SESSION['CurrentUser']->id;
		}   
 
      $_SERVER['REMOTE_USER'] = $user;
      $_SESSION[DOKU_COOKIE]['auth']['user'] = $user;
      $_SESSION[DOKU_COOKIE]['auth']['info'] = $USERINFO;
      return true;
    }
}

