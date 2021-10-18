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
		$file_dir = "images/profile/".$file_name;
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function storeAdsImage($imageData, $file_name) {
		// remove "data:image/png;base64," and save to file
		$file_dir = "images/ad/".$file_name;
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function storeCompanyImage($imageData, $file_name) {
		// remove "data:image/png;base64," and save to file
		$file_dir = "images/company/".$file_name;
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function storeStoreImage($imageData, $file_name) {
		// remove "data:image/png;base64," and save to file
		$file_dir = "images/store/".$file_name;
		if(move_uploaded_file($imageData, $file_dir)) {
			return true;
		} else {
			return false;
		}
	}

	public function getAdsForState($get_ads_struct, $location_state) {
		$CommonFunc = new CommonFunctions();
		$ads = $CommonFunc->getAllAds();
		if(is_array($ads)) {
			$all_ads = [];
			foreach ($ads as $key => $ad) {
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
				// $this_ad["ad_banner"] = $ad["ads_banner"];
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
					$location_this["location_state"] = $l_value["location_state"];
					$ad_state = strtolower($l_value["location_state"]);
					if(strpos($ad_state, strtolower($location_state)) !== false) {
					// if($l_value["location_state"] == $location_state) {
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
		$ads = $CommonFunc->getAllAds();
		if(is_array($ads)) {
			$all_ads = [];
			foreach ($ads as $key => $ad) {
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
				// $this_ad["ad_banner"] = $ad["ads_banner"];
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
					$location_this["location_state"] = $l_value["location_state"];
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
				$this_ad["campaign_name"] = $campaign_detail->campaign_name;
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
			if(!$CommonFunc->getUserActivityOnAd($user_id, $ad_id, "Ad Located")) {
				$ad_detail = $CommonFunc->getAdDetail($ad_id);
				if(is_object($ad_detail)) {
					$reward = $ad_detail->reward_amount;
					$activity = $CommonFunc->addUserActivity($user_id, $ad_id, "Ad Located", "", "", $reward);
					if($activity != -1) {
						/* update amount in the user's wallet */
						// $update_wallet = $CommonFunc->updateUserWallet($user_id, $reward);

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
				if(!$CommonFunc->getUserActivityOnAd($user_id, $check_ad_id, "Quiz Answered")) {
					
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
						$CommonFunc->insertTransaction($user_id, $check_ad_id, $store_id, "paytm", $payment_status["status"], "", $total_reward, $order_id, $payment_status["transaction_id"]);
						$response["display_message"] = "Your Activity Saved Successfully.";
						$response["credit_amount"] = $total_reward;
						$response["wallet_amount"] = $wallet_amount;
						$response["correct_answer"] = $total_correct;
						$response["wrong_answer"] = $total_wrong;
					} else {
						$update_wallet = $CommonFunc->updateUserWallet($user_id, $total_reward);
						$CommonFunc->insertTransaction($user_id, $check_ad_id, $store_id, "paytm", $payment_status["status"], "", $total_reward, $order_id, $payment_status["transaction_id"]);
						$response["display_message"] = "Your Activity Saved Successfully. Amount will be transfer to your paytm account shortly.";
						$response["credit_amount"] = $total_reward;
						$response["wallet_amount"] = $wallet_amount;
						$response["correct_answer"] = $total_correct;
						$response["wrong_answer"] = $total_wrong;
					}
					return $response;
				} else {
					return QUIZ_ALREADY_ANSWERED_FOR_QUIZ;
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
			$profile = [];
			$profile["user_name"] = $user_detail->user_name;
			$profile["user_email"] = $user_detail->user_email;
			$profile["user_contact"] = $user_detail->user_contact;
			$profile["user_gender"] = $user_detail->gender;
			$profile["user_address"] = $user_detail->user_address;
			$profile["user_city"] = $user_detail->user_city;
			$profile["user_state"] = $user_detail->user_state;
			$profile["user_pincode"] = $user_detail->user_pincode;
			$profile["user_photo"] = $user_detail->user_photo;
			$profile["user_dob"] = $user_detail->user_dob;
			$profile["user_age"] = date("Y") - date_format(date_create($user_detail->user_dob), "Y");
			$profile["user_salary"] = $user_detail->user_salary;
			$profile["user_profession"] = $user_detail->user_profession;
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
			if($value != "" && $longitude[$key] != "") {
				if($CommonFunc->addNewLocationToAd($ad_id, $value, $longitude[$key], $location_state[$key]) != -1) {
					$counter = $counter +1;
				}
			}
		}
		/* update location count in ad*/
		$CommonFunc->updateLocationCountAd($ad_id, $counter);
		return $counter;
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
			}
		}
		/*update question count to the ad*/
		$CommonFunc->updateQuestionCountAd($ad_id, $counter);
		return $counter;
	}

	public function createAd($ad_struct) {
		$banner_image = $ad_struct->ads_banner_image;
		$logo_image = $ad_struct->company_logo_image;
		if(!is_null($banner_image["tmp_name"])) {
			$banner_name = $ad_struct->campaign_id.date("ymdhis").".png";
			if($this->storeAdsImage($banner_image["tmp_name"], $banner_name)) {
				$ad_struct->ads_banner = $banner_name;
			}
		}
		
		if(!is_null($logo_image["tmp_name"])) {
			$logo_name = $ad_struct->campaign_id.date("ymdhis").".png";
			if($this->storeCompanyImage($logo_image["tmp_name"], $logo_name)) {
				$ad_struct->company_logo = $logo_name;
			}
		}
		$CommonFunc = new CommonFunctions();
		return $CommonFunc->createAd($ad_struct);
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

	

	//update Quiz
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


	public function getTargetedAudience($min_age, $max_age, $gender) {
		// echo $min_age.".".$max_age.".".$gender."<br>";
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
				$age = intval(date("Y") - date_format(date_create($dob), "Y"));
				// echo ".".$age;
				if($min_age < $age && $age < $max_age) {
					$targeted_audience = $targeted_audience + 1;
				} 
			}
			$response = [];
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
	public function createStore($store_stuct) {
		/* create a user*/
		$CommonFunc = new CommonFunctions();
		$user_id = $CommonFunc->createStoreUser($store_struct->user_email, $store_struct->owner_contact, $store_struct->user_password, $store_struct->store_name, "store");
		$store_stuct->owner_id = $user_id;
		if($user_id != -1) {
			$store_id = $CommonFunc->createStore($store_stuct);
			if($store_id != -1) {
				$store_image = $store_stuct->store_image;
				if(!is_null($banner_image["tmp_name"])) {
					$image_name = $store_id.".png";
					$this->storeStoreImage($store_image["tmp_name"], $image_name);
				}
				$user_image = $store_stuct->user_photo;
				if(!is_null($user_image["tmp_name"])) {
					$user_image_name = $user_id.".png";
					$this->storeProfileImage($user_image["tmp_name"], $user_image_name);
				}
				$this->message_list[] = STORE_CREATE_SUCCESSFULLY;
			} else {
				$this->error_list[] = UNABLE_TO_SAVE_STORE;
			}
		} else {
			$this->error_list[] = UNABLE_TO_SAVE_STORE;
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
			$this->error_list[] = PASSWORD_NOT_CHANGED;
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

}

?>