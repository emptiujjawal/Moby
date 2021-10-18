<?php 

/**
* 
*/
class Operations {
	
	public $message_list = [];
	public $error_list = [];

	function __construct() {

	}
	
	public function login($login_struct) {
		if ($login_struct->user_contact != "") {
			$response = [];
			$CommonFunc = new CommonFunctions();
			/* check if user exist for that contact number */
			$user_detail = $CommonFunc->getUserDetailFromContact($login_struct->user_contact);
			// echo json_encode($user_detail);
			if (is_object($user_detail)) {
				if ($login_struct->logged_in_using == "generic") {
					if(md5($login_struct->user_password) == $user_detail->user_password) {
						$response["display_message"] = CONTACT_NUMBER_ALREADY_AVAILABLE;
						$response["user_detail"]["user_name"] = $user_detail->user_name;
						$response["user_detail"]["user_email"] = $user_detail->user_email;
						$response["user_detail"]["gender"] = $user_detail->user_gender;
						$response["user_detail"]["user_dob"] = $user_detail->user_dob;
						$response["user_detail"]["user_age"] = date("Y") - date_format(date_create($user_detail->user_dob), "Y");
						if($user_detail->user_photo != "") {
							$response["user_detail"]["user_photo"] = PROFILE_IMAGE_URL."".$user_detail->user_photo;
						} else {
							$response["user_detail"]["user_photo"] = "";
						}
						return $response;
					} else {
						return USER_CREDENTIAL_NOT_MATCH;
					}
				} else {
					$response["display_message"] = CONTACT_NUMBER_ALREADY_AVAILABLE;
					$response["user_detail"]["user_name"] = $user_detail->user_name;
					$response["user_detail"]["user_email"] = $user_detail->user_email;
					$response["user_detail"]["gender"] = $user_detail->user_gender;
					$response["user_detail"]["user_dob"] = $user_detail->user_dob;
					$response["user_detail"]["user_age"] = date("Y") - date_format(date_create($user_detail->user_dob), "Y");
					if($user_detail->user_photo != "") {
						$response["user_detail"]["user_photo"] = PROFILE_IMAGE_URL."".$user_detail->user_photo;
					} else {
						$response["user_detail"]["user_photo"] = "";
					}
					return $response;
				}
			} else {
				if($login_struct->user_password != "") {
					$login_struct->user_password = md5($login_struct->user_password);
				}

				$signup = $CommonFunc->createUser($login_struct);
				if($signup != -1) {

					/* store profile image*/
					if($login_struct->user_profile_image != "") {
						$this->storeProfileImage($login_struct->user_contact.".png", $login_struct->user_profile_image);
					}

					$response["display_message"] = NEW_USER_CREATED;
					$response["user_detail"]["user_name"] = $login_struct->user_name;
					$response["user_detail"]["user_email"] = $login_struct->user_email;
					$response["user_detail"]["gender"] = $login_struct->user_gender;
					$response["user_detail"]["user_dob"] = $login_struct->user_dob;
					$response["user_detail"]["user_age"] =  date("Y") - date_format(date_create($login_struct->user_dob), "Y");
					return $response;
				} else {
					return USER_CREATION_PROBLEM;
				}
			}
		} else {
			return CONTACT_NOT_FOUND;
		}
	}

