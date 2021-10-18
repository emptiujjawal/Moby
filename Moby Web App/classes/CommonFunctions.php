<?php

include("config.php");


/**
* 
*/
class CommonFunctions {
	
	function __construct() {
		
	}

	private $db_connection = null;

	/*
	* Creating or checking if the database connection is made 
	*/
	private function databaseConnection(){
		// if connection already exists
		if ($this->db_connection != null) {
			return true;
		} else {
			try {
				$this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
				return true;
			} catch (PDOException $e) {
				echo $e->getMessage();
				$this->errors[] = MESSAGE_DATABASE_ERROR . $e->getMessage();
			}
		}
		// default return
		return false;
    }

    public function getAllusers() {
    	// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('SELECT * FROM t_user WHERE user_type = :user_type');
			$query_user->bindValue(':user_type', trim("customer"), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			return $query_user->fetchAll();
		} else {
			return false;
		}
    }

    /* get the list of all customers */
    public function getAudience() {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('SELECT * FROM t_user WHERE user_type = :user_type');
			$query_user->bindValue(':user_type', trim("customer"), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			return $query_user->fetchAll();
		} else {
			return false;
		}
    }    	
    

    public function getUsersOfOneGender($gender) {
    	// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('SELECT * FROM t_user WHERE user_type = :user_type AND user_gender = :user_gender');
			$query_user->bindValue(':user_gender', trim($gender), PDO::PARAM_STR);
			$query_user->bindValue(':user_type', trim("customer"), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			return $query_user->fetchAll();
		} else {
			return false;
		}
    }

	/* GET USER DETAILS USING user_id
	* PARAMS:- user_id
	* RETURN:- object(user)
	*/
	public function getUserDetail($user_id) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('SELECT * FROM t_user WHERE user_id = :user_id LIMIT 1');
			$query_user->bindValue(':user_id', trim($user_id), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			return $query_user->fetchObject();
		} else {
			return false;
		}
	}

	/* GET USER DETAILS USING CONTACT 
	* PARAMS:- user_contact
	* RETURN:- object(user)
	*/
	public function getUserDetailFromContact($user_contact) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('SELECT * FROM t_user WHERE user_contact = :user_contact LIMIT 1');
			$query_user->bindValue(':user_contact', trim($user_contact), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			return $query_user->fetchObject();
		} else {
			return false;
		}
	}

	/* GET USER DETAILS USING EMAIL 
	* PARAMS:- user_email
	* RETURN:- object(user)
	*/
	public function getUserDetailFromEmail($user_email) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('SELECT * FROM t_user WHERE user_email = :user_email LIMIT 1');
			$query_user->bindValue(':user_email', trim($user_email), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			return $query_user->fetchObject();
		} else {
			return false;
		}
	}

	public function createUser($login_struct) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('INSERT INTO t_user (user_contact, login_using, user_type, user_email, user_password, user_name, user_dob, user_gender, user_address, user_location, user_city, user_state, user_pincode) VALUES (:user_contact, :login_using, :user_type, :user_email, :user_password, :user_name, :user_dob, :user_gender, :user_address, :user_location, :user_city, :user_state, :user_pincode)');
			$query_user->bindValue(':user_contact', trim($login_struct->user_contact), PDO::PARAM_STR);
			$query_user->bindValue(':login_using', trim($login_struct->logged_in_using), PDO::PARAM_STR);
			$query_user->bindValue(':user_type', trim($login_struct->user_type), PDO::PARAM_STR);
			$query_user->bindValue(':user_email', trim($login_struct->user_email), PDO::PARAM_STR);
			$query_user->bindValue(':user_password', trim($login_struct->user_password), PDO::PARAM_STR);
			$query_user->bindValue(':user_name', trim($login_struct->user_name), PDO::PARAM_STR);
			$query_user->bindValue(':user_dob', trim($login_struct->user_dob), PDO::PARAM_STR);
			$query_user->bindValue(':user_gender', trim($login_struct->user_gender), PDO::PARAM_STR);
			$query_user->bindValue(':user_address', trim($login_struct->user_address), PDO::PARAM_STR);
			$query_user->bindValue(':user_location', trim($login_struct->user_location), PDO::PARAM_STR);
			$query_user->bindValue(':user_city', trim($login_struct->user_city), PDO::PARAM_STR);
			$query_user->bindValue(':user_state', trim($login_struct->user_state), PDO::PARAM_STR);
			$query_user->bindValue(':user_pincode', trim($login_struct->user_pincode), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			// print_r($query_user->errorInfo());
			if($query_user->rowCount() > 0) {
				return $this->db_connection->lastInsertId();
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}

	public function createNewUploadedUser($login_struct) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('INSERT INTO t_user (user_contact, login_using, user_type, user_email, user_password, user_name, user_dob, user_gender, user_address, user_location, user_city, user_state, user_pincode, user_salary, club_membership, defence_service, work_type, user_profession, watch_brand, car_brand, residence_type, locality, transport_type, miles_card, credit_card) VALUES (:user_contact, :login_using, :user_type, :user_email, :user_password, :user_name, :user_dob, :user_gender, :user_address, :user_location, :user_city, :user_state, :user_pincode, user_salary, :club_membership, :defence_service, :work_type, :user_profession, :watch_brand, :car_brand, :residence_type, :locality, :transport_type, :miles_card, :credit_card)');
			$query_user->bindValue(':user_contact', trim($login_struct->user_contact), PDO::PARAM_STR);
			$query_user->bindValue(':login_using', trim($login_struct->logged_in_using), PDO::PARAM_STR);
			$query_user->bindValue(':user_type', trim($login_struct->user_type), PDO::PARAM_STR);
			$query_user->bindValue(':user_email', trim($login_struct->user_email), PDO::PARAM_STR);
			$query_user->bindValue(':user_password', trim($login_struct->user_password), PDO::PARAM_STR);
			$query_user->bindValue(':user_name', trim($login_struct->user_name), PDO::PARAM_STR);
			$query_user->bindValue(':user_dob', trim($login_struct->user_dob), PDO::PARAM_STR);
			$query_user->bindValue(':user_gender', trim($login_struct->user_gender), PDO::PARAM_STR);
			$query_user->bindValue(':user_address', trim($login_struct->user_address), PDO::PARAM_STR);
			$query_user->bindValue(':user_location', trim($login_struct->user_location), PDO::PARAM_STR);
			$query_user->bindValue(':user_city', trim($login_struct->user_city), PDO::PARAM_STR);
			$query_user->bindValue(':user_state', trim($login_struct->user_state), PDO::PARAM_STR);
			$query_user->bindValue(':user_pincode', trim($login_struct->user_pincode), PDO::PARAM_STR);
			$query_user->bindValue(':user_salary', trim($login_struct->user_salary), PDO::PARAM_STR);
			$query_user->bindValue(':club_membership', trim($login_struct->club_membership), PDO::PARAM_STR);
			$query_user->bindValue(':defence_service', trim($login_struct->defence_service), PDO::PARAM_STR);
			$query_user->bindValue(':work_type', trim($login_struct->work_type), PDO::PARAM_STR);
			$query_user->bindValue(':user_profession', trim($login_struct->user_profession), PDO::PARAM_STR);
			$query_user->bindValue(':watch_brand', trim($login_struct->watch_brand), PDO::PARAM_STR);
			$query_user->bindValue(':car_brand', trim($login_struct->car_brand), PDO::PARAM_STR);
			$query_user->bindValue(':residence_type', trim($login_struct->residence_type), PDO::PARAM_STR);
			$query_user->bindValue(':locality', trim($login_struct->locality), PDO::PARAM_STR);
			$query_user->bindValue(':transport_type', trim($login_struct->transport_type), PDO::PARAM_STR);
			$query_user->bindValue(':miles_card', trim($login_struct->miles_card), PDO::PARAM_STR);
			$query_user->bindValue(':credit_card', trim($login_struct->credit_card), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			// print_r($query_user->errorInfo());
			if($query_user->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function updateUser($login_struct) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('UPDATE t_user SET user_email = :user_email, user_name = :user_name, user_dob = :user_dob, user_gender = :user_gender, user_address = :user_address, user_location = :user_location, user_city = :user_city, user_state = :user_state, user_pincode = :user_pincode, user_salary = :user_salary, club_membership = :club_membership, defence_service = :defence_service, work_type = :work_type, user_profession = :user_profession, watch_brand = :watch_brand, car_brand = :car_brand, residence_type = :residence_type, locality = :locality, transport_type = :transport_type, miles_card = :miles_card, credit_card = :credit_card, fb_link = :fb_link, twitter_link = :twitter_link, gplus_link = :gplus_link WHERE user_contact = :user_contact');
			$query_user->bindValue(':user_contact', trim($login_struct->user_contact), PDO::PARAM_STR);
			$query_user->bindValue(':user_email', trim($login_struct->user_email), PDO::PARAM_STR);
			$query_user->bindValue(':user_name', trim($login_struct->user_name), PDO::PARAM_STR);
			$query_user->bindValue(':user_dob', trim($login_struct->user_dob), PDO::PARAM_STR);
			$query_user->bindValue(':user_gender', trim($login_struct->user_gender), PDO::PARAM_STR);
			$query_user->bindValue(':user_address', trim($login_struct->user_address), PDO::PARAM_STR);
			$query_user->bindValue(':user_location', trim($login_struct->user_location), PDO::PARAM_STR);
			$query_user->bindValue(':user_city', trim($login_struct->user_city), PDO::PARAM_STR);
			$query_user->bindValue(':user_state', trim($login_struct->user_state), PDO::PARAM_STR);
			$query_user->bindValue(':user_pincode', trim($login_struct->user_pincode), PDO::PARAM_STR);
			$query_user->bindValue(':user_salary', trim($login_struct->user_salary), PDO::PARAM_STR);
			$query_user->bindValue(':club_membership', trim($login_struct->club_membership), PDO::PARAM_STR);
			$query_user->bindValue(':defence_service', trim($login_struct->defence_service), PDO::PARAM_STR);
			$query_user->bindValue(':work_type', trim($login_struct->work_type), PDO::PARAM_STR);
			$query_user->bindValue(':user_profession', trim($login_struct->user_profession), PDO::PARAM_STR);
			$query_user->bindValue(':watch_brand', trim($login_struct->watch_brand), PDO::PARAM_STR);
			$query_user->bindValue(':car_brand', trim($login_struct->car_brand), PDO::PARAM_STR);
			$query_user->bindValue(':residence_type', trim($login_struct->residence_type), PDO::PARAM_STR);
			$query_user->bindValue(':locality', trim($login_struct->locality), PDO::PARAM_STR);
			$query_user->bindValue(':transport_type', trim($login_struct->transport_type), PDO::PARAM_STR);
			$query_user->bindValue(':miles_card', trim($login_struct->miles_card), PDO::PARAM_STR);
			$query_user->bindValue(':credit_card', trim($login_struct->credit_card), PDO::PARAM_STR);
			$query_user->bindValue(':fb_link', trim($login_struct->fb_link), PDO::PARAM_STR);
			$query_user->bindValue(':twitter_link', trim($login_struct->twitter_link), PDO::PARAM_STR);
			$query_user->bindValue(':gplus_link', trim($login_struct->gplus_link), PDO::PARAM_STR);
			// $query_user->bindValue(':', trim($login_struct->), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			// print_r($query_user->errorInfo());
			if($query_user->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	public function updateUserByUserid($login_struct) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('UPDATE t_user SET user_contact = :user_contact, user_email = :user_email, user_name = :user_name, user_dob = :user_dob, user_gender = :user_gender, user_address = :user_address, user_location = :user_location, user_city = :user_city, user_state = :user_state, user_pincode = :user_pincode, user_salary = :user_salary, club_membership = :club_membership, defence_service = :defence_service, work_type = :work_type, user_profession = :user_profession, watch_brand = :watch_brand, car_brand = :car_brand, residence_type = :residence_type, locality = :locality, transport_type = :transport_type, miles_card = :miles_card, credit_card = :credit_card, fb_link = :fb_link, twitter_link = :twitter_link, gplus_link = :gplus_link WHERE user_id = :user_id');
			$query_user->bindValue(':user_id', trim($login_struct->user_id), PDO::PARAM_STR);
			$query_user->bindValue(':user_contact', trim($login_struct->user_contact), PDO::PARAM_STR);
			$query_user->bindValue(':user_email', trim($login_struct->user_email), PDO::PARAM_STR);
			$query_user->bindValue(':user_name', trim($login_struct->user_name), PDO::PARAM_STR);
			$query_user->bindValue(':user_dob', trim($login_struct->user_dob), PDO::PARAM_STR);
			$query_user->bindValue(':user_gender', trim($login_struct->user_gender), PDO::PARAM_STR);
			$query_user->bindValue(':user_address', trim($login_struct->user_address), PDO::PARAM_STR);
			$query_user->bindValue(':user_location', trim($login_struct->user_location), PDO::PARAM_STR);
			$query_user->bindValue(':user_city', trim($login_struct->user_city), PDO::PARAM_STR);
			$query_user->bindValue(':user_state', trim($login_struct->user_state), PDO::PARAM_STR);
			$query_user->bindValue(':user_pincode', trim($login_struct->user_pincode), PDO::PARAM_STR);
			$query_user->bindValue(':user_salary', trim($login_struct->user_salary), PDO::PARAM_STR);
			$query_user->bindValue(':club_membership', trim($login_struct->club_membership), PDO::PARAM_STR);
			$query_user->bindValue(':defence_service', trim($login_struct->defence_service), PDO::PARAM_STR);
			$query_user->bindValue(':work_type', trim($login_struct->work_type), PDO::PARAM_STR);
			$query_user->bindValue(':user_profession', trim($login_struct->user_profession), PDO::PARAM_STR);
			$query_user->bindValue(':watch_brand', trim($login_struct->watch_brand), PDO::PARAM_STR);
			$query_user->bindValue(':car_brand', trim($login_struct->car_brand), PDO::PARAM_STR);
			$query_user->bindValue(':residence_type', trim($login_struct->residence_type), PDO::PARAM_STR);
			$query_user->bindValue(':locality', trim($login_struct->locality), PDO::PARAM_STR);
			$query_user->bindValue(':transport_type', trim($login_struct->transport_type), PDO::PARAM_STR);
			$query_user->bindValue(':miles_card', trim($login_struct->miles_card), PDO::PARAM_STR);
			$query_user->bindValue(':credit_card', trim($login_struct->credit_card), PDO::PARAM_STR);
			$query_user->bindValue(':fb_link', trim($login_struct->fb_link), PDO::PARAM_STR);
			$query_user->bindValue(':twitter_link', trim($login_struct->twitter_link), PDO::PARAM_STR);
			$query_user->bindValue(':gplus_link', trim($login_struct->gplus_link), PDO::PARAM_STR);
			// $query_user->bindValue(':', trim($login_struct->), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			// print_r($query_user->errorInfo());
			if($query_user->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	/* GET LIST OF STORES 
	* */
	public function getAllStores() {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_store = $this->db_connection->prepare('SELECT * FROM t_store');
			$query_store->execute();
			// get result row (as an object)
			return $query_store->fetchAll();
		} else {
			return false;
		}
	}
	
	public function getAllStates() {
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_states = $this->db_connection->prepare('SELECT * FROM t_states');
			$query_states->execute();
			// get result row (as an object)
			return $query_states->fetchAll();
		} else {
			return false;
		}
	}
	/* GET LIST OF STORES IN CITY
	* PARAMS:- city */
	public function getStoresInCity($city) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_store = $this->db_connection->prepare('SELECT * FROM t_store WHERE store_city = :store_city');
			$query_store->bindValue(':store_city', trim($city), PDO::PARAM_STR);
			$query_store->execute();
			// get result row (as an object)
			return $query_store->fetchAll();
		} else {
			return false;
		}
	}

	public function getStoreDetail($store_id) {
		// if database connection opened
		if ($this->databaseConnection()) {
			$query_store = $this->db_connection->prepare('SELECT * FROM t_store WHERE store_id = :store_id LIMIT 1');
			$query_store->bindValue(':store_id', trim($store_id), PDO::PARAM_STR);
			$query_store->execute();
			// get result row (as an object)
			return $query_store->fetchObject();
		} else {
			return false;
		}
	}

	/* GET LIST OF STORES 
	* */
	public function getAllAds() {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_ads = $this->db_connection->prepare('SELECT * FROM t_ads');
			$query_ads->execute();
			// get result row (as an object)
			return $query_ads->fetchAll();
		} else {
			return false;
		}
	}

	/* GET LIST OF STORES 
	* */
	public function getAllPublishedAds() {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_ads = $this->db_connection->prepare('SELECT * FROM t_ads WHERE publish = :publish');
			$query_ads->bindValue(':publish', trim("yes"), PDO::PARAM_STR);
			$query_ads->execute();
			// get result row (as an object)
			return $query_ads->fetchAll();
		} else {
			return false;
		}
	}

	public function getAllAdsForStore($store_id) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_ads = $this->db_connection->prepare('SELECT * FROM t_ads WHERE associated_store = :store_id ');
			$query_ads->bindValue(':store_id', intval(trim($store_id)), PDO::PARAM_INT);
			$query_ads->execute();
			// get result row (as an object)
			return $query_ads->fetchAll();
		} else {
			return false;
		}
	}

	/* GET AD DETAIL FOR AD_ID
	PARAMS:- ad_id
	*/
	public function getAdDetail($ad_id) {
		if ($this->databaseConnection()) {
			$query_ads = $this->db_connection->prepare('SELECT * FROM t_ads WHERE ad_id = :ad_id LIMIT 1');
			$query_ads->bindValue(':ad_id', trim($ad_id), PDO::PARAM_STR);
			$query_ads->execute();
			return $query_ads->fetchObject();
		} else {
			return false;
		}
	}
	/* GET ALL ADS FOR A STORE 
	* PARAMS:- owner_id 
	* RESULT:- 
	*/
	public function getAdsForStore($store_id) {
		if ($this->databaseConnection()) {
			$query_ads = $this->db_connection->prepare('SELECT * FROM t_ads WHERE associated_store = :store_id');
			$query_ads->bindValue(':store_id', trim($store_id), PDO::PARAM_STR);
			$query_ads->execute();
			return $query_ads->fetchAll();
		} else {
			return false;
		}
	}

	/* GET LOCATION FOR ADS
	* PARAMS:- ad_id*/
	public function getLocationForAds($ad_id, $count) {
		if ($this->databaseConnection()) {
			$query_ads = $this->db_connection->prepare('SELECT * FROM t_ad_location WHERE ad_id = :ad_id LIMIT :count');
			$query_ads->bindValue(':ad_id', trim($ad_id), PDO::PARAM_STR);
			$query_ads->bindValue(':count', intval($count), PDO::PARAM_INT);
			$query_ads->execute();
			return $query_ads->fetchAll();
		} else {
			return false;
		}
	}

	//update an ad
	public function updateAnAd($ad_struct, $ad_id) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_update_an_ad = $this->db_connection->prepare('UPDATE t_ads SET campaign_id = :campaign_id, ad_name = :ad_name, product_name = :product_name, product_url = :product_url, company_name = :company_name, company_url = :company_url, coverage_radius = :coverage_radius, associated_store = :associated_store, off_deal = :off_deal, coupon_code = :coupon_code, reward_amount = :reward_amount WHERE ad_id = :ad_id');
			$query_update_an_ad->bindValue(':campaign_id', trim($ad_struct->campaign_id), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':ad_name', trim($ad_struct->ad_name), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':product_name', trim($ad_struct->product_name), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':product_url', trim($ad_struct->product_url), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':company_name', trim($ad_struct->company_name), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':company_url', trim($ad_struct->company_url), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':coverage_radius', trim($ad_struct->coverage_radius), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':associated_store', trim($ad_struct->store_id), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':off_deal', trim($ad_struct->off_deal), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':coupon_code', trim($ad_struct->coupon_code), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':reward_amount', trim($ad_struct->reward_amount), PDO::PARAM_STR);
			$query_update_an_ad->bindValue(':ad_id', trim($ad_id), PDO::PARAM_STR);
			$query_update_an_ad->execute();
			// get result row (as an object)
			//print_r($query_update_an_ad->errorInfo());
			if($query_update_an_ad->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	/* GET ALL QUIZS FOR A AD
	* PARAMS:- ad_id
	* RESULT:- Array(object(quiz))
	*/
	public function getQuizForAds($ad_id, $quiz_count) {
		// if database connection opened
		if ($this->databaseConnection()) {
			$query_quiz = $this->db_connection->prepare('SELECT * FROM t_quiz WHERE ad_id = :ad_id LIMIT :quiz_count');
			$query_quiz->bindValue(':ad_id', trim($ad_id), PDO::PARAM_STR);
			$query_quiz->bindValue(':quiz_count', intval($quiz_count), PDO::PARAM_INT);
			$query_quiz->execute();
			return $query_quiz->fetchAll();
		} else {
			return false;
		}
	}

	/* GET ALL QUIZ FOR quiz_id
	* PARAMS:- ad_id
	* RESULT:- object(quiz)
	*/
	public function getQuizDetail($quiz_id) {
		// if database connection opened
		if ($this->databaseConnection()) {
			$query_quiz = $this->db_connection->prepare('SELECT * FROM t_quiz WHERE quiz_id = :quiz_id LIMIT 1');
			$query_quiz->bindValue(':quiz_id', intval($quiz_id), PDO::PARAM_INT);
			$query_quiz->execute();
			return $query_quiz->fetchObject();
		} else {
			return false;
		}
	}

	public function getUserActivityOnAd($user_id, $ad_id, $activity_type) {
		// if database connection opened
		if ($this->databaseConnection()) {
			$query_ad = $this->db_connection->prepare('SELECT * FROM t_user_activity WHERE user_id = :user_id AND ad_id = :ad_id AND activity_type = :activity_type LIMIT 1');
			$query_ad->bindValue(':user_id', intval($user_id), PDO::PARAM_INT);
			$query_ad->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$query_ad->bindValue(':activity_type', trim($activity_type), PDO::PARAM_STR);
			$query_ad->execute();
			if($query_ad->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/* GET CAMPAIGN DETAIL 
	* PARAMS:- campaign_id
	*/
	public function getCampaignDetail($campaign_id) {
		if ($this->databaseConnection()) {
			$query_campaign = $this->db_connection->prepare('SELECT * FROM t_campaign WHERE campaign_id = :campaign_id LIMIT 1');
			$query_campaign->bindValue(':campaign_id', trim($campaign_id), PDO::PARAM_STR);
			$query_campaign->execute();
			return $query_campaign->fetchObject();
		} else {
			return false;
		}
	}

	public function getAllCampaign() {
		if ($this->databaseConnection()) {
			$query_campaign = $this->db_connection->prepare('SELECT * FROM t_campaign');
			$query_campaign->execute();
			return $query_campaign->fetchAll();
		} else {
			return NO_CAMPAIGN_FOUND;
		}
	}
/* GET Bank DETAILs 
	* PARAMS:- bank_id
	*/
	public function getbankDetail($bank_id) {
		if ($this->databaseConnection()) {
			$query_bank = $this->db_connection->prepare('SELECT * FROM t_bank WHERE bank_id = :bank_id LIMIT 1');
			$query_bank->bindValue(':bank_id', trim($bank_id), PDO::PARAM_STR);
			$query_bank->execute();
			return $query_bank->fetchObject();
		} else {
			return false;
		}
	}

	public function getAllbank() {
		if ($this->databaseConnection()) {
			$query_bank = $this->db_connection->prepare('SELECT * FROM t_bank');
			$query_bank->execute();
			return $query_bank->fetchAll();
		} else {
			return NO_bank_FOUND;
		}
	}
	/* GET card type DETAILs 
	* PARAMS:- card_id
	*/
	public function getpaymenttypeDetail($type_id) {
		if ($this->databaseConnection()) {
			$query_type = $this->db_connection->prepare('SELECT * FROM t_payment_type WHERE type_id = :type_id LIMIT 1');
			$query_type->bindValue(':type_id', trim($type_id), PDO::PARAM_STR);
			$query_type->execute();
			return $query_type->fetchObject();
		} else {
			return false;
		}
	}

	public function getAllpaymenttype() {
		if ($this->databaseConnection()) {
			$query_type = $this->db_connection->prepare('SELECT * FROM t_payment_type');
			$query_type->execute();
			return $query_type->fetchAll();
		} else {
			return NO_type_FOUND;
		}
	}

	/* INSERT USER ACTIVITY */
	public function addUserActivity($user_id, $ad_id, $activity_type, $quiz_id, $answer_id, $reward_amount) {
		if ($this->databaseConnection()) {
			$query_user_activity = $this->db_connection->prepare('INSERT INTO t_user_activity (user_id, ad_id, quiz_id, activity_type, reward_amount, answer_id) VALUES (:user_id, :ad_id, :quiz_id, :activity_type, :reward_amount, :answer_id)');
			$query_user_activity->bindValue(':user_id', trim($user_id), PDO::PARAM_STR);
			$query_user_activity->bindValue(':ad_id', trim($ad_id), PDO::PARAM_STR);
			$query_user_activity->bindValue(':quiz_id', trim($quiz_id), PDO::PARAM_STR);
			$query_user_activity->bindValue(':answer_id', trim($answer_id), PDO::PARAM_STR);
			$query_user_activity->bindValue(':activity_type', trim($activity_type), PDO::PARAM_STR);
			$query_user_activity->bindValue(':reward_amount', trim($reward_amount), PDO::PARAM_STR);
			$query_user_activity->execute();
			if($query_user_activity->rowCount() > 0) {
				return $this->db_connection->lastInsertId();
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}

	/* update user wallet */
	public function updateUserWallet($user_id, $reward) {
		if ($this->databaseConnection()) {
			$query_wallet = $this->db_connection->prepare('UPDATE t_user SET version_id = version_id+1, wallet_amount=wallet_amount+:reward WHERE user_id = :user_id');
			$query_wallet->bindValue(':reward', intval($reward), PDO::PARAM_INT);
			$query_wallet->bindValue(':user_id', trim($user_id), PDO::PARAM_STR);
			$query_wallet->execute();
			if($query_wallet){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/* GET TIMELINE FOR USER */
	public function getTimeline($user_id) {
		if($this->databaseConnection()) {
			$query_timeline = $this->db_connection->prepare("SELECT * FROM t_user_activity WHERE user_id = :user_id ORDER BY timestamp DESC");
			$query_timeline->bindValue(':user_id', intval($user_id), PDO::PARAM_INT);
			$query_timeline->execute();
			return $query_timeline->fetchAll();
		} else {
			return false;
		}
	}

	/* COUNT FOR CHECKIN DONE BY A USER */
	public function getCheckinStatForUser($user_id) {
		if($this->databaseConnection()) {
			$query_activity = $this->db_connection->prepare("SELECT count(activity_id) as \"activity\" FROM t_user_activity WHERE user_id = :user_id AND activity_type = :activity_type");
			$query_activity->bindValue(':user_id', intval($user_id), PDO::PARAM_INT);
			$query_activity->bindValue(':activity_type', trim("Ad Located"), PDO::PARAM_STR);
			$query_activity->execute();
			$activity = $query_activity->fetchObject();
			return $activity->activity;
		} else {
			return false;
		}
	}

	/* COUNT FOR QUIZ ANSWERED BY A USER */
	public function getAnsweredQuizStat($user_id) {
		if($this->databaseConnection()) {
			$query_activity = $this->db_connection->prepare("SELECT count(activity_id) as \"activity\" FROM t_user_activity WHERE user_id = :user_id AND activity_type = :activity_type");
			$query_activity->bindValue(':user_id', intval($user_id), PDO::PARAM_INT);
			$query_activity->bindValue(':activity_type', trim("Quiz Answered"), PDO::PARAM_STR);
			$query_activity->execute();
			$activity = $query_activity->fetchObject();
			return $activity->activity;
		} else {
			return false;
		}
	}

	public function createCampaign($campaign_name, $store_id) {
		if($this->databaseConnection()) {
			$query_campaign = $this->db_connection->prepare("INSERT INTO t_campaign (campaign_name, store_id) VALUES (:campaign_name, :store_id)");
			$query_campaign->bindValue(':store_id', intval($store_id), PDO::PARAM_INT);
			$query_campaign->bindValue(':campaign_name', trim($campaign_name), PDO::PARAM_STR);
			$query_campaign->execute();
			return $this->db_connection->lastInsertId();
		} else {
			return -1;
		}
	}

	public function createAd($ad_struct) {
		if($this->databaseConnection()) {
			$query_ad = $this->db_connection->prepare("INSERT INTO t_ads (campaign_id, ad_name, product_name, product_url, company_name, company_url, company_logo, coverage_radius, ads_banner, off_deal, coupon_code, deal_link, associated_store, min_entry_age, max_entry_age, entry_gender, location_count, quiz_count, reward_amount, start_date, end_date, exclusion_days) VALUES (:campaign_id, :ad_name, :product_name, :product_url, :company_name, :company_url, :company_logo, :coverage_radius, :ads_banner, :off_deal, :coupon_code, :deal_link, :associated_store, :min_entry_age, :max_entry_age, :entry_gender, :location_count, :quiz_count, :reward_amount, :start_date, :end_date, :exclusion_days)");
			$query_ad->bindValue(':campaign_id', trim($ad_struct->campaign_id), PDO::PARAM_STR);
			$query_ad->bindValue(':ad_name', trim($ad_struct->ad_name), PDO::PARAM_STR);
			$query_ad->bindValue(':product_name', trim($ad_struct->product_name), PDO::PARAM_STR);
			$query_ad->bindValue(':product_url', trim($ad_struct->product_url), PDO::PARAM_STR);
			$query_ad->bindValue(':company_name', trim($ad_struct->company_name), PDO::PARAM_STR);
			$query_ad->bindValue(':company_url', trim($ad_struct->company_url), PDO::PARAM_STR);
			$query_ad->bindValue(':company_logo', trim($ad_struct->company_logo), PDO::PARAM_STR);
			$query_ad->bindValue(':coverage_radius', intval(trim($ad_struct->coverage_radius)), PDO::PARAM_INT);
			$query_ad->bindValue(':ads_banner', trim($ad_struct->ads_banner), PDO::PARAM_STR);
			$query_ad->bindValue(':associated_store', trim($ad_struct->associated_store), PDO::PARAM_STR);
			$query_ad->bindValue(':reward_amount', intval(trim($ad_struct->reward_amount)), PDO::PARAM_INT);
			$query_ad->bindValue(':min_entry_age', intval(trim($ad_struct->min_entry_age)), PDO::PARAM_INT);
			$query_ad->bindValue(':max_entry_age', intval(trim($ad_struct->max_entry_age)), PDO::PARAM_INT);
			$query_ad->bindValue(':entry_gender', trim($ad_struct->entry_gender), PDO::PARAM_STR);
			$query_ad->bindValue(':location_count', intval(trim($ad_struct->location_count)), PDO::PARAM_INT);
			$query_ad->bindValue(':quiz_count', intval(trim($ad_struct->question_count)), PDO::PARAM_INT);
			$query_ad->bindValue(':off_deal', trim($ad_struct->off_deal), PDO::PARAM_STR);
			$query_ad->bindValue(':coupon_code', trim($ad_struct->coupon_code), PDO::PARAM_STR);
			$query_ad->bindValue(':deal_link', trim($ad_struct->deal_link), PDO::PARAM_STR);
			$query_ad->bindValue(':start_date', trim($ad_struct->start_date), PDO::PARAM_STR);
			$query_ad->bindValue(':end_date', trim($ad_struct->end_date), PDO::PARAM_STR);
			$query_ad->bindValue(':exclusion_days', trim($ad_struct->exclusion_days), PDO::PARAM_STR);
			$query_ad->execute();
			if($query_ad->rowCount() > 0) {
				return $this->db_connection->lastInsertId();
			} else {
				return $query_ad->errorInfo();
			}
		} else {
			return -1;
		}
	}

	public function updateAd($ad_struct) {
		if($this->databaseConnection()) {
			$query_ad = $this->db_connection->prepare("UPDATE t_ads SET campaign_id = :campaign_id, ad_name = :ad_name, product_name = :product_name, product_url = :product_url, company_name = :company_name, company_url = :company_url, company_logo = :company_logo, coverage_radius = :coverage_radius, ads_banner = :ads_banner, off_deal = :off_deal, coupon_code = :coupon_code, deal_link = :deal_link, associated_store = :associated_store, min_entry_age = :min_entry_age, max_entry_age = :max_entry_age, entry_gender = :entry_gender, reward_amount = :reward_amount, start_date = :start_date, end_date = :end_date, exclusion_days = :exclusion_days WHERE ad_id = :ad_id");
			$query_ad->bindValue(':ad_id', trim($ad_struct->ad_id), PDO::PARAM_STR);
			$query_ad->bindValue(':campaign_id', trim($ad_struct->campaign_id), PDO::PARAM_STR);
			$query_ad->bindValue(':ad_name', trim($ad_struct->ad_name), PDO::PARAM_STR);
			$query_ad->bindValue(':product_name', trim($ad_struct->product_name), PDO::PARAM_STR);
			$query_ad->bindValue(':product_url', trim($ad_struct->product_url), PDO::PARAM_STR);
			$query_ad->bindValue(':company_name', trim($ad_struct->company_name), PDO::PARAM_STR);
			$query_ad->bindValue(':company_url', trim($ad_struct->company_url), PDO::PARAM_STR);
			$query_ad->bindValue(':company_logo', trim($ad_struct->company_logo), PDO::PARAM_STR);
			$query_ad->bindValue(':coverage_radius', intval(trim($ad_struct->coverage_radius)), PDO::PARAM_INT);
			$query_ad->bindValue(':ads_banner', trim($ad_struct->ads_banner), PDO::PARAM_STR);
			$query_ad->bindValue(':associated_store', trim($ad_struct->associated_store), PDO::PARAM_STR);
			$query_ad->bindValue(':reward_amount', intval(trim($ad_struct->reward_amount)), PDO::PARAM_INT);
			$query_ad->bindValue(':min_entry_age', intval(trim($ad_struct->min_entry_age)), PDO::PARAM_INT);
			$query_ad->bindValue(':max_entry_age', intval(trim($ad_struct->max_entry_age)), PDO::PARAM_INT);
			$query_ad->bindValue(':entry_gender', trim($ad_struct->entry_gender), PDO::PARAM_STR);
			$query_ad->bindValue(':off_deal', trim($ad_struct->off_deal), PDO::PARAM_STR);
			$query_ad->bindValue(':coupon_code', trim($ad_struct->coupon_code), PDO::PARAM_STR);
			$query_ad->bindValue(':deal_link', trim($ad_struct->deal_link), PDO::PARAM_STR);
			$query_ad->bindValue(':start_date', trim($ad_struct->start_date), PDO::PARAM_STR);
			$query_ad->bindValue(':end_date', trim($ad_struct->end_date), PDO::PARAM_STR);
			$query_ad->bindValue(':exclusion_days', trim($ad_struct->exclusion_days), PDO::PARAM_STR);
			$query_ad->execute();
			if($query_ad->rowCount() > 0) {
				return 1;
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}

	public function updateAudience($ad_id, $min_entry_age, $max_entry_age, $entry_gender, $moby_audience, $loyalty_audience, $salary_group, $club_membership, $defence_service, $work_type, $watch_brand, $car_brand, $residence_type, $transport_type, $miles_card, $credit_card) {
		if($this->databaseConnection()) {
			$query_audience = $this->db_connection->prepare("UPDATE t_ads SET min_entry_age = :min_entry_age, max_entry_age = :max_entry_age, entry_gender = :entry_gender, moby_audience = :moby_audience, loyalty_audience = :loyalty_audience, salary_group = :salary_group, club_membership = :club_membership, defence_service = :defence_service, work_type = :work_type, watch_brand = :watch_brand, car_brand = :car_brand, residence_type = :residence_type, transport_type = :transport_type, miles_card = :miles_card, credit_card = :credit_card WHERE ad_id = :ad_id");
			$query_audience->bindValue(':min_entry_age', intval($min_entry_age), PDO::PARAM_INT);
			$query_audience->bindValue(':max_entry_age', intval($max_entry_age), PDO::PARAM_INT);
			$query_audience->bindValue(':entry_gender', trim($entry_gender), PDO::PARAM_STR);
			$query_audience->bindValue(':ad_id', trim($ad_id), PDO::PARAM_STR);
			$query_audience->bindValue(':moby_audience', trim($moby_audience), PDO::PARAM_STR);
			$query_audience->bindValue(':loyalty_audience', trim($loyalty_audience), PDO::PARAM_STR);
			$query_audience->bindValue(':salary_group', trim($salary_group), PDO::PARAM_STR);
			$query_audience->bindValue(':club_membership', trim($club_membership), PDO::PARAM_STR);
			$query_audience->bindValue(':defence_service', trim($defence_service), PDO::PARAM_STR);
			$query_audience->bindValue(':work_type', trim($work_type), PDO::PARAM_STR);
			$query_audience->bindValue(':watch_brand', trim($watch_brand), PDO::PARAM_STR);
			$query_audience->bindValue(':car_brand', trim($car_brand), PDO::PARAM_STR);
			$query_audience->bindValue(':residence_type', trim($residence_type), PDO::PARAM_STR);
			$query_audience->bindValue(':transport_type', trim($transport_type), PDO::PARAM_STR);
			$query_audience->bindValue(':miles_card', trim($miles_card), PDO::PARAM_STR);
			$query_audience->bindValue(':credit_card', trim($credit_card), PDO::PARAM_STR);
			$query_audience->execute();
			if($query_audience->rowCount() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/* SAVE LOCATION TO AD
	* Params:- ad_id, latitude, longitude 
	* Return:- true/false
	*/
	public function addNewLocationToAd($ad_id, $location_lat, $location_long, $location_state, $landmark, $email, $contact) {
		if ($this->databaseConnection()) {
			$query_location = $this->db_connection->prepare("INSERT INTO t_ad_location (ad_id, location_lat, location_long, location_state, landmark, email, contact) VALUES (:ad_id, :location_lat, :location_long, :location_state, :landmark, :email, :contact)");
			$query_location->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$query_location->bindValue(':location_lat', trim($location_lat), PDO::PARAM_STR);
			$query_location->bindValue(':location_long', trim($location_long), PDO::PARAM_STR);
			$query_location->bindValue(':location_state', trim(strtolower($location_state)), PDO::PARAM_STR);
			$query_location->bindValue(':landmark', trim(strtolower($landmark)), PDO::PARAM_STR);
			$query_location->bindValue(':email', trim(strtolower($email)), PDO::PARAM_STR);
			$query_location->bindValue(':contact', trim(strtolower($contact)), PDO::PARAM_STR);
			$query_location->execute();
			// print_r($query_location->errorInfo());
			if($query_location->rowCount() > 0) {
				return $this->db_connection->lastInsertId();
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}

	/* UPDATE THE NUBE FOF LOCATION IN A ADS */
	public function updateLocationCountAd($ad_id, $location_count) {
		if ($this->databaseConnection()) {
			$query_location_count = $this->db_connection->prepare("UPDATE t_ads SET version_id = version_id+1, location_count = :location_count WHERE ad_id = :ad_id LIMIT 1");
			$query_location_count->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$query_location_count->bindValue(':location_count', trim($location_count), PDO::PARAM_STR);
			$query_location_count->execute();
			if($query_location_count->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function decreaseLocationCount($ad_id) {
		if($this->databaseConnection()) {
			$ad_query = $this->db_connection->prepare("UPDATE t_ads SET version_id = version_id+1, location_count = location_count-1");
			$ad_query->execute();
			if($ad_query->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return FALSE;
		}
	}

	public function increaseLocationCount($ad_id) {
		if($this->databaseConnection()) {
			$ad_query = $this->db_connection->prepare("UPDATE t_ads SET version_id = version_id+1, location_count = location_count+1");
			$ad_query->execute();
			if($ad_query->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return FALSE;
		}
	}

	/* UPDATE THE NUBE FOF QUESTION IN A ADS */
	public function updateQuestionCountAd($ad_id, $quiz_count) {
		if ($this->databaseConnection()) {
			$query_question_count = $this->db_connection->prepare("UPDATE t_ads SET version_id = version_id+1, quiz_count = :quiz_count WHERE ad_id = :ad_id LIMIT 1");
			$query_question_count->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$query_question_count->bindValue(':quiz_count', trim($quiz_count), PDO::PARAM_STR);
			$query_question_count->execute();
			if($query_question_count->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function addQuestionToAd($ad_id, $question, $options, $answer, $reward_amount) {
		if($this->databaseConnection()) {
			$query_question = $this->db_connection->prepare("INSERT INTO t_quiz (ad_id, question, options, answer, reward_amount) VALUES (:ad_id, :question, :options, :answer, :reward_amount)");
			$query_question->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$query_question->bindValue(':question', trim($question), PDO::PARAM_STR);
			$query_question->bindValue(':options', trim($options), PDO::PARAM_STR);
			$query_question->bindValue(':answer', trim($answer), PDO::PARAM_STR);
			$query_question->bindValue(':reward_amount', intval(trim($reward_amount)), PDO::PARAM_INT);
			$query_question->execute();
			// print_r($query_question->errorInfo());
			if($query_question->rowCount() > 0) {
				return $this->db_connection->lastInsertId();
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}

	public function removePreviousQuestions($ad_id) {
		if ($this->databaseConnection()) {
			$query_publish = $this->db_connection->prepare("DELETE FROM t_quiz WHERE ad_id = :ad_id");
			$query_publish->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$query_publish->execute();
			if($query_publish->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function publishAd($ad_id) {
		if ($this->databaseConnection()) {
			$query_publish = $this->db_connection->prepare("UPDATE t_ads SET version_id = version_id+1, publish = :publish WHERE ad_id = :ad_id LIMIT 1");
			$query_publish->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$query_publish->bindValue(':publish', trim("yes"), PDO::PARAM_STR);
			$query_publish->execute();
			if($query_publish->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function updateQuiz($quiz_id, $question, $options, $answer, $reward_amount) {
		if($this->databaseConnection()) {
			$update_question = $this->db_connection->prepare("UPDATE t_quiz SET question = :question, options = :options, answer = :answer, reward_amount = :reward_amount WHERE quiz_id IN (:quiz_id)");
			$update_question->bindParam(':quiz_id', intval($quiz_id), PDO::PARAM_INT);
			$update_question->bindValue(':question', trim($question), PDO::PARAM_STR);
			$update_question->bindValue(':options', trim($options), PDO::PARAM_STR);
			$update_question->bindValue(':answer', trim($answer), PDO::PARAM_STR);
			$update_question->bindValue(':reward_amount', intval(trim($reward_amount)), PDO::PARAM_INT);
			$update_question->execute();
			// print_r($query_question->errorInfo());
			if($update_question->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/* UPDATE THE NUBE FOF LOCATION IN A ADS */
	public function updateLocationCountAfterDeleteLocation($ad_id, $count) {
		//echo $count;
		if ($this->databaseConnection()) {
			$query_location_count = $this->db_connection->prepare("UPDATE t_ads SET version_id = version_id+1, location_count = :location_count WHERE ad_id = :ad_id LIMIT 1");
			$query_location_count->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$query_location_count->bindValue(':location_count', trim($count), PDO::PARAM_STR);
			$query_location_count->execute();
			if($query_location_count->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function deleteLatLong($location_id) {
		// if database connection opened
		//echo $questions;
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$delete_lat_long = $this->db_connection->prepare('DELETE FROM t_ad_location WHERE location_id =  :location_id');
			$delete_lat_long->bindValue(':location_id', trim($location_id), PDO::PARAM_STR);
			$delete_lat_long->execute();
			$count = $delete_lat_long->rowCount();
			// get result row (as an object)
			// print_r($query_user->errorInfo());
			if($delete_lat_long) {
				return $count;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function deleteOldLocationForAd($ad_id) {
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$delete_lat_long = $this->db_connection->prepare('DELETE FROM t_ad_location WHERE ad_id = :ad_id');
			$delete_lat_long->bindValue(':ad_id', trim($ad_id), PDO::PARAM_STR);
			$delete_lat_long->execute();
			$count = $delete_lat_long->rowCount();
			// get result row (as an object)
			// print_r($query_user->errorInfo());
			if($delete_lat_long) {
				return $count;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function getStoreForUserId($user_id) {
		// if database connection opened
		if ($this->databaseConnection()) {
			$query_store = $this->db_connection->prepare('SELECT * FROM t_store WHERE owner_id = :owner_id LIMIT 1');
			$query_store->bindValue(':owner_id', trim($user_id), PDO::PARAM_STR);
			$query_store->execute();
			// get result row (as an object)
			return $query_store->fetchObject();
		} else {
			return false;
		}
	}


	public function insertTransaction($user_id, $ad_id, $store_id, $transaction_type, $transaction_status, $failure_reason, $reward_amount, $order_id, $paytm_transaction_id) {

		if ($this->databaseConnection()) {
			$query_transaction = $this->db_connection->prepare('INSERT INTO t_transaction (user_id, ad_id, store_id, transaction_type, transaction_status, failure_reason, reward_amount, order_id, paytm_transaction_id) VALUES (:user_id, :ad_id, :store_id, :transaction_type, :transaction_status, :failure_reason, :reward_amount, :order_id, :paytm_transaction_id)');
			$query_transaction->bindValue(':user_id', trim($user_id), PDO::PARAM_STR);
			$query_transaction->bindValue(':ad_id', trim($ad_id), PDO::PARAM_STR);
			$query_transaction->bindValue(':store_id', trim($store_id), PDO::PARAM_STR);
			$query_transaction->bindValue(':transaction_type', trim($transaction_type), PDO::PARAM_STR);
			$query_transaction->bindValue(':transaction_status', trim($transaction_status), PDO::PARAM_STR);
			$query_transaction->bindValue(':failure_reason', trim($failure_reason), PDO::PARAM_STR);
			$query_transaction->bindValue(':reward_amount', trim($reward_amount), PDO::PARAM_STR);
			$query_transaction->bindValue(':order_id', trim($order_id), PDO::PARAM_STR);
			$query_transaction->bindValue(':paytm_transaction_id', trim($paytm_transaction_id), PDO::PARAM_STR);
			$query_transaction->execute();
			// get result row (as an object)
			if($query_transaction->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function createStoreUser($user_email, $user_contact, $user_password, $store_name, $user_type) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_user = $this->db_connection->prepare('INSERT INTO t_user (user_email, user_contact, user_password, user_name, user_type) VALUES (:user_email, :user_contact, :user_password, :user_name, :user_type)');
			$query_user->bindValue(':user_contact', trim($user_contact), PDO::PARAM_STR);
			$query_user->bindValue(':user_type', trim($user_type), PDO::PARAM_STR);
			$query_user->bindValue(':user_email', trim($user_email), PDO::PARAM_STR);
			$query_user->bindValue(':user_password', trim($user_password), PDO::PARAM_STR);
			$query_user->bindValue(':user_name', trim($store_name), PDO::PARAM_STR);
			$query_user->execute();
			// get result row (as an object)
			// print_r($query_user->errorInfo());
			if($query_user->rowCount() > 0) {
				return $this->db_connection->lastInsertId();
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}

	public function createStore($store_struct) {
		// if database connection opened
		if ($this->databaseConnection()) {
			// database query, getting all the info of the selected user
			$query_store = $this->db_connection->prepare('INSERT INTO t_store (store_name, store_website, store_contact, store_address, store_city, store_state, store_pincode, owner_id, wallet_guid, wallet_amount, subscribed, company_cin, incorporation_date, company_gst) VALUES (:store_name, :store_website, :store_contact, :store_address, :store_city, :store_state, :store_pincode, :owner_id, :wallet_guid, :wallet_amount, :subscribed, :company_cin, :incorporation_date, :company_gst)');
			$query_store->bindValue(':store_name', trim($store_struct->store_name), PDO::PARAM_STR);
			$query_store->bindValue(':store_website', trim($store_struct->store_website), PDO::PARAM_STR);
			$query_store->bindValue(':store_contact', trim($store_struct->store_contact), PDO::PARAM_STR);
			$query_store->bindValue(':store_address', trim($store_struct->store_address), PDO::PARAM_STR);
			$query_store->bindValue(':store_city', trim($store_struct->store_city), PDO::PARAM_STR);
			$query_store->bindValue(':store_state', trim($store_struct->store_state), PDO::PARAM_STR);
			$query_store->bindValue(':store_pincode', trim($store_struct->store_pincode), PDO::PARAM_STR);
			$query_store->bindValue(':owner_id', trim($store_struct->owner_id), PDO::PARAM_STR);
			$query_store->bindValue(':wallet_guid', trim($store_struct->wallet_guid), PDO::PARAM_STR);
			$query_store->bindValue(':wallet_amount', trim($store_struct->wallet_amount), PDO::PARAM_STR);
			$query_store->bindValue(':subscribed', trim($store_struct->subscribed), PDO::PARAM_STR);
			$query_store->bindValue(':company_cin', trim($store_struct->company_cin), PDO::PARAM_STR);
			$query_store->bindValue(':incorporation_date', trim($store_struct->incorporation_date), PDO::PARAM_STR);
			$query_store->bindValue(':company_gst', trim($store_struct->company_gst), PDO::PARAM_STR);
			$query_store->execute();
			// get result row (as an object)
			// print_r($query_store->errorInfo());
			if($query_store->rowCount() > 0) {
				return $this->db_connection->lastInsertId();
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}

	/*
	* 
	*/
	public function getTransactionForAd($ad_id) {
		if ($this->databaseConnection()) {
			$transaction_query = $this->db_connection->prepare("SELECT * FROM t_transaction WHERE ad_id = :ad_id");
			$transaction_query->bindValue(':ad_id', intval(trim($ad_id)), PDO::PARAM_INT);
			$transaction_query->execute();
			if($transaction_query->rowCount() > 0) {
				return $transaction_query->fetchAll();
			} else {
				echo("NO TRANSITION FOUND");
				
			}
		} else {
			return CONNECTION_ERROR;
		}
	}


	public function getTransactionForUser($user_id) {
		if ($this->databaseConnection()) {
			$transaction_query = $this->db_connection->prepare("SELECT * FROM t_transaction WHERE user_id = :user_id");
			$transaction_query->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
			$transaction_query->execute();
			if($transaction_query->rowCount() > 0) {
				return $transaction_query->fetchAll();
			} else {
				return NO_TRANSACTION_FOUND_FOR_AD;
			}
		} else {
			return CONNECTION_ERROR;
		}
	}
	
	public function updatePassword($user_id, $password) {
		if($this->databaseConnection()) {
			$password_query = $this->db_connection->prepare("UPDATE t_user SET user_password = :password WHERE user_id = :user_id");
			$password_query->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
			$password_query->bindValue(':password', trim($password), PDO::PARAM_STR);
			$password_query->execute();
			if($password_query->rowCount() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return false;
		}
	}

	public function updateStoreDetail($store_struct) {
		if($this->databaseConnection()) {
			$query_store = $this->db_connection->prepare("UPDATE t_store SET store_name = :store_name, store_website = :store_website, store_contact = :store_contact, store_address = :store_address, store_city = :store_city, store_state = :store_state, store_pincode = :store_pincode, wallet_guid = :wallet_guid, wallet_amount = :wallet_amount, subscribed = :subscribed WHERE store_id = :store_id");
			$query_store->bindValue(':store_name', trim($store_struct->store_name), PDO::PARAM_STR);
			$query_store->bindValue(':store_website', trim($store_struct->store_website), PDO::PARAM_STR);
			$query_store->bindValue(':store_contact', trim($store_struct->store_contact), PDO::PARAM_STR);
			$query_store->bindValue(':store_address', trim($store_struct->store_address), PDO::PARAM_STR);
			$query_store->bindValue(':store_city', trim($store_struct->store_city), PDO::PARAM_STR);
			$query_store->bindValue(':store_state', trim($store_struct->store_state), PDO::PARAM_STR);
			$query_store->bindValue(':store_pincode', trim($store_struct->store_pincode), PDO::PARAM_STR);
			$query_store->bindValue(':wallet_guid', trim($store_struct->wallet_guid), PDO::PARAM_STR);
			$query_store->bindValue(':wallet_amount', trim($store_struct->wallet_amount), PDO::PARAM_STR);
			$query_store->bindValue(':subscribed', trim($store_struct->subscribed), PDO::PARAM_STR);
			$query_store->bindValue(':store_id', trim($store_struct->store_id), PDO::PARAM_STR);
			$query_store->execute();
			if ($query_store->rowCount() > 0 ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function updateStoreProfile($store_struct) {
		if($this->databaseConnection()) {
			$query_store = $this->db_connection->prepare("UPDATE t_store SET store_name = :store_name, store_website = :store_website, store_contact = :store_contact, store_address = :store_address, store_city = :store_city, store_state = :store_state, store_pincode = :store_pincode, store_landmark = :store_landmark WHERE store_id = :store_id");
			$query_store->bindValue(':store_name', trim($store_struct->store_name), PDO::PARAM_STR);
			$query_store->bindValue(':store_website', trim($store_struct->store_website), PDO::PARAM_STR);
			$query_store->bindValue(':store_contact', trim($store_struct->store_contact), PDO::PARAM_STR);
			$query_store->bindValue(':store_address', trim($store_struct->store_address), PDO::PARAM_STR);
			$query_store->bindValue(':store_city', trim($store_struct->store_city), PDO::PARAM_STR);
			$query_store->bindValue(':store_state', trim($store_struct->store_state), PDO::PARAM_STR);
			$query_store->bindValue(':store_pincode', trim($store_struct->store_pincode), PDO::PARAM_STR);
			$query_store->bindValue(':store_landmark', trim($store_struct->store_landmark), PDO::PARAM_STR);
			$query_store->bindValue(':store_id', trim($store_struct->store_id), PDO::PARAM_STR);
			$query_store->execute();
			// print_r($query_store->errorInfo());
			if ($query_store->rowCount() > 0 ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function getTransaction($user_id, $ad_id, $transaction_status) {
		if($this->databaseConnection()) {
			$transaction_query = $this->db_connection->prepare("SELECT * FROM t_transaction WHERE user_id = :user_id AND ad_id = :ad_id AND transaction_status = :transaction_status LIMIT 1");
			$transaction_query->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
			$transaction_query->bindValue(':ad_id', intval(trim($ad_id)), PDO::PARAM_INT);
			$transaction_query->bindValue(':transaction_status', trim($transaction_status), PDO::PARAM_STR);
			$transaction_query->execute();
			if ($transaction_query->rowCount() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	/**
	 * GET CODE DETAIL
	 * @return [type] [description]
	 */
	public function getCodeType() {
		if($this->databaseConnection()) {
			$code_query = $this->db_connection->prepare("SELECT * FROM t_code");
			$code_query->execute();
			if ($code_query->rowCount() > 0) {
				return $code_query->fetchAll();
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function getCodeId($code_type, $code_label) {
		if($code_label != "" || $code_label != NULL) {
			if($this->databaseConnection()) {
				$code_query = $this->db_connection->prepare("SELECT * FROM t_code WHERE code_type = :code_type AND code_label = :code_label");
				$code_query->bindValue(':code_type', trim($code_type), PDO::PARAM_STR);
				$code_query->bindValue(':code_label', trim($code_label), PDO::PARAM_STR);
				$code_query->execute();
				if ($code_query->rowCount() > 0) {
					$code = $code_query->fetchObject();
					return $code->code_id;
				} else {
					return "";
				}
			} else {
				return FALSE;
			}
		} else {
			return "";
		}
	}

	public function getCodeDetail($code_type) {
		if($code_type != "") {
			if($this->databaseConnection()) {
				$code_query = $this->db_connection->prepare("SELECT * FROM t_code WHERE code_type = :code_type LIMIT 1");
				$code_query->bindValue(':code_type', trim($code_type), PDO::PARAM_STR);
				$code_query->execute();
				if ($code_query->rowCount() > 0) {
					return  $code_query->fetchObject();
					
				} else {
					return "";
				}
			} else {
				return FALSE;
			}
		} else {
			return "";
		}
	}

	public function insertCodeSetting($code_type, $code_value, $code_label){
		if($this->databaseConnection()) {
			$code_query = $this->db_connection->prepare("INSERT INTO t_code (code_type, code_value, code_label) VALUES (:code_type, :code_value, :code_label)");
			$code_query->bindValue(':code_type', trim($code_type), PDO::PARAM_STR);
			$code_query->bindValue(':code_value', trim($code_value), PDO::PARAM_STR);
			$code_query->bindValue(':code_label', trim($code_label), PDO::PARAM_STR);
			$code_query->execute();
			if ($code_query->rowCount() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/**
	 * GET THE DETAILS OF THE PRODUCTS IN A STORE
	 * @param  [type] $store_id [description]
	 * @return [type]           [description]
	 */
	public function getProducts($store_id) {
		if($this->databaseConnection()) {
			$product_query = $this->db_connection->prepare("SELECT * FROM t_product WHERE store_id = :store_id");
			$product_query->bindValue(':store_id', trim($store_id), PDO::PARAM_STR);
			$product_query->execute();
			if ($product_query->rowCount() > 0) {
				return $product_query->fetchAll();
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/**
	 * CREATE NEW PRODUCT FOR A STORE
	 * @param  [type] $store_id     [description]
	 * @param  [type] $product_name [description]
	 * @param  [type] $product_url  [description]
	 * @return BOOLEAN TRUE/FALSE
	 */
	public function createProduct($store_id, $product_name, $product_url) {
		if($this->databaseConnection()) {
			$product_query = $this->db_connection->prepare("INSERT INTO t_product (store_id, product_name, product_url) VALUES (:store_id, :product_name, :product_url);");
			$product_query->bindValue(':store_id', trim($store_id), PDO::PARAM_STR);
			$product_query->bindValue(':product_name', trim($product_name), PDO::PARAM_STR);
			$product_query->bindValue(':product_url', trim($product_url), PDO::PARAM_STR);
			$product_query->execute();
			if ($product_query->rowCount() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}


	public function getMessages() {
		if($this->databaseConnection()) {
			$message_query = $this->db_connection->prepare("SELECT * FROM t_message ORDER BY updated_timestamp DESC LIMIT 15");
			$message_query->execute();
			if ($message_query->rowCount() > 0) {
				return $message_query->fetchAll();
			} else {
				return MESSAGES_NOT_FOUND;
			}
		} else {
			return MESSAGE_DATABASE_ERROR;
		}
	}

	public function updateMessageSeen($user_id, $last_seen_message) {
		if($this->databaseConnection()) {
			$message_query = $this->db_connection->prepare("UPDATE t_user SET last_seen_message = :last_seen_message WHERE user_id = :user_id");
			$message_query->bindValue(':last_seen_message', trim($last_seen_message), PDO::PARAM_STR);
			$message_query->bindValue(':user_id', trim($user_id), PDO::PARAM_STR);
			$message_query->execute();
			if ($message_query->rowCount() > 0) {
				return TRUE;
			} else {
				return MESSAGES_NOT_FOUND;
			}
		} else {
			return MESSAGE_DATABASE_ERROR;
		}
	}

	public function createMessage($message_struct) {
		if($this->databaseConnection()) {
			$message_query = $this->db_connection->prepare("INSERT INTO t_message (message_title, message_content, min_entry_age, max_entry_age, entry_gender, salary_group, work_type, residence_type, transport_type, club_type, defence_service, watch_brand, car_brand, miles_card, credit_card) VALUES (:message_title, :message_content, :min_entry_age, :max_entry_age, :entry_gender, :salary_group, :work_type, :residence_type, :transport_type, :club_type, :defence_service, :watch_brand, :car_brand, :miles_card, :credit_card)");
			$message_query->bindValue(':message_title', trim($message_struct->message_title), PDO::PARAM_STR);
			$message_query->bindValue(':message_content', trim($message_struct->message_content), PDO::PARAM_STR);
			$message_query->bindValue(':min_entry_age', trim($message_struct->min_entry_age), PDO::PARAM_STR);
			$message_query->bindValue(':max_entry_age', trim($message_struct->max_entry_age), PDO::PARAM_STR);
			$message_query->bindValue(':entry_gender', trim($message_struct->entry_gender), PDO::PARAM_STR);
			$message_query->bindValue(':salary_group', trim($message_struct->salary_group), PDO::PARAM_STR);
			$message_query->bindValue(':work_type', trim($message_struct->work_type), PDO::PARAM_STR);
			$message_query->bindValue(':residence_type', trim($message_struct->residence_type), PDO::PARAM_STR);
			$message_query->bindValue(':transport_type', trim($message_struct->transport_type), PDO::PARAM_STR);
			$message_query->bindValue(':club_type', trim($message_struct->club_type), PDO::PARAM_STR);
			$message_query->bindValue(':defence_service', trim($message_struct->defence_service), PDO::PARAM_STR);
			$message_query->bindValue(':watch_brand', trim($message_struct->watch_brand), PDO::PARAM_STR);
			$message_query->bindValue(':car_brand', trim($message_struct->car_brand), PDO::PARAM_STR);
			$message_query->bindValue(':miles_card', trim($message_struct->miles_card), PDO::PARAM_STR);
			$message_query->bindValue(':credit_card', trim($message_struct->credit_card), PDO::PARAM_STR);
			$message_query->execute();
			// print_r($message_query->errorInfo());
			if ($message_query->rowCount() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function getLastMessage() {
		if($this->databaseConnection()) {
			$message_query = $this->db_connection->prepare("SELECT * FROM t_message ORDER BY message_id DESC LIMIT 1");
			$message_query->execute();
			if ($message_query->rowCount() > 0) {
				return $message_query->fetchObject();
			} else {
				return MESSAGES_NOT_FOUND;
			}
		} else {
			return MESSAGE_DATABASE_ERROR;
		}
	}

	public function getTransactionByDate($from_date, $to_date) {
		if($this->databaseConnection()) {
			$transaction_query = $this->db_connection->prepare("SELECT * FROM t_transaction WHERE timestamp BETWEEN :from_date AND :to_date");
			$transaction_query->bindValue(':from_date', trim($from_date), PDO::PARAM_STR);
			$transaction_query->bindValue(':to_date', trim($to_date), PDO::PARAM_STR);
			$transaction_query->execute();
			if ($transaction_query->rowCount() > 0) {
				return $transaction_query->fetchAll();
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function getLocationAtCounter($ad_id, $counter_to_delete) {
		if($this->databaseConnection()) {
			$location_query = $this->db_connection->prepare("SELECT * FROM t_ad_location WHERE ad_id = :ad_id LIMIT :counter,1");
			$location_query->bindValue(':ad_id', intval($ad_id), PDO::PARAM_INT);
			$location_query->bindValue(':counter', intval($counter_to_delete), PDO::PARAM_INT);
			$location_query->execute();
			if ($location_query->rowCount() > 0) {
				return $location_query->fetchObject();
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function deleteLocation($location_id) {
		if($this->databaseConnection()) {
			$location_query = $this->db_connection->prepare("DELETE FROM t_ad_location WHERE location_id = :location_id");
			$location_query->bindValue(':location_id', intval($location_id), PDO::PARAM_INT);
			$location_query->execute();
			if ($location_query->rowCount() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
}


?>