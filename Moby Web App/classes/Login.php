<?php

class Login
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var int $user_id The user's id
     */
    private $user_id = null;
    /**
     * @var string $user_name The user's name
     */
    private $user_name = "";
    /**
     * @var string $user_type The user's mail
     */
    private $user_type = "";
    /**
     * @var boolean $user_is_logged_in The user's login status
     */
    private $user_is_logged_in = false;
   
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
       //$_SESSION['user_name'] = time();
        // create/read session
        session_start();
        // check the possible login actions:
        // 1. logout (happen when user clicks logout button)
        // 2. login via session data (happens each time user opens a page on your php project AFTER he has successfully logged in via the login form)
        // 3. login via cookie
        // 4. login via post data, which means simply logging in via the login form. after the user has submit his login/password successfully, his
        //    logged-in-status is written into his session data on the server. this is the typical behaviour of common login scripts.

        // if user tried to log out
        $now = time();
        //$session_expire_time = $_SESSION["expire"];
        //$session_start_time = $_SESSION["start"];
        if (isset($_GET["logout"])) 
        {
            $this->doLogout();
        // if user has an active session on the server
        }
        elseif (!empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)) 
        {
            $this->loginWithSessionData();
            //if (isset($_SESSION['user_name']) && (time() - $_SESSION['user_name'] > 10))
            if ($_SESSION["expire"] != $_SESSION["start"]) 
            {
                if ($now > $_SESSION["expire"]) 
                {
                 $this->logOutWithSessionData();
                 echo"<script type='text/javascript'> 
                window.alert('Your Session got Expired');
                </script>";
                }
            }
        // login with cookie
        } 

        // elseif (isset($_COOKIE['rememberme'])) {
        //     $this->loginWithCookieData();
        // // if user just submitted a login form
        // } 
        elseif (isset($_POST["login"])) 
        {
            if (!isset($_POST['user_rememberme'])) {
                $_POST['user_rememberme'] = null;
            }
            $this->loginWithPostData($_POST['user_name'], $_POST['user_password'], $_POST['user_rememberme']);
        }
        
    }

    /**
     * Checks if database connection is opened. If not, then this method tries to open it.
     * @return bool Success status of the database connecting process
     */
    private function databaseConnection()
    {
        // if connection already exists
        if ($this->db_connection != null) {
            return true;
        } else {
            $this->db_connection = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            mysql_select_db(DB_NAME, $this->db_connection);
            if(mysql_error()) {
                return false;
            } else {
                return true;
            }
        }
        // default return
        return false;
    }


    /**
     * Logs in with S_SESSION data.
     * Technically we are already logged in at that point of time, as the $_SESSION values already exist.
     */
    private function loginWithSessionData()
    {
        $this->user_name = $_SESSION['user_name'];
        $this->user_type = $_SESSION['user_type'];
        $this->user_id = $_SESSION['user_id'];
        // set logged in status to true, because we just checked for this:
        // !empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)
        // when we called this method (in the constructor)
        $this->user_is_logged_in = true;
    }
    private function logOutWithSessionData()
    {
        //$_SESSION = array();
        session_destroy();

        $this->user_is_logged_in = false;
        $this->messages[] = MESSAGE_LOGGED_OUT;

    }

    /**
     * Logs in via the Cookie
     * @return bool success state of cookie login
     */
    private function loginWithCookieData()
    {
        if (isset($_COOKIE['rememberme'])) {
            // extract data from the cookie
            list ($user_id, $token, $hash) = explode(':', $_COOKIE['rememberme']);
            // check cookie hash validity
            if ($hash == hash('sha256', $user_id . ':' . $token . COOKIE_SECRET_KEY) && !empty($token)) {
                // cookie looks good, try to select corresponding user
                
                    //$CommFunc = new CommonFunctions();
                    
                    //$result_row = $CommFunc->getUserDataFromCookie($user_id,$token);

                    if (isset($result_row->user_id)) {
                        // write user data into PHP SESSION [a file on your server]
                        $_SESSION['user_id'] = $result_row->user_id;
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_type'] = $result_row->user_type;
                        $_SESSION['user_logged_in'] = 1;
                        
                        if ($result_row->user_type == "ADMIN")
                        {
                            $_SESSION['user_display_name'] = "Admin";
                        }
                        elseif ( $result_row->user_type == "OPERATOR")
                        {
                            $opr_result = $CommFunc->getOperatorData($result_row->user_id);
                            $_SESSION['user_display_name'] = $opr_result->operator_name;
                        }
                        elseif ( $result_row->user_type == "DOCTOR")
                        {
                            $doc_result = $CommFunc->getDoctorData($result_row->user_id);
                            $_SESSION['user_display_name'] = $doc_result->doctor_name;
                            $_SESSION['doctor_speciality']= $doc_result->doctor_speciality;
                        }
                        elseif ($result_row->user_type == "STUDENT")
                        {
                            $student_result = $CommFunc->getStudentData($result_row->user_id);
                            $_SESSION['user_display_name'] = $student_result->student_name;
                        }
                        elseif ($result_row->user_type == "PUBLIC")
                        {
                            $public_result = $CommFunc->getPublicData($result_row->user_id);
                            $_SESSION['user_display_name'] = $public_result->patient_name;
                        }

                        // declare user id, set the login status to true
                        $this->user_id = $result_row->user_id;
                        $this->user_name = $result_row->user_name;
                        $this->user_type = $result_row->user_type;
                        $this->user_is_logged_in = true;

                        // Cookie token usable only once
                        $this->newRememberMeCookie();
                        return true;
                    }
            }
            // A cookie has been used but is not valid... we delete it
            $this->deleteRememberMeCookie();
            $this->errors[] = MESSAGE_COOKIE_INVALID;
        }
        return false;
    }

    /**
     * Logs in with the data provided in $_POST, coming from the login form
     * @param $user_name
     * @param $user_password
     * @param $user_rememberme
     */
    private function loginWithPostData($user_name, $user_password)
    {
        if (empty($user_name)) {
            $this->errors[] = MESSAGE_USEREMAIL_EMPTY;
        } else if (empty($user_password)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        // if POST data (from login form) contains non-empty user_name and non-empty user_password
        } else {
                 
            $CommFunc = new CommonFunctions();
            
            $user_row = $CommFunc->getUserDetailFromEmail($user_name);
            
            // if this user not exists
            if (! isset($user_row->user_id)) {
                // was MESSAGE_USER_DOES_NOT_EXIST before, but has changed to MESSAGE_LOGIN_FAILED
                // to prevent potential attackers showing if the user exists
                $this->errors[] = MESSAGE_LOGIN_FAILED;
            } else if (strcmp(md5($user_password), $user_row->user_password) != 0) {
                // increment the failed login counter for that user
                $this->errors[] = MESSAGE_PASSWORD_WRONG;
                // has the user activated their account with the verification email
            } else {
                // write user data into PHP SESSION [a file on your server]
                $_SESSION['user_id'] = $user_row->user_id;
                $_SESSION['user_name'] = $user_row->user_name;
                $_SESSION['user_type'] = $user_row->user_type;
                $_SESSION['user_logged_in'] = 1;
                if($user_row->user_type == "store") {
                    $store_row = $CommFunc->getStoreForUserId($user_row->user_id);
                
                    $_SESSION['store_id'] = $store_row->store_id;
                } else {
                    $_SESSION['store_id'] = "";
                }
                
                
                //$_SESSION["session_destroy"] = $result_row["session_destroy"];
                
                $_SESSION['user_display_name'] = $user_row->user_name;

                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'];
                //$_SESSION['expire'];
                // declare user id, set the login status to true
                $this->user_id = $user_row->user_id;
                $this->user_name = $user_row->user_name;
                $this->user_type = $user_row->user_type;
                $this->store_id = $store_row->store_id;
                $this->user_is_logged_in = true;

                // if user has check the "remember me" checkbox, then generate token and write cookie
                /*if (isset($user_rememberme)) {
                    $this->newRememberMeCookie();
                } else {
                    // Reset remember-me token
                    $this->deleteRememberMeCookie();
                }*/

            }
        }
    }

    /**
     * Create all data needed for remember me cookie connection on client and server side
     */
    private function newRememberMeCookie()
    {
        // if database connection opened
        if ($this->databaseConnection()) {
            // generate 64 char random string and store it in current user data
            $random_token_string = hash('sha256', mt_rand());
            $sth = $this->db_connection->prepare("UPDATE users SET user_rememberme_token = :user_rememberme_token WHERE user_id = :user_id");
            $sth->execute(array(':user_rememberme_token' => $random_token_string, ':user_id' => $_SESSION['user_id']));

            // generate cookie string that consists of userid, randomstring and combined hash of both
            $cookie_string_first_part = $_SESSION['user_id'] . ':' . $random_token_string;
            $cookie_string_hash = hash('sha256', $cookie_string_first_part . COOKIE_SECRET_KEY);
            $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;

            // set cookie
            setcookie('rememberme', $cookie_string, time() + COOKIE_RUNTIME, "/", COOKIE_DOMAIN);
        }
    }

    /**
     * Delete all data needed for remember me cookie connection on client and server side
     */
    private function deleteRememberMeCookie()
    {
        // if database connection opened
        if ($this->databaseConnection()) {
            // Reset rememberme token
            $sth = $this->db_connection->prepare("UPDATE users SET user_rememberme_token = NULL WHERE user_id = :user_id");
            $sth->execute(array(':user_id' => $_SESSION['user_id']));
        }

        // set the rememberme-cookie to ten years ago (3600sec * 365 days * 10).
        // that's obivously the best practice to kill a cookie via php
        // @see http://stackoverflow.com/a/686166/1114320
        setcookie('rememberme', false, time() - (3600 * 3650), '/', COOKIE_DOMAIN);
    }

    /**
     * Perform the logout, resetting the session
     */
    public function doLogout()
    {
        //$this->deleteRememberMeCookie();

        $_SESSION = array();
        session_destroy();

        $this->user_is_logged_in = false;
        $this->messages[] = MESSAGE_LOGGED_OUT;
    }

    /**
     * Simply return the current state of the user's login
     * @return bool user's login status
     */
    public function isUserLoggedIn()
    {
        return $this->user_is_logged_in;
    }

    public function getUsername()
    {
        return $this->user_name;
    }
    
    public function getUserId()
    {
        return $this->user_id;
    }
    
}