	public function storeProfileImage($imageData, $file_name) {
		// remove "data:image/png;base64," and save to file
		$file_dir = "../mobi/images/profile/".$file_name;
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function storeProfileAdvertismentImage($imageData) {
		// remove "data:image/png;base64," and save to file
		$file_dir = "../mobi/images/profile_background/advertisment.jpeg";
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function storeAdsImage($imageData, $file_name) {
		// remove "data:image/png;base64," and save to file
		$file_dir = "../mobi/images/ad/".$file_name;
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function storeCompanyImage($imageData, $file_name) {
		// remove "data:image/png;base64," and save to file
		$file_dir = "../mobi/images/company/".$file_name;
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function storeStoreImage($imageData, $file_name) {
		// remove "data:image/png;base64," and save to file
		$file_dir = "../mobi/images/store/".$file_name;
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function storeUserProfileImage($imageData, $file_name) {
		$file_dir = "../mobi/images/profile/".$file_name;
		if(file_put_contents($file_dir, $imageData)) {
			return true;
		} else {
			return false;
		}
	}

	public function checkAdValidForToday($from_date, $to_date, $exclusion_days) {
		$take = FALSE;
		$week_day = date_format(date_create(date("Y-m-d")), "w");
		$today_date = date("Ymd");
		$start_date = date_format(date_create($from_date), "Ymd");
		$end_date = date_format(date_create($to_date), "Ymd");
		if($start_date <= $today_date && $today_date <= $end_date) {
			if(!in_array($week_day, $exclusion_days)) {
				$take = TRUE;
			}
		}
		return $take;
	}

	public function getAdsForState($get_ads_struct, $location_state) {
		$CommonFunc = new CommonFunctions();
		$ads = $CommonFunc->getAllPublishedAds();
		if(is_array($ads)) {
			$all_ads = [];
			foreach ($ads as $key => $ad) {
				
				$start_date = $ad["start_date"];
				$end_date = $ad["end_date"];
				$exclusion_days = explode(",", $ad["exclusion_days"]);

				if($this->checkAdValidForToday($start_date, $end_date, $exclusion_days)) {
					$take_this_ad = FALSE;
					$this_ad = [];
					$store_detail = $CommonFunc->getStoreDetail($ad["associated_store"]);
					$campaign_detail = $CommonFunc->getCampaignDetail($ad["campaign_id"]);
					$location_detail = $CommonFunc->getLocationForAds($ad["ad_id"], $ad["location_count"]);
					$quiz_detail = $CommonFunc->getQuizForAds($ad["ad_id"], $ad["quiz_count"]);
					$this_ad["ad_id"] = $ad["ad_id"];
					$this_ad["ad_name"] = $ad["ad_name"];
					if (filter_var($ad["ads_banner"], FILTER_VALIDATE_URL)) { 
						$this_ad["ad_banner"] = $ad["ads_banner"];
					} else {
						$this_ad["ad_banner"] = AD_IMAGE_URL.$ad["ads_banner"];
					}

					$this_ad["product_name"] = $ad["product_name"];
					$this_ad["product_url"] = $ad["product_url"];
					$this_ad["company_name"] = $ad["company_name"];
					$this_ad["company_url"] = $ad["company_url"];
					if (filter_var($ad["company_logo"], FILTER_VALIDATE_URL)) { 
						$this_ad["company_logo"] = $ad["company_logo"];
					} else {
						$this_ad["company_logo"] = COMPANY_IMAGE_URL.$ad["company_logo"];
					}
					$this_ad["ad_coverage"] = $ad["coverage_radius"];
					$this_ad["check_in_reward"] = $ad["reward_amount"];
					$this_ad["off_deal"] = $ad["off_deal"];
					$this_ad["coupon_code"] = $ad["coupon_code"];
					$this_ad["deal_link"] = $ad["deal_link"];
					$store = [];
					$store["store_id"] = $store_detail->store_id;
					$store["store_name"] = $store_detail->store_name;
					$store["store_photo_url"] = $store_detail->store_image;
					$store["store_area"] = $store_detail->store_address;
					$store["store_city"] = $store_detail->store_city;
					$store["store_pincode"] = $store_detail->store_pincode;
					$store["store_website"] = $store_detail->store_website;
					$store["store_contact"] = $store_detail->store_contact;
					$store["store_lat"] = $store_detail->location_lat;
					$store["store_long"] = $store_detail->location_long;
					$this_ad["store_detail"] = $store;
					$this_ad["campaign_name"] = $campaign_detail->campaign_name;
					$location = [];
					foreach ($location_detail as $l_key => $l_value) {
						$location_this = [];
						$location_this["location_id"] = $l_value["location_id"];
						$location_this["location_lat"] = $l_value["location_lat"];
						$location_this["location_long"] = $l_value["location_long"];
						$location_this["location_address"] = $l_value["location_state"];
						$location_this["location_contact"] = $l_value["contact"];
						$location_this["location_email"] = $l_value["email"];
						$location_this["location_landmark"] = $l_value["landmark"];

						$ad_state = strtolower($l_value["location_state"]);
						if(strpos($ad_state, strtolower($location_state)) !== false) {
							array_push($location, $location_this);
							$take_this_ad = TRUE;
						}
					}
					$this_ad["location"] = $location;
					$quiz = [];
					$quiz_rewards = 0;
					foreach ($quiz_detail as $k_quiz => $v_quiz) {
						$quiz_rewards = $quiz_rewards + $v_quiz["reward_amount"];
						$quiz_this = [];
						$quiz_this["quiz_id"] = $v_quiz["quiz_id"];
						$quiz_this["question"] = $v_quiz["question"];
						$quiz_this["options"] = explode("*,*", $v_quiz["options"]);
						array_push($quiz, $quiz_this);
					}
					$this_ad["quiz_reward"] = $quiz_rewards;
					$this_ad["quiz"] = $quiz;
					if($take_this_ad) {
						array_push($all_ads, $this_ad);
					}
				}
			}

			if(empty($all_ads)) {
				return NO_ADS_FOUND_NEAR_YOU;
			} else {
				return $all_ads;
			}
		} else {
			return NO_ADS_FOUND;
		}
	}

	public function getAdsForLocation($get_ads_struct) {
		$CommonFunc = new CommonFunctions();
		$ads = $CommonFunc->getAllPublishedAds();
		if(is_array($ads)) {
			$all_ads = [];
			foreach ($ads as $key => $ad) {

				$start_date = $ad["start_date"];
				$end_date = $ad["end_date"];
				$exclusion_days = explode(",", $ad["exclusion_days"]);

				if($this->checkAdValidForToday($start_date, $end_date, $exclusion_days)) {
					$take_this_ad = FALSE;
					$this_ad = [];
					$store_detail = $CommonFunc->getStoreDetail($ad["associated_store"]);
					
					$campaign_detail = $CommonFunc->getCampaignDetail($ad["campaign_id"]);
					$location_detail = $CommonFunc->getLocationForAds($ad["ad_id"], $ad["location_count"]);
					$quiz_detail = $CommonFunc->getQuizForAds($ad["ad_id"], $ad["quiz_count"]);
					$this_ad["ad_id"] = $ad["ad_id"];
					$this_ad["ad_name"] = $ad["ad_name"];
					if (filter_var($ad["ads_banner"], FILTER_VALIDATE_URL)) { 
						$this_ad["ad_banner"] = $ad["ads_banner"];
					} else {
						$this_ad["ad_banner"] = AD_IMAGE_URL.$ad["ads_banner"];
					}

					$this_ad["product_name"] = $ad["product_name"];
					$this_ad["product_url"] = $ad["product_url"];
					$this_ad["company_name"] = $ad["company_name"];
					$this_ad["company_url"] = $ad["company_url"];
					if (filter_var($ad["company_logo"], FILTER_VALIDATE_URL)) { 
						$this_ad["company_logo"] = $ad["company_logo"];
					} else {
						$this_ad["company_logo"] = COMPANY_IMAGE_URL.$ad["company_logo"];
					}
					$this_ad["ad_coverage"] = $ad["coverage_radius"];
					$this_ad["check_in_reward"] = $ad["reward_amount"];
					$this_ad["off_deal"] = $ad["off_deal"];
					$this_ad["coupon_code"] = $ad["coupon_code"];
					$this_ad["deal_link"] = $ad["deal_link"];
					$store = [];
					$store["store_id"] = $store_detail->store_id;
					$store["store_name"] = $store_detail->store_name;
					$store["store_photo_url"] = $store_detail->store_image;
					$store["store_area"] = $store_detail->store_address;
					$store["store_city"] = $store_detail->store_city;
					$store["store_pincode"] = $store_detail->store_pincode;
					$store["store_website"] = $store_detail->store_website;
					$store["store_contact"] = $store_detail->store_contact;
					$store["store_lat"] = $store_detail->location_lat;
					$store["store_long"] = $store_detail->location_long;
					$this_ad["store_detail"] = $store;
					$this_ad["campaign_name"] = $campaign_detail->campaign_name;
					$location = [];
					foreach ($location_detail as $l_key => $l_value) {
						$location_this = [];
						$location_this["location_id"] = $l_value["location_id"];
						$location_this["location_lat"] = $l_value["location_lat"];
						$location_this["location_long"] = $l_value["location_long"];
						$location_this["location_address"] = $l_value["location_state"];
						$location_this["location_contact"] = $l_value["contact"];
						$location_this["location_email"] = $l_value["email"];
						$location_this["location_landmark"] = $l_value["landmark"];
						if(floatval($l_value["location_lat"]) > $get_ads_struct->location_lat_1 && floatval($l_value["location_lat"]) < $get_ads_struct->location_lat_2) {
							
							if(floatval($l_value["location_long"]) > $get_ads_struct->location_long_1 && floatval($l_value["location_long"]) < $get_ads_struct->location_long_2) {
								array_push($location, $location_this);
								$take_this_ad = TRUE;
							}
						}
					}

					$this_ad["location"] = $location;
					$quiz = [];
					$quiz_rewards = 0;
					foreach ($quiz_detail as $k_quiz => $v_quiz) {
						$quiz_rewards = $quiz_rewards + $v_quiz["reward_amount"];
						$quiz_this = [];
						$quiz_this["quiz_id"] = $v_quiz["quiz_id"];
						$quiz_this["question"] = $v_quiz["question"];
						$quiz_this["options"] = explode("*,*", $v_quiz["options"]);
						array_push($quiz, $quiz_this);
					}
					$this_ad["quiz_reward"] = $quiz_rewards;
					$this_ad["quiz"] = $quiz;
					if($take_this_ad) {
						array_push($all_ads, $this_ad);
					}
				}		
			}
			if(empty($all_ads)) {
				return NO_ADS_FOUND_NEAR_YOU;
			} else {
				return $all_ads;
			}
		} else {
			return NO_ADS_FOUND;
		}
	}

	public function getAdsForStoreId($store_id) {
		$CommonFunc = new CommonFunctions();
		$ads = $CommonFunc->getAllAdsForStore($store_id);
		if(is_array($ads)) {
			$all_ads = [];
			foreach ($ads as $key => $ad) {
				$this_ad = [];
				$store_detail = $CommonFunc->getStoreDetail($ad["associated_store"]);
				$campaign_detail = $CommonFunc->getCampaignDetail($ad["campaign_id"]);
				$location_detail = $CommonFunc->getLocationForAds($ad["ad_id"], $ad["location_count"]);
				$quiz_detail = $CommonFunc->getQuizForAds($ad["ad_id"], $ad["quiz_count"]);
				$this_ad["ad_id"] = $ad["ad_id"];
				$this_ad["ad_name"] = $ad["ad_name"];
				$this_ad["ad_banner"] = $ad["ads_banner"];
				$this_ad["product_name"] = $ad["product_name"];
				$this_ad["product_url"] = $ad["product_url"];
				$this_ad["company_name"] = $ad["company_name"];
				$this_ad["company_url"] = $ad["company_url"];
				$this_ad["company_logo"] = $ad["company_logo"];
				$this_ad["ad_coverage"] = $ad["coverage_radius"];
				$this_ad["check_in_reward"] = $ad["reward_amount"];
				$this_ad["off_deal"] = $ad["off_deal"];
				$this_ad["coupon_code"] = $ad["coupon_code"];
				$this_ad["deal_link"] = $ad["deal_link"];
				$this_ad["publish"] = $ad["publish"];
				$store = [];
				$store["store_id"] = $store_detail->store_id;
				$store["store_name"] = $store_detail->store_name;
				$store["store_photo_url"] = $store_detail->store_image;
				$store["store_area"] = $store_detail->store_address;
				$store["store_city"] = $store_detail->store_city;
				$store["store_pincode"] = $store_detail->store_pincode;
				$store["store_website"] = $store_detail->store_website;
				$store["store_contact"] = $store_detail->store_contact;
				$store["store_lat"] = $store_detail->location_lat;
				$store["store_long"] = $store_detail->location_long;
				$this_ad["store_detail"] = $store;
				if(is_object($campaign_detail)) {
					$this_ad["campaign_name"] = $campaign_detail->campaign_name;
				} else {
					$this_ad["campaign_name"] = "";
				}
				
				$location = [];
				foreach ($location_detail as $l_key => $l_value) {
					$location_this = [];
					$location_this["location_id"] = $l_value["location_id"];
					$location_this["location_lat"] = $l_value["location_lat"];
					$location_this["location_long"] = $l_value["location_long"];
					array_push($location, $location_this);
				}
				$this_ad["location"] = $location;
				$quiz = [];
				$quiz_rewards = 0;
				foreach ($quiz_detail as $k_quiz => $v_quiz) {
					$quiz_rewards = $quiz_rewards + $v_quiz["reward_amount"];
					$quiz_this = [];
					$quiz_this["quiz_id"] = $v_quiz["quiz_id"];
					$quiz_this["question"] = $v_quiz["question"];
					$quiz_this["options"] = explode("*,*", $v_quiz["options"]);
					array_push($quiz, $quiz_this);
				}
				$this_ad["quiz_reward"] = $quiz_rewards;
				$this_ad["quiz"] = $quiz;
				array_push($all_ads, $this_ad);
			}
			if(empty($all_ads)) {
				return NO_ADS_FOUND_NEAR_YOU;
			} else {
				return $all_ads;
			}
		} else {
			return NO_ADS_FOUND;
		}
	}

	public function storeLocatedByUser($ad_id, $user_contact) {
		$CommonFunc = new CommonFunctions();
		$user_detail = $CommonFunc->getUserDetailFromContact($user_contact);
		if(is_object($user_detail)) {
			$user_id = $user_detail->user_id;
			$wallat_amount = $user_detail->wallet_amount;
			/*get ads detail*/
			/* check if that ad is already located by that user or not */
			if(!$CommonFunc->getTransaction($user_id, $ad_id, "SUCCESS")) {
				$ad_detail = $CommonFunc->getAdDetail($ad_id);
				if(is_object($ad_detail)) {
					$reward = $ad_detail->reward_amount;
					$activity = $CommonFunc->addUserActivity($user_id, $ad_id, "Ad Located", "", "", $reward);
					if($activity != -1) {
						$response["display_message"] = "Your Activity Saved Successfully";
						$response["credit_amount"] = $reward;
						$response["wallet_amount"] = $reward+$wallet_amount;
						return $response;
					} else {
						return SERVER_ERROR;
					}
				} else {
					return NO_ADS_FOUND;
				}
			} else {
				return ALREADY_CHECKEDIN;
			}
		} else {
			return USER_NOT_FOUND;
		}
	}
	
	
	public function questionAnswered($user_contact, $quiz_answered, $ip_address) {
		$CommonFunc = new CommonFunctions();
		$total_correct = 0;
		$total_wrong = 0;
		$response = [];
		$wallet_amount = 0;
		$total_reward = 0;
		$user_detail = $CommonFunc->getUserDetailFromContact($user_contact);
		if(is_object($user_detail)) {
			$user_id = $user_detail->user_id;
			$wallet_amount = $user_detail->wallet_amount;
			
			$answered = json_decode($quiz_answered);
			
			/*get ads detail*/
			if (sizeof($answered) > 0) {
				/* check if this ads is already answered */
				$check_quiz = $CommonFunc->getQuizDetail($answered[0]->quiz_id);
				$check_ad_id = $check_quiz->ad_id;

				/* enter only if quiz is not answered */
				if(!$CommonFunc->getTransaction($user_id, $check_ad_id, "SUCCESS")) {
					
					$ad_detail = $CommonFunc->getAdDetail($check_ad_id);
					$store_id = $ad_detail->associated_store;
					$total_reward = $ad_detail->reward_amount;
					$store_detail = $CommonFunc->getStoreDetail($store_id);

					$sales_wallet_guid = $store_detail->wallet_guid;
					// $sales_wallet_guid = "d00b23ef-aabb-4d9a-ba62-6c56806d77ac";
					foreach ($answered as $key => $value) {
						$quiz_id = $value->quiz_id;
						$answer_counter = $value->answer;

						$quiz_detail = $CommonFunc->getQuizDetail($quiz_id);
						if(is_object($quiz_detail)) {
							$reward = $quiz_detail->reward_amount;
							$correct_answer = $quiz_detail->answer;
							$ad_id = $quiz_detail->ad_id;
							/* check if the answer is correct */
							if($correct_answer == $answer_counter) {
								$activity = $CommonFunc->addUserActivity($user_id, $ad_id, "Quiz Answered", $quiz_id, $answer_counter, 0);
								if($activity != -1) {
									$wallet_amount = $reward+$wallet_amount;
									$total_correct = $total_correct + 1;
									$total_reward = $total_reward + $reward;
								}
							} else {
								$total_wrong = $total_wrong + 1;
							}
						}
					}
					
					$order_id = date("ymd")."-".$user_id."-".$store_id."-".$check_ad_id."-".$this->generateRandomString();
					$paytm_transfer = new Paytm();
					$payment_status = $paytm_transfer->transferAmountToPaytm($order_id, $ip_address, $user_contact, $sales_wallet_guid, $total_reward);
					/* update transaction table with the following values.
					*/
					if($payment_status["status"] == "SUCCESS") {
						$update_wallet = $CommonFunc->updateUserWallet($user_id, $total_reward);
						$CommonFunc->insertTransaction($user_id, $check_ad_id, $store_id, "paytm", $payment_status["status"], $payment_status["status_message"], $total_reward, $order_id, $payment_status["transaction_id"]);
						$response["display_message"] = "Your Activity Saved Successfully.";
						$response["credit_amount"] = $total_reward;
						$response["wallet_amount"] = $wallet_amount;
						$response["correct_answer"] = $total_correct;
						$response["wrong_answer"] = $total_wrong;
					} else {
						$update_wallet = $CommonFunc->updateUserWallet($user_id, $total_reward);
						$CommonFunc->insertTransaction($user_id, $check_ad_id, $store_id, "paytm", $payment_status["status"], $payment_status["status_message"], $total_reward, $order_id, $payment_status["transaction_id"]);
						$response["display_message"] = "Your Activity Saved Successfully. Amount will be transfer to your paytm account shortly.";
						$response["credit_amount"] = $total_reward;
						$response["wallet_amount"] = $wallet_amount;
						$response["correct_answer"] = $total_correct;
						$response["wrong_answer"] = $total_wrong;
					}
					return $response;
				} else {
					return USER_ALREADY_ENGAGED;
				}
			} else {
				return PLEASE_SEND_VALUES;
			}
		} else {
			return USER_NOT_FOUND;
		}
	}

	public function generateRandomString($length = 3) {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function getTimeline($user_contact) {
		$CommonFunc = new CommonFunctions();
		$user_detail = $CommonFunc->getUserDetailFromContact($user_contact);
		if(is_object($user_detail)) {
			$response = [];
			$user_id = $user_detail->user_id;
			$timeline = $CommonFunc->getTimeline($user_id);
			if(is_array($timeline)) {
				$all_timeLine = [];
				foreach ($timeline as $key => $value) {
					$this_time = [];
					$this_time["activity_type"] = $value["activity_type"];
					$ad_detail = $CommonFunc->getAdDetail($value["ad_id"]);
					$store_detail = $CommonFunc->getStoreDetail($ad_detail->associated_store);
					$campaign_detail = $CommonFunc->getCampaignDetail($ad_detail->campaign_id);
					$this_time["ad_id"] = $ad_detail->ad_id;
					$this_time["ad_name"] = $ad_detail->ad_name;
					$this_time["ad_banner"] = $ad_detail->ads_banner;
					$this_time["product_name"] = $ad_detail->product_name;
					$this_time["product_url"] = $ad_detail->product_url;
					$this_time["company_name"] = $ad_detail->company_name;
					$this_time["company_url"] = $ad_detail->company_url;
					$this_time["company_logo"] = $ad_detail->company_logo;
					$this_time["ad_coverage"] = $ad_detail->coverage_radius;
					$this_time["check_in_reward"] = $ad_detail->reward_amount;
					$this_time["reward_gain"] = $value["reward_amount"];
					$this_time["off_deal"] = $ad_detail->off_deal;
					$this_time["coupon_code"] = $ad_detail->coupon_code;
					$this_time["deal_link"] = $ad_detail->deal_link;
					$store = [];
					$store["store_id"] = $store_detail->store_id;
					$store["store_name"] = $store_detail->store_name;
					$store["store_photo_url"] = $store_detail->store_image;
					$store["store_area"] = $store_detail->store_address;
					$store["store_city"] = $store_detail->store_city;
					$store["store_pincode"] = $store_detail->store_pincode;
					$store["store_website"] = $store_detail->store_website;
					$store["store_contact"] = $store_detail->store_contact;
					$store["store_lat"] = $store_detail->location_lat;
					$store["store_long"] = $store_detail->location_long;
					$this_time["store_detail"] = $store;
					$this_time["campaign_name"] = $campaign_detail->campaign_name;
					if ($value["activity_type"] != "Ad Located") {
						/* get quiz detail */
						$quiz_detail = $CommonFunc->getQuizDetail($value["quiz_id"]);
						$this_time["question"] = $quiz_detail->question;
						$correct_answer = $quiz_detail->answer;
						$your_answer = intval($value["answer_id"]);
						$options = explode("*,*", $quiz_detail->options);
						foreach ($options as $k_option => $v_option) {
							if($correct_answer == $k_option) {
								$this_time["correct_answer"] = $v_option;
							}
							if($your_answer == $k_option) {
								$this_time["your_answer"] = $v_option;
							}
						}
					}
					$this_time["timestamp"] = date_format(date_modify(date_create($value["timestamp"]), "+330 minutes"), "dS M, Y h:i A");
					array_push($all_timeLine, $this_time);
				}
				$response["display_message"] = TIMELINE_FOUND;
				$response["timeline"] = $all_timeLine;
				return $response;
			} else {
				return NO_TIMELINE_FOUND;
			}
		} else {
			return USER_NOT_FOUND;
		}
	}

	public function getTranscation($user_contact) {
		$CommonFunc = new CommonFunctions();
		$user_detail = $CommonFunc->getUserDetailFromContact($user_contact);
		if(is_object($user_detail)) {
			$response = [];
			$user_id = $user_detail->user_id;
			$timeline = $CommonFunc->getTimeline($user_id);
			if(is_array($timeline)) {
				$all_timeLine = [];
				foreach ($timeline as $key => $value) {
					$this_time = [];
					$this_time["activity_type"] = $value["activity_type"];
					$ad_detail = $CommonFunc->getAdDetail($value["ad_id"]);
					$store_detail = $CommonFunc->getStoreDetail($ad_detail->associated_store);
					$campaign_detail = $CommonFunc->getCampaignDetail($ad_detail->campaign_id);
					$this_time["ad_id"] = $ad_detail->ad_id;
					$this_time["ad_name"] = $ad_detail->ad_name;
					$this_time["ad_banner"] = $ad_detail->ads_banner;
					$this_time["product_name"] = $ad_detail->product_name;
					$this_time["product_url"] = $ad_detail->product_url;
					$this_time["company_name"] = $ad_detail->company_name;
					$this_time["company_url"] = $ad_detail->company_url;
					$this_time["company_logo"] = $ad_detail->company_logo;
					$this_time["ad_coverage"] = $ad_detail->coverage_radius;
					$this_time["check_in_reward"] = $ad_detail->reward_amount;
					$this_time["reward_gain"] = $value["reward_amount"];
					$this_time["off_deal"] = $ad_detail->off_deal;
					$this_time["coupon_code"] = $ad_detail->coupon_code;
					$this_time["deal_link"] = $ad_detail->deal_link;
					$store = [];
					$store["store_id"] = $store_detail->store_id;
					$store["store_name"] = $store_detail->store_name;
					$store["store_photo_url"] = $store_detail->store_image;
					$store["store_area"] = $store_detail->store_address;
					$store["store_city"] = $store_detail->store_city;
					$store["store_pincode"] = $store_detail->store_pincode;
					$store["store_website"] = $store_detail->store_website;
					$store["store_contact"] = $store_detail->store_contact;
					$store["store_lat"] = $store_detail->location_lat;
					$store["store_long"] = $store_detail->location_long;
					$this_time["store_detail"] = $store;
					$this_time["campaign_name"] = $campaign_detail->campaign_name;
					$this_time["transaction_type"] = "Credit";
					$this_time["transaction_amount"] = $value["reward_amount"];
					$this_time["timestamp"] = date_format(date_modify(date_create($value["timestamp"]), "+330 minutes"), "dS M, Y h:i A");
					array_push($all_timeLine, $this_time);
				}
				$response["display_message"] = TIMELINE_FOUND;
				$response["timeline"] = $all_timeLine;
				return $response;
			} else {
				return NO_TIMELINE_FOUND;
			}
		} else {
			return USER_NOT_FOUND;
		}
	}

	public function getUserProfile($user_contact) {
		$CommonFunc = new CommonFunctions();
		$user_detail = $CommonFunc->getUserDetailFromContact($user_contact);
		if(is_object($user_detail)) {
			$code_type = $this->getCodeType();
			$profile = [];
			$profile["user_name"] = $user_detail->user_name;
			$profile["user_email"] = $user_detail->user_email;
			$profile_image = "../mobi/images/profile/".$user_detail->user_contact.".png";
			if(file_exists($profile_image)) {
				$profile["profile_image"] = MAIN_URL."images/profile/".$user_detail->user_contact.".png";
			} else {
				$profile["profile_image"] = "https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg";
			}
			$profile["moby_ad"] = MAIN_URL."images/company/9171017045200.png";
			$profile["user_contact"] = $user_detail->user_contact;
			$profile["user_gender"] = $user_detail->gender;
			$profile["user_address"] = $user_detail->user_address;
			$profile["user_city"] = $user_detail->user_city;
			$profile["user_state"] = $user_detail->user_state;
			$profile["user_pincode"] = $user_detail->user_pincode;
			$profile["user_photo"] = $user_detail->user_photo;
			$profile["user_dob"] = $user_detail->user_dob;
			$profile["user_age"] = date("Y") - date_format(date_create($user_detail->user_dob), "Y");
			$default_code = [];
			$default_code["code_id"] = "";
			$default_code["code_value"] = "Please Select";

			$salary_group = [];
			array_push($salary_group, $default_code);
			foreach ($code_type["salary_group"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->user_salary) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($salary_group, $code);
			}
			$profile["salary_group"] = $salary_group;
			$profile["user_salary"] = $code_type["salary_group"][$user_detail->user_salary];

			$club_membership = [];
			array_push($club_membership, $default_code);
			foreach ($code_type["club_type"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->club_membership) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($club_membership, $code);
			}
			$profile["club_membership"] = $club_membership;

			$defence_service = [];
			array_push($defence_service, $default_code);
			foreach ($code_type["defence_group"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->defence_service) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($defence_service, $code);
			}
			$profile["defence_service"] = $defence_service;

			$work_type = [];
			array_push($work_type, $default_code);
			foreach ($code_type["work_type"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->work_type) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($work_type, $code);
			}
			$profile["work_type"] = $work_type;

			$profile["user_profession"] = $user_detail->user_profession;

			$watch_brand = [];
			array_push($watch_brand, $default_code);
			foreach ($code_type["watch_brand"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->watch_brand) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($watch_brand, $code);
			}
			$profile["watch_brand"] = $watch_brand;

			$car_brand = [];
			array_push($car_brand, $default_code);
			foreach ($code_type["car_brand"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->car_brand) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($car_brand, $code);
			}
			$profile["car_brand"] = $car_brand;

			$residence_type = [];
			array_push($residence_type, $default_code);
			foreach ($code_type["residence_type"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->residence_type) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($residence_type, $code);
			}
			$profile["residence_type"] = $residence_type;

			$profile["locality"] = $user_detail->locality;

			$transport_type = [];
			array_push($transport_type, $default_code);
			foreach ($code_type["transport_type"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->transport_type) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($transport_type, $code);
			}
			$profile["transport_type"] = $transport_type;

			$miles_card = [];
			array_push($miles_card, $default_code);
			foreach ($code_type["miles_card"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->miles_card) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($miles_card, $code);
			}
			$profile["miles_card"] = $miles_card;

			$credit_card = [];
			array_push($credit_card, $default_code);
			foreach ($code_type["credit_card"] as $key => $value) {
				$code = [];
				$code["code_id"] = $key;
				$code["code_value"] = $value;
				if($key == $user_detail->credit_card) {
					$code["seleted"] = TRUE;
				} else {
					$code["seleted"] = FALSE;
				}
				array_push($credit_card, $code);
			}
			$profile["credit_card"] = $credit_card;


			$profile["fb_link"] = $user_detail->fb_link;
			$profile["twitter_link"] = $user_detail->twitter_link;
			$profile["gplus_link"] = $user_detail->gplus_link;

			$profile["wallet_amount"] = $user_detail->wallet_amount;
			$profile["checkin"] = $CommonFunc->getCheckinStatForUser($user_detail->user_id);
			$profile["quiz_answered"] = $CommonFunc->getAnsweredQuizStat($user_detail->user_id);
			return $profile;
		} else {
			return USER_NOT_FOUND;
		}
	}

	public function updateUserProfile($login_struct) {
		if($login_struct->user_contact != "") {
			$CommonFunc = new CommonFunctions();
			if($login_struct->user_dob == "" || $login_struct->user_dob == NULL) {
				$user_detail = $CommonFunc->getUserDetailFromContact($login_struct->user_contact);
				$login_struct->user_dob = $user_detail->user_dob;
			}
			if($login_detail->user_profile_image != "" || $login_struct->user_profile_image != NULL) {
				$this->storeUserProfileImage($login_detail->user_profile_image, $login_struct->user_contact.".png");
			}
			$update = $CommonFunc->updateUser($login_struct);
			$response = [];
			if($update) {
				$response["display_message"] = PROFILE_UPDATED_SUCCESS;
				return $response;
			} else {
				return SERVER_ERROR;
			}
		} else {
			return PARAMTER_MISSING;
		}
	}
	
	public function addLocationToAd($ad_id, $latitude, $longitude, $location_state) {
		$counter = 0;
		$CommonFunc = new CommonFunctions();
		foreach ($latitude as $key => $value) {
			if($value != "" && $location_state[$key] != "") {
				if($CommonFunc->addNewLocationToAd($ad_id, $value, $longitude[$key], $location_state[$key]) != -1) {
					$counter = $counter +1;
					$this_location = [];
					$this_location["lat"] = $value;
					$this_location["long"] = $longitude[$key];
					$this_location["state"] = $location_state[$key];
					array_push($_SESSION["ad_struct"]->locations, $this_location);
				}
			}
		}
		/* update location count in ad*/
		$CommonFunc->updateLocationCountAd($ad_id, $counter);
		return $counter;
	}

	public function updateLocationToAd($ad_id, $latitude, $longitude, $location_state) {
		$counter = 0;
		$CommonFunc = new CommonFunctions();
		// delete prevous locations first
		$CommonFunc->deleteOldLocationForAd($ad_id);
		$_SESSION["ad_struct"]->locations = array();
		foreach ($latitude as $key => $value) {
			if($value != "" && $location_state[$key] != "") {
				if($CommonFunc->addNewLocationToAd($ad_id, $value, $longitude[$key], $location_state[$key]) != -1) {
					$counter = $counter +1;
					$this_location = [];
					$this_location["lat"] = $value;
					$this_location["long"] = $longitude[$key];
					$this_location["state"] = $location_state[$key];
					array_push($_SESSION["ad_struct"]->locations, $this_location);
					
				}
			}
		}
		/* update location count in ad*/
		$CommonFunc->updateLocationCountAd($ad_id, $counter);
		return $counter;
	}

	public function AddNewLocationToAd($ad_id, $lat, $long, $location_state, $landmark, $email, $contact){
		$CommonFunc = new CommonFunctions();
		if($CommonFunc->addNewLocationToAd($ad_id, $lat, $long, $location_state, $landmark, $email, $contact) != -1) {
			$this->message_list[] = "Location Saved.";
		}
		$CommonFunc->increaseLocationCount($ad_id);
	}

	public function addQuestionToAd($ad_id) {
		$questions = $_POST["question"];
		$counter = 0;
		foreach ($questions as $key => $question) {
			
			$count = $key + 1;
			$price_post = "price".$count;
			$option_post = "option".$count;
			$answer_post = "radio".$count;
			$options = $_POST[$option_post][0]."*,*".$_POST[$option_post][1]."*,*".$_POST[$option_post][2]."*,*".$_POST[$option_post][3];
			$answer = $_POST[$answer_post];
			$price = $_POST[$price_post];
			$CommonFunc = new CommonFunctions();
			if($CommonFunc->addQuestionToAd($ad_id, $question, $options, $answer, $price) != -1) {
				$counter = $counter +1;
				$this_question = [];
				$this_question["question"] = $question;
				$this_question["options"] = $options;
				$this_question["answer"] = $answer;
				array_push($_SESSION["ad_struct"]->questions, $this_question);
			}
		}
		/*update question count to the ad*/
		$CommonFunc->updateQuestionCountAd($ad_id, $counter);
		return $counter;
	}

	public function updateQuestionToAd($ad_id) {
		$questions = $_POST["question"];
		$counter = 0;
		$CommonFunc = new CommonFunctions();
		$CommonFunc->removePreviousQuestions($ad_id);
		$_SESSION["ad_struct"]->questions = array();
		foreach ($questions as $key => $question) {
			
			$count = $key + 1;
			$price_post = "price".$count;
			$option_post = "option".$count;
			$answer_post = "radio".$count;
			$options = $_POST[$option_post][0]."*,*".$_POST[$option_post][1]."*,*".$_POST[$option_post][2]."*,*".$_POST[$option_post][3];
			$answer = $_POST[$answer_post];
			$price = $_POST[$price_post];
			
			if($CommonFunc->addQuestionToAd($ad_id, $question, $options, $answer, $price) != -1) {
				$counter = $counter +1;
				$this_question = [];
				$this_question["question"] = $question;
				$this_question["options"] = $options;
				$this_question["answer"] = $answer;
				array_push($_SESSION["ad_struct"]->questions, $this_question);
			}
		}
		/*update question count to the ad*/
		$CommonFunc->updateQuestionCountAd($ad_id, $counter);
		return $counter;
	}

	public function createAd($ad_struct) {
		$upload_success = FALSE;
		$banner_image = $ad_struct->ads_banner_image;
		$logo_image = $ad_struct->company_logo_image;
		if(!is_null($banner_image["tmp_name"]) && $banner_image["size"] < 200000 ) {
			$banner_name = $ad_struct->campaign_id.date("ymdhis").".png";
			if($this->storeAdsImage($banner_image["tmp_name"], $banner_name)) {
				$ad_struct->ads_banner = $banner_name;
				$upload_success = TRUE;
			}
		} else {
			$this->error_list[] = "Banner image should be smaller than 200 KB".
			$upload_success = FALSE;
		}
		
		if(!is_null($logo_image["tmp_name"]) && $logo_image["size"] < 200000) {
			$logo_name = $ad_struct->campaign_id.date("ymdhis").".png";
			if($this->storeCompanyImage($logo_image["tmp_name"], $logo_name)) {
				$ad_struct->company_logo = $logo_name;
				$upload_success = TRUE;
			}
		} else {
			$this->error_list[] = "Logo image should be smaller than 200 KB".
			$upload_success = FALSE;
		}

		if($upload_success) {
			$CommonFunc = new CommonFunctions();
			return $CommonFunc->createAd($ad_struct);
		} else {
			return -1;
		}
	}

	public function updateAd($ad_struct) {
		$upload_success = FALSE;
		$banner_image = $ad_struct->ads_banner_image;
		$logo_image = $ad_struct->company_logo_image;
		if(!is_null($banner_image["tmp_name"]) && $banner_image["size"] < 200000 ) {
			$banner_name = $ad_struct->campaign_id.date("ymdhis").".png";
			if($this->storeAdsImage($banner_image["tmp_name"], $banner_name)) {
				$ad_struct->ads_banner = $banner_name;
				$upload_success = TRUE;
			}
		} else {
			$this->error_list[] = "Banner image should be smaller than 200 KB".
			$upload_success = FALSE;
		}
		
		if(!is_null($logo_image["tmp_name"]) && $logo_image["size"] < 200000) {
			$logo_name = $ad_struct->campaign_id.date("ymdhis").".png";
			if($this->storeCompanyImage($logo_image["tmp_name"], $logo_name)) {
				$ad_struct->company_logo = $logo_name;
				$upload_success = TRUE;
			}
		} else {
			$this->error_list[] = "Logo image should be smaller than 200 KB".
			$upload_success = FALSE;
		}

		if($upload_success) {
			$CommonFunc = new CommonFunctions();
			return $CommonFunc->updateAd($ad_struct);
		} else {
			return -1;
		}
	}

	public function publishAd($ad_id) {
		if($ad_id != "") {
			$CommonFunc = new CommonFunctions();
			if($CommonFunc->publishAd($ad_id)) {
				$this->message_list[] = YOUR_AD_PUBLISHED;
			} else {
				$this->error_list[] = SERVER_ERROR; 
			}
		} else {
			$this->error_list[] = ADIS_NOT_FOUND;
		}
	}

	public function draftAd($ad_id) {
		$message_list[] = AD_SAVED_IN_DRAFT;
	}

	//ad information update
	public function updateAnAdInformation($ad_struct, $ad_id) {
		$CommonFunc = new CommonFunctions();
		$update_ad = $CommonFunc->updateAnAd($ad_struct, $ad_id);
		if($update_ad) {
			$this->message_list[] = AD_UPDATED_SUCCESS;
		} else {
			$this->error_list[] = SERVER_ERROR;
		}
	}

	//location updated when delete old location
	public function deleteLocationForAd($ad_id, $location_id) {
	
		$CommonFunc = new CommonFunctions();
		$delete_lat_long = $CommonFunc->deleteLatLong($location_id);
		//echo $delete_lat_long;
		if($delete_lat_long) {
			$ad_detail = $CommonFunc->getAdDetail($ad_id);
			$location_counting = $ad_detail->location_count;
			$now_total_location = $location_counting-$delete_lat_long;
			$CommonFunc->updateLocationCountAfterDeleteLocation($ad_id, $now_total_location);
			$this->message_list[] = DELETE_SUCCESS;
		} else {
			$this->error_list[] = SERVER_ERROR;
		}
	}

	public function updateQuiz($quiz_id) {
		$questions = $_POST["question"];
		$counter = 0;
		foreach ($questions as $key => $question) {
			$question;
			$count = $key + 1;
			$price_post = "price".$count;
			$option_post = "option".$count;
			$answer_post = "radio".$count;
			$options = $_POST[$option_post][0]."*,*".$_POST[$option_post][1]."*,*".$_POST[$option_post][2]."*,*".$_POST[$option_post][3];
			$answer = $_POST[$answer_post];
			$price = $_POST[$price_post];
			$CommonFunc = new CommonFunctions();
			$quiz_uodate = $CommonFunc->updateQuiz($quiz_id[$key], $question, $options, $answer, $price);
			if ($quiz_uodate) {
				$this->message_list[] = AD_UPDATED_SUCCESS;
			}	
		}
	}


	public function getTargetedAudience($audience_search) {
		// echo $min_age.".".$max_age.".".$gender."<br>";
		$min_age = $audience_search["min_age"];
		$max_age = $audience_search["max_age"];
		$gender = $audience_search["gender"];
		$club_membership = $audience_search["club_membership"];
		$salary_group = $audience_search["salary_group"];
		$defence_service = $audience_search["defence_service"];
		$work_type = $audience_search["work_type"];
		$watch_brand = $audience_search["watch_brand"];
		$car_brand = $audience_search["car_brand"];
		$residence_type = $audience_search["residence_type"];
		$transport_type = $audience_search["transport_type"];
		$miles_card = $audience_search["miles_card"];
		$credit_card = $audience_search["credit_card"];

		$CommonFunc = new CommonFunctions();
		$users;
		$total_user = 0;
		$user_count = $CommonFunc->getAllusers();
		if($gender != "all") {
			$users = $CommonFunc->getUsersOfOneGender($gender);
		} else {
			$users = $user_count;
		}
		$total_user = sizeof($user_count);
		
		$targeted_audience = 0;
		if(is_array($users)) {
			foreach ($users as $key => $value) {
				$dob = $value["user_dob"];
				$age = intval(date("Y") + 1 - date_format(date_create($dob), "Y"));
				

				if(($min_age < $age && $age < $max_age) ) {
					if($value["user_salary"] == $salary_group || $salary_group == "") {
						if($value["club_membership"] == $club_membership || $club_membership == "") {
							if($value["defence_service"] == $defence_service || $defence_service == "") {
								if($value["work_type"] == $work_type || $work_type == "") {
									if($value["watch_brand"] == $watch_brand || $watch_brand == "") {
										if($value["car_brand"] == $car_brand || $car_brand == "") {
											if($value["residence_type"] == $residence_type || $residence_type == "") {
												if($value["transport_type"] == $transport_type || $transport_type == "") {
													if($value["miles_card"] == $miles_card || $miles_card == "") {
														if($value["credit_card"] == $credit_card || $credit_card == "") {
															$targeted_audience = $targeted_audience + 1;
														}
													}
												}
											}
										}
									}
								}
							}	
						}	
					}
				}
			}
			$response = [];
			$response["all_audience"] = $total_user;
			$response["targeted_audience"] = $targeted_audience;
			$response["audience_left_behind"] = $total_user - $targeted_audience;
			return $response;
		} else {
			return $users;
		}
	}

	// Function to get the client IP address
	public function getClientIp() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	
	/* CREATE STORE
	* - create store login
	* - save store information
	* - save the store image
	*/
	public function createStore($store_struct) {
		/* create a user*/
		$CommonFunc = new CommonFunctions();
		$user_id = $CommonFunc->createStoreUser($store_struct->user_email, $store_struct->owner_contact, md5($store_struct->user_password), $store_struct->store_name, "store");
		$store_struct->owner_id = $user_id;
		if($user_id != -1) {
			$store_id = $CommonFunc->createStore($store_struct);
			if($store_id != -1) {
				$store_image = $store_struct->store_image;
				if(!is_null($store_image["tmp_name"])) {
					$image_name = $store_id.".png";
					$this->storeStoreImage($store_image["tmp_name"], $image_name);
				}
				$user_image = $store_struct->user_photo;
				if(!is_null($user_image["tmp_name"])) {
					$user_image_name = $user_id.".png";
					$this->storeProfileImage($user_image["tmp_name"], $user_image_name);
				}
				$this->message_list[] = STORE_CREATE_SUCCESSFULLY;
			} else {
				$this->error_list[] = UNABLE_TO_SAVE_STORE;
			}
		} else {
			$this->error_list[] = "user not creates";
		}
	}

	/* Change Password of a Store Login
	*/
	public function changePassword($user_id, $password) {
		$CommonFunc = new CommonFunctions();
		$new_password_hash = md5($password);
		if($CommonFunc->updatePassword($user_id, $new_password_hash)) {
			$this->message_list[] = PASSWORD_CHANGED_SUCCESSFULLY;
		} else {
			$this->error_list[] = STORE_ERROR_UPDATE;
		}
	}

	/* When store is updated by the admin
	*/
	public function updateStore($store_struct) {
		$CommonFunc = new CommonFunctions();
		if($CommonFunc->updateStoreDetail($store_struct)) {
			$this->message_list[] = STORE_UPDATED_SUCCESSFULLY;	
		} else {
			$this->error_list[] = STORE_ERROR_UPDATE;
		}
	}

	/* When store is updated by the store user
	*/
	public function updateStoreProfile($store_struct) {
		$CommonFunc = new CommonFunctions();
		if($CommonFunc->updateStoreProfile($store_struct)) {
			$this->message_list[] = STORE_UPDATED_SUCCESSFULLY;	
		} else {
			$this->error_list[] = STORE_ERROR_UPDATE;
		}
	}

	public function getCodeType() {
		$CommonFunc = new CommonFunctions();
		$codes = $CommonFunc->getCodeType();
		$code_details = [];
		foreach ($codes as $key => $code) {
			$code_details[$code["code_type"]][$code["code_id"]] = $code["code_label"];
		}
		return $code_details;
	}

	public function insertCodeSetting($code_type, $code_label) {
		$CommonFunc = new CommonFunctions();
		$code_status = $CommonFunc->insertCodeSetting($code_type, $code_label, $code_label);
		if($code_status) {
			$this->message_list[] = "Setting saved successfully";
		} else {
			$this->error_list[] = SERVER_ERROR;
		}
	}

	public function getMessagesForUser($user_contact) {
		$CommonFunc = new CommonFunctions();
		$message = $CommonFunc->getMessages();
		$user_detail = $CommonFunc->getUserDetailFromContact($user_contact);
		
		if(is_array($message)) {
			$update_last_seen = NULL;
			$message_content = [];
			$last_seen = $user_detail->last_seen_message;
			$user_id = $user_detail->user_id;
			foreach ($message as $key => $value) {
				$this_message = [];
				$this_message["title"] = $value["message_title"];
				$this_message["content"] = $value["message_content"];
				$date = date_format(date_create($value["updated_timestamp"]), "Y-m-d");
				if($date == date("Y-m-d")) {
					$this_message["datetime"] = date_format(date_create($value["updated_timestamp"]), "g:i A");
				} else {
					$this_message["datetime"] = date_format(date_create($value["updated_timestamp"]), "M d");
				}

				if($last_seen < $value["message_id"]) {
					$this_message["message_seen"] = FALSE;
					if(is_null($update_last_seen)) {
						$update_last_seen = $value["message_id"];
					}
				} else {
					$this_message["message_seen"] = TRUE; 
				}

				array_push($message_content, $this_message);
			}
			if(!is_null($update_last_seen)) {
				$CommonFunc->updateMessageSeen($user_id, $update_last_seen);
			}
			return $message_content;
		} else {
			return $message;
		}
	}

	public function createMessage($message_struct) {
		// print_r($message_struct);
		if($message_struct->message_title != "" && $message_struct->message_content != "") {
			$CommonFunc = new CommonFunctions();
			$message = $CommonFunc->createMessage($message_struct);
			if($message) {
				$this->message_list[] = MESSAGE_CREATED;
			} else {
				$this->error_list[] = SERVER_ERROR;
			}
		} else {
			$this->error_list[] = PARAMTER_MISSING;
		}
	}

	public function getStatusForUser($user_contact) {
		$CommonFunc = new CommonFunctions();
		$message = $CommonFunc->getMessages();
		$user_detail = $CommonFunc->getUserDetailFromContact($user_contact);

		if (is_object($user_detail)) {
			$response = [];
			$response["wallet_amount"] = $user_detail->wallet_amount;
			$response["profile_percentage"] = $this->getProfilePercentage($user_detail);
			$response["new_message"] = $this->getUnseenMessage($user_detail->last_seen_message);
			return $response;
		} else {
			return USER_NOT_FOUND;
		}	
	}

	public function getProfilePercentage($user_detail) {
		$profile_complete = 0;
		$total_profile = 0;
		foreach ($user_detail as $key => $value) {
			if($key != "user_id" && $key !="version_id" && $key != "user_type" && $key != "last_seen_message" && $key != "timestamp" && $key != "user_password" && $key != "login_using" && $key != "fb_link" && $key != "twitter_link" && $key != "gplus_link") {
				$total_profile = $total_profile + 1;
				if($key == "user_name" || $key == "user_email" || $key == "user_contact" || $key == "user_gender" || $key == "user_address" || $key == "user_location" || $key == "user_city" || $key == "user_state" || $key == "user_profession") {
					if($value != "") {
						$profile_complete = $profile_complete + 1;
					}
				} elseif ($key == "user_pincode") {
					if($value != "") {
						$profile_complete = $profile_complete + 1;
					}
				} elseif ($key == "user_dob") {
					if($value != "0000-00-00") {
						$profile_complete = $profile_complete + 1;
					}
				} else {
					if($value != NULL || $value != "") {
						$profile_complete = $profile_complete + 1;
					}
				}
			}
		}
		$percentage = ($profile_complete/$total_profile)*100;
		return round($percentage);
	}

	public function getUnseenMessage($last_seen_message) {
		$CommonFunc = new CommonFunctions();
		$last_message = $CommonFunc->getLastMessage();
		if(is_object($last_message)) {
			$last_message_id = $last_message->message_id;
			$total_message_unread = $last_message_id - $last_seen_message;
		}
		if($total_message_unread > 10 ){
			return "10 +";
		} else {
			return $total_message_unread;
		}
	}

	public function getAudience() {
		$CommonFunc = new CommonFunctions();
		$code_type = $this->getCodeType();
		$all_audience = $CommonFunc->getAudience();
		$audience_detail = [];
		foreach ($all_audience as $key => $value) {
			$audience = [];
			$audience["audience_id"] = $value["user_id"];
			$audience["user_name"] = $value["user_name"];
			$audience["user_email"] = $value["user_email"];
			$audience["user_contact"] = $value["user_contact"];
			$audience["user_gender"] = $value["user_gender"];
			$audience["user_address"] = $value["user_address"];
			$audience["user_location"] = $value["user_location"];
			$audience["user_city"] = $value["user_city"];
			$audience["user_state"] = $value["user_state"];
			$audience["user_pincode"] = $value["user_pincode"];
			$audience["user_dob"] = $value["user_dob"];
			if($value["user_salary"] != "" && $value["user_salary"] != NULL && $value["user_salary"] != 0) {
				$audience["user_salary"] = $code_type["salary_group"][$value["user_salary"]];
			} else {
				$audience["user_salary"] = "";
			}
			if($value["club_membership"] != "" && $value["club_membership"] != NULL && $value["club_membership"] != 0) {
				$audience["club_membership"] = $code_type["club_type"][$value["club_membership"]];
			} else {
				$audience["club_membership"] = "";
			}
			if($value["defence_service"] != "" && $value["defence_service"] != NULL && $value["defence_service"] != 0) {
				$audience["defence_service"] = $code_type["defence_group"][$value["defence_service"]];
			} else { $audience["defence_service"] = ""; }
			if($value["work_type"] != "" && $value["work_type"] != NULL && $value["work_type"] != 0) {
				$audience["work_type"] = $code_type["work_type"][$value["work_type"]];
			} else {
				$audience["work_type"] = "";
			}
			$audience["user_profession"] = $value["user_profession"];
			if($value["watch_brand"] != "" && $value["watch_brand"] != NULL && $value["watch_brand"] != 0) {
				$audience["watch_brand"] = $code_type["watch_brand"][$value["watch_brand"]];
			} else {
				$audience["watch_brand"] = "";
			}
			if($value["car_brand"] != "" && $value["car_brand"] != NULL && $value["car_brand"] != 0) {
				$audience["car_brand"] = $code_type["car_brand"][$value["car_brand"]];
			} else {
				$audience["car_brand"] = "";
			}
			if($value["residence_type"] != "" && $value["residence_type"] != NULL && $value["residence_type"] != 0) {
				$audience["residence_type"] = $code_type["residence_type"][$value["residence_type"]];
			} else {
				$audience["residence_type"] = "";
			}
			$audience["locality"] = $value["locality"];
			if($value["transport_type"] != "" && $value["transport_type"] != NULL && $value["transport_type"] != 0) {
				$audience["transport_type"] = $code_type["transport_type"][$value["transport_type"]];
			} else {
				$audience["transport_type"] = "";
			}
			if($value["miles_card"] != "" && $value["miles_card"] != NULL && $value["miles_card"] != 0) {
				$audience["miles_card"] = $code_type["miles_card"][$value["miles_card"]];
			} else {
				$audience["miles_card"] = "";
			}
			if($value["credit_card"] != "" && $value["credit_card"] != NULL && $value["credit_card"] != 0) {
				$audience["credit_card"] = $code_type["credit_card"][$value["credit_card"]];
			} else {
				$audience["credit_card"] = "";
			}
			$audience["wallet_amount"] = $value["wallet_amount"];
			array_push($audience_detail, $audience);
		}
		return $audience_detail;
	}

	public function uploadAudience($all_audience) {
		$updated_users = 0;
		$new_users = 0;
		$CommonFunc = new CommonFunctions();
		$login_struct = new Login_Struct();
		foreach ($all_audience as $key => $audience) {
			if($audience["B"] != "" || $audience["B"] != NULL) {
				$login_struct->user_id = $audience["A"];
				$login_struct->user_name = $audience["B"];
				$login_struct->user_email = $audience["C"];
				$login_struct->user_contact = $audience["D"];
				$login_struct->user_gender = $audience["E"];
				$login_struct->user_address = $audience["F"];
				$login_struct->user_location = $audience["G"];
				$login_struct->user_city = $audience["H"];
				$login_struct->user_state = $audience["I"];
				$login_struct->user_pincode = $audience["J"];
				$login_struct->user_dob = $audience["K"];
				$login_struct->user_salary = $CommonFunc->getCodeId("salary_group", $audience["L"]);
				$login_struct->club_membership = $CommonFunc->getCodeId("club_type", $audience["M"]);
				$login_struct->defence_service = $CommonFunc->getCodeId("defence_group", $audience["N"]);
				$login_struct->work_type = $CommonFunc->getCodeId("work_type", $audience["O"]);
				$login_struct->user_profession = $audience["P"];
				$login_struct->watch_brand = $CommonFunc->getCodeId("watch_brand", $audience["Q"]);
				$login_struct->car_brand = $CommonFunc->getCodeId("car_brand", $audience["R"]);
				$login_struct->residence_type = $CommonFunc->getCodeId("residence_type", $audience["S"]);
				$login_struct->locality = $audience["T"];
				$login_struct->transport_type = $CommonFunc->getCodeId("transport_type", $audience["U"]);
				$login_struct->miles_card = $CommonFunc->getCodeId("miles_card", $audience["V"]);
				$login_struct->credit_card = $CommonFunc->getCodeId("credit_card", $audience["W"]);
				
				if($audience["A"] != "" && $audience["A"] != NULL) {
					/*update this audience*/
					if($CommonFunc->updateUserByUserid($login_struct)){
						$updated_users = $updated_users + 1;
					}
				} else {
					/*create new audience*/
					if($CommonFunc->createNewUploadedUser($login_struct)) {
						$new_users = $new_users + 1;
					}
				}
			}
		}
		if($updated_users>0) {
			$this->message_list[] = "Total users updated:- ". $updated_users;
		}
		if($new_users>0) {
			$this->message_list[] = "New users created:- ".$new_users;
		}
	}

	public function getTransactions($from_date, $to_date) {
		$CommonFunc = new CommonFunctions();
		$all_transaction = $CommonFunc->getTransactionByDate($from_date." 00:00:00", $to_date." 00:00:00");
		$transaction_detail = [];
		foreach ($all_transaction as $key => $transaction) {
			$trans = [];
			$trans["transaction_id"] = $transaction["order_id"];
			if($transaction["transaction_status"] != "SUCCESS") {
				$transaction_details = $transaction["transaction_status"]."<br>Reason:- ".$transaction["failure_reason"];
				$trans["transaction_status"] = $transaction_details;
			} else {
				$trans["transaction_status"] = $transaction["transaction_status"];
			}
			$trans["amount"] = $transaction["reward_amount"];
			if($transaction["store_id"] != "" && $transaction["store_id"] != NULL && $transaction["store_id"] != 0) {
				$store_detail = $CommonFunc->getStoreDetail($transaction["store_id"]);
				$trans["store_name"] = $store_detail->store_name;
			} else {
				$trans["store_name"] = "";
			}
			if($transaction["ad_id"] != "" && $transaction["ad_id"] != NULL && $transaction["ad_id"] != 0) {
				$ad_detail = $CommonFunc->getAdDetail($transaction["ad_id"]);
				$trans["ad_name"] = $ad_detail->ad_name;
				$trans["product_name"] = $ad_detail->product_name;
			} else {
				$trans["ad_name"] = "";
				$trans["product_name"] = "";
			}
			if($transaction["user_id"] != "" && $transaction["user_id"] != NULL && $transaction["user_id"] != 0) {
				$user_detail = $CommonFunc->getUserDetail($transaction["user_id"]);
				$trans["user_name"] = $user_detail->user_name;
				$trans["user_contact"] = $user_detail->user_contact;
			} else {
				$trans["user_name"] = "";
				$trans["user_contact"] = "";
			}
			array_push($transaction_detail, $trans);
		}
		return $transaction_detail;
	}

	public function deleteLocation($ad_id, $location_no) {
		$CommonFunc = new CommonFunctions();
		$counter_to_delete = intval($location_no) - 1;
		$location_to_delete = $CommonFunc->getLocationAtCounter($ad_id, $counter_to_delete); 
		if(is_object($location_to_delete)) {
			$location_id = $location_to_delete->location_id;
			if($CommonFunc->deleteLocation($location_id)) {
				$this->message_list[] = "Location deleted successfully";
				$CommonFunc->decreaseLocationCount($ad_id);
			} else {
				$this->error_list[] = SERVER_ERROR;
			}

		} else {
			$this->error_list[] = "Location not found";
		}
	} 


}

?>