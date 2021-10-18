<?php
// load the constants
require_once('classes/constant.php');

// Load the Common Func Class
require_once('classes/CommonFunctions.php');

// load the login class
require_once('classes/Login.php');

require_once("classes/Operations.php");
require_once("classes/structure/Ad.php");
require_once("classes/structure/Login.php");

$from_date = date("Y-m-d");
$to_date = date_format(date_modify(date_create(date("Y-m-d")), "+1 day"), "Y-m-d");

$login = new Login();
if ($login->isUserLoggedIn() == TRUE) {

	$store_id = $_SESSION["store_id"];
	$display_name = $_SESSION['user_name'];
	$user_type = $_SESSION['user_type'];
	$user_id = $_SESSION["user_id"];

	if (isset($_GET["ADD_NEW_AD"])) {
		$CommonFunc = new CommonFunctions();
		$opr = new Operations();
		$start_to_end_date = date_format(date_create(date("Y-m-d")), "m/d/Y")." - ".date_format(date_modify(date_create(date("Y-m-d")), "+1 months"), "m/d/Y");
		
		if(!isset($_SESSION["ad_struct"])) {
			$ad_struct = new AdStructure();
			$_SESSION["ad_struct"] = $ad_struct;
		}
		if(!isset($_SESSION["min_entry_age"])) {
			$_SESSION["min_entry_age"] = -1;
		}
		if(isset($_POST["campaign_id"])) {
			$campaign_id = $_POST["campaign_id"];
		}
		
		$location = [];
		$campaign_id = "";
		$ad_id = "";
		$campaign_saved = "active";
		$ad_saved = "1";
		$audience_saved = "";
		$locations_saved = "";
		$questions_saved = "";
		$final_confirmation = "";

		if(isset($_POST["SELECT_CAMPAIGN"]) ) {
			$campaign_id = $_POST["campaign_id"];
			$campaign_saved = "complete";
			$ad_saved = "active";
			$_SESSION["campaign_id"] = $campaign_id;
		} elseif (isset($_POST["SAVE_CAMPAIGN"])) {
			$campaign_id = $CommonFunc->createCampaign($_POST["campaign_name"], $store_id);
			$_SESSION["campaign_id"] = $campaign_id;
			$campaign_saved = "complete";
			$ad_saved = "active";
		}
		// echo $_SESSION["ad_struct"]->ad_name;
		if(isset($_POST["CREATE_AD"])) {
			$ad_struct = $_SESSION["ad_struct"];
			$ad_struct = processAdData($ad_struct);
			$ad_struct->associated_store = $store_id;
			$ad_struct->campaign_id = $_SESSION["campaign_id"];
			$ad_result = $opr->createAd($ad_struct);
			if($ad_result != -1) {
				$_SESSION["ad_struct"] = $ad_struct;
				$ad_id = $ad_result;
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "active";
				$_SESSION["ad_struct"]->ad_id = $ad_id;
				$_SESSION["ad_struct"]->campaign_id = $_SESSION["campaign_id"];
				// echo json_encode($_SESSION["ad_struct"]);\
			} else {
				// echo json_encode($ad_result);
				$_SESSION["ad_struct"] = $ad_struct;
				$ad_saved = "active";
			}
		}

		if(isset($_POST["UPDATE_AD"])) {
			$ad_struct = $_SESSION["ad_struct"];
			$ad_struct = processAdData($ad_struct);
			$ad_struct->associated_store = $store_id;
			$ad_result = $opr->updateAd($ad_struct);
			if($ad_result != -1) {
				$_SESSION["ad_struct"] = $ad_struct;
				$ad_id = $ad_result;
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "active";
				$_SESSION["ad_struct"]->ad_id = $ad_id;
				$_SESSION["ad_struct"]->campaign_id = $_SESSION["campaign_id"];
				// echo json_encode($_SESSION["ad_struct"]);
			} else {
				$_SESSION["ad_struct"] = $ad_struct;
				$ad_saved = "active";
			}
			
		}

		
		if(isset($_POST["SAVE_AUDIENCE"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			if($CommonFunc->updateAudience($_POST["ad_id"], $_POST["min_entry_age"], $_POST["max_entry_age"], $_POST["entry_gender"], $_POST["moby_audience"], $_POST["loyalty_audience"], $_POST["salary_group"], $_POST["club_membership"], $_POST["defence_service"], $_POST["work_type"], $_POST["watch_brand"], $_POST["car_brand"], $_POST["residence_type"], $_POST["transport_type"], $_POST["miles_card"], $_POST["credit_card"])) {
				$_SESSION["ad_struct"]->min_entry_age = $_POST["min_entry_age"];
				$_SESSION["ad_struct"]->max_entry_age = $_POST["max_entry_age"];
				$_SESSION["ad_struct"]->entry_gender = $_POST["entry_gender"];
				$_SESSION["ad_struct"]->salary_group = $_POST["salary_group"];
				$_SESSION["ad_struct"]->club_membership = $_POST["club_membership"];
				$_SESSION["ad_struct"]->defence_service = $_POST["defence_service"];
				$_SESSION["ad_struct"]->work_type = $_POST["work_type"];
				$_SESSION["ad_struct"]->watch_brand = $_POST["watch_brand"];
				$_SESSION["ad_struct"]->car_brand = $_POST["car_brand"];
				$_SESSION["ad_struct"]->residence_type = $_POST["residence_type"];
				$_SESSION["ad_struct"]->transport_type = $_POST["transport_type"];
				$_SESSION["ad_struct"]->miles_card = $_POST["miles_card"];
				$_SESSION["ad_struct"]->credit_card = $_POST["credit_card"];
				$_SESSION["ad_struct"]->audience_saved = TRUE;
				$audience_saved = "complete";
				$ad_saved = "complete";
				$campaign_saved = "complete";
				$locations_saved = "active";
			}
		}

		if(isset($_POST["SAVE_AD_LOCATIONS"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			$audience_saved = "complete";
			if($opr->addLocationToAd($ad_id, $_POST["lat"], $_POST["long"], $_POST["location_state"])) {
				$locations_saved = "complete";
				$audience_saved = "complete";
				$ad_saved = "complete";
				$campaign_saved = "complete";
				$questions_saved = "active";
			}
		}

		if(isset($_POST["DELETE_LOCATION"])) {
			$ad_id = $_POST["ad_id"];
			$location_count = $_POST["location_counter"];
			$opr->deleteLocation($ad_id, $location_count);
			$audience_saved = "complete";
			$ad_saved = "complete";
			$campaign_saved = "complete";
			$locations_saved = "active";
			$location_saved = $CommonFunc->getLocationForAds($ad_id, 10);
			$_SESSION["ad_struct"]->locations = array();
			if(is_array($location_saved)) {
				
				foreach ($location_saved as $lsk => $lsv) {
					$this_location = [];
					$this_location["lat"] = $lsv["location_lat"];
					$this_location["long"] = $lsv["location_long"];
					$this_location["state"] = $lsv["location_state"];
					$this_location["landmark"] = $lsv["landmark"];
					$this_location["email"] = $lsv["email"];
					$this_location["contact"] = $lsv["contact"];
					array_push($_SESSION["ad_struct"]->locations, $this_location);	
				}
			}
		}

		if(isset($_POST["SAVE_LOCATION"])) {
			$ad_id = $_POST["ad_id"];
			$opr->AddNewLocationToAd($ad_id, $_POST["lat"], $_POST["long"], $_POST["location_state"], $_POST["landmark"], $_POST["email"], $_POST["contact"]);
			$audience_saved = "complete";
			$ad_saved = "complete";
			$campaign_saved = "complete";
			$locations_saved = "active";
			$_SESSION["ad_struct"]->locations = array();
			$location_saved = $CommonFunc->getLocationForAds($ad_id, 10);
			if(is_array($location_saved)) {
				foreach ($location_saved as $lsk => $lsv) {
					$this_location = [];
					$this_location["lat"] = $lsv["location_lat"];
					$this_location["long"] = $lsv["location_long"];
					$this_location["state"] = $lsv["location_state"];
					$this_location["landmark"] = $lsv["landmark"];
					$this_location["email"] = $lsv["email"];
					$this_location["contact"] = $lsv["contact"];
					array_push($_SESSION["ad_struct"]->locations, $this_location);	
				}
			}
		}

		if(isset($_POST["UPDATE_AD_LOCATIONS"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			$audience_saved = "complete";
			if($opr->updateLocationToAd($ad_id, $_POST["lat"], $_POST["long"], $_POST["location_state"])) {
				$locations_saved = "complete";
				$audience_saved = "complete";
				$ad_saved = "complete";
				$campaign_saved = "complete";
				$questions_saved = "active";
			}
		}

		if(isset($_POST["SAVE_AD_QUESTIONS"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			$audience_saved = "complete";
			$locations_saved = "complete";
			$campaign_saved = "complete";

			if($opr->addQuestionToAd($ad_id)) {
				$ad_saved = "complete";
				$questions_saved = "complete";
				$final_confirmation = "active";
				$ad_detail = $CommonFunc->getAdDetail($_SESSION["ad_struct"]->ad_id);
				$campaign_detail = $CommonFunc->getCampaignDetail($_SESSION["ad_struct"]->campaign_id);
				$quiz_detail = $CommonFunc->getQuizForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->quiz_count);
				$location_detail = $CommonFunc->getLocationForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->location_count);

				foreach ($location_detail as $l_key => $l_value) {
					$location_this = [];
					$location_this["location_id"] = $l_value["location_id"];
					$location_this["lat"] = $l_value["location_lat"];
					$location_this["lng"] = $l_value["location_long"];
					array_push($location, $location_this);
				}
			}
		}

		if(isset($_POST["UPDATE_AD_QUESTIONS"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			$audience_saved = "complete";
			$locations_saved = "complete";
			$campaign_saved = "complete";

			if($opr->updateQuestionToAd($ad_id)) {
				$ad_saved = "complete";
				$questions_saved = "complete";
				$final_confirmation = "active";
				$ad_detail = $CommonFunc->getAdDetail($_SESSION["ad_struct"]->ad_id);
				$campaign_detail = $CommonFunc->getCampaignDetail($_SESSION["ad_struct"]->campaign_id);
				$quiz_detail = $CommonFunc->getQuizForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->quiz_count);
				$location_detail = $CommonFunc->getLocationForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->location_count);

				foreach ($location_detail as $l_key => $l_value) {
					$location_this = [];
					$location_this["location_id"] = $l_value["location_id"];
					$location_this["lat"] = $l_value["location_lat"];
					$location_this["lng"] = $l_value["location_long"];
					array_push($location, $location_this);
				}
			}
		}

		$saved_ad = $_SESSION["ad_struct"];
		$ad_id = $saved_ad->ad_id;
		$campaign_id = $saved_ad->campaign_id;
		$start_to_end_date = date_format(date_create($saved_ad->start_date), "m/d/Y")." - ".date_format(date_create($saved_ad->end_date), "m/d/Y");

		$exclusion_days_array = explode(",", $saved_ad->exclusion_days);
		if(isset($_POST["FORM_BACK"])) {
			
			if(isset($_POST["FROM_AD"])) {
				$campaign_saved = "active";
			}
			if(isset($_POST["FROM_AUDIENCE"])) {
				$campaign_saved = "complete";
				$ad_saved = "active";
			}
			if(isset($_POST["FROM_LOCATION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "active";
			}
			if(isset($_POST["FROM_QUESTION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "active";
			}
			if(isset($_POST["FROM_FINAL_CONFIRMATION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "complete";
				$questions_saved = "active";
			}
		}

		if(isset($_POST["FORM_NEXT"])) {
			if(isset($_POST["FROM_CAMPAIGN"])) {
				$campaign_saved = "complete";
				$ad_saved = "active";
			}
			if(isset($_POST["FROM_AD"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "active";
			}
			if(isset($_POST["FROM_AUDIENCE"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "active";
			}
			if(isset($_POST["FROM_LOCATION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "complete";
				$questions_saved = "active";
			}
			if(isset($_POST["FROM_QUESTION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "complete";
				$questions_saved = "complete";
				$final_confirmation = "active";
				$ad_detail = $CommonFunc->getAdDetail($_SESSION["ad_struct"]->ad_id);
				$campaign_detail = $CommonFunc->getCampaignDetail($_SESSION["ad_struct"]->campaign_id);
				$quiz_detail = $CommonFunc->getQuizForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->quiz_count);
				$location_detail = $CommonFunc->getLocationForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->location_count);
			}
		}
		$code_type = $opr->getCodeType();
		
		include("ad_form.php");
	} elseif (isset($_GET["SHOW_ALL_ADS"])) {
		if(isset($_SESSION["ad_struct"])) {
			unset($_SESSION["ad_struct"]);
		}
		
		$opr = new Operations();
		if(isset($_GET["ad_id"])) {
			$ad_id = $_GET["ad_id"];
		}
		if(isset($_GET["publish"])){
			$opr->publishAd($ad_id);
		} elseif (isset($_GET["draft"])) {
			$opr->draftAd($ad_id);
		}
		include("ad_show.php");
	} elseif (isset($_GET["AD_VIEW"])) {
		$ad_id = $_GET["ad_id"];
		if(isset($_POST["publish"])) {
			$opr->publishAd($ad_id);
		}
		$CommonFunc = new CommonFunctions();
		include("ad_view.php");
	} elseif (isset($_GET["AD_UPDATE"])) {


		$CommonFunc = new CommonFunctions();
		$opr = new Operations();
		$start_to_end_date = date_format(date_create(date("Y-m-d")), "m/d/Y")." - ".date_format(date_modify(date_create(date("Y-m-d")), "+1 months"), "m/d/Y");
		
		if(!isset($_SESSION["min_entry_age"])) {
			$_SESSION["min_entry_age"] = -1;
		}
		if(isset($_POST["campaign_id"])) {
			$campaign_id = $_POST["campaign_id"];
		}
		
		$location = [];
		$campaign_id = "";
		$ad_id = "";
		$campaign_saved = "active";
		$ad_saved = "1";
		$audience_saved = "";
		$locations_saved = "";
		$questions_saved = "";
		$final_confirmation = "";
		$ad_struct = new AdStructure();
		$_SESSION["ad_struct"] = $ad_struct;
		if(isset($_GET["ad_id"])) {
			$ad_id = $_GET["ad_id"];
			$ad_detailget = $CommonFunc->getAdDetail($ad_id);
			if(is_object($ad_detailget)) {
				$_SESSION["ad_struct"]->ad_id = $ad_detailget->ad_id;
				$_SESSION["ad_struct"]->campaign_id = $ad_detailget->campaign_id;
				$_SESSION["ad_struct"]->ad_name = $ad_detailget->ad_name;
				$_SESSION["ad_struct"]->start_date = $ad_detailget->start_date;
				$_SESSION["ad_struct"]->end_date = $ad_detailget->end_date;
				$_SESSION["ad_struct"]->exclusion_days = $ad_detailget->exclusion_days;
				$_SESSION["ad_struct"]->product_name = $ad_detailget->product_name;
				$_SESSION["ad_struct"]->product_url = $ad_detailget->product_url;
				$_SESSION["ad_struct"]->company_name = $ad_detailget->company_name;
				$_SESSION["ad_struct"]->company_url = $ad_detailget->company_url;
				$_SESSION["ad_struct"]->company_logo = $ad_detailget->company_logo;
				$_SESSION["ad_struct"]->coverage_radius = $ad_detailget->coverage_radius;
				$_SESSION["ad_struct"]->ads_banner = $ad_detailget->ads_banner;
				$_SESSION["ad_struct"]->associated_store = $ad_detailget->associated_store;
				$_SESSION["ad_struct"]->reward_amount = $ad_detailget->reward_amount;
				$_SESSION["ad_struct"]->min_entry_age = $ad_detailget->min_entry_age;
				$_SESSION["ad_struct"]->max_entry_age = $ad_detailget->max_entry_age;
				$_SESSION["ad_struct"]->entry_gender = $ad_detailget->entry_gender;
				$_SESSION["ad_struct"]->salary_group = $ad_detailget->salary_group;
				$_SESSION["ad_struct"]->club_membership = $ad_detailget->club_membership;
				$_SESSION["ad_struct"]->defence_service = $ad_detailget->defence_service;
				$_SESSION["ad_struct"]->work_type = $ad_detailget->work_type;
				$_SESSION["ad_struct"]->watch_brand = $ad_detailget->watch_brand;
				$_SESSION["ad_struct"]->car_brand = $ad_detailget->car_brand;
				$_SESSION["ad_struct"]->residence_type = $ad_detailget->residence_type;
				$_SESSION["ad_struct"]->transport_type = $ad_detailget->transport_type;
				$_SESSION["ad_struct"]->miles_card = $ad_detailget->miles_card;
				$_SESSION["ad_struct"]->credit_card = $ad_detailget->credit_card;
				$_SESSION["ad_struct"]->quiz_reward = $ad_detailget->reward_amount;
				$_SESSION["ad_struct"]->off_deal = $ad_detailget->off_deal;
				$_SESSION["ad_struct"]->coupon_code = $ad_detailget->coupon_code;
				$_SESSION["ad_struct"]->deal_link = $ad_detailget->deal_link;
				$_SESSION["ad_struct"]->moby_audience = $ad_detailget->moby_audience;
				$_SESSION["ad_struct"]->loyalty_audience = $ad_detailget->loyalty_audience;
			}
		}

		if(isset($_POST["SELECT_CAMPAIGN"]) ) {
			$campaign_id = $_POST["campaign_id"];
			$campaign_saved = "complete";
			$ad_saved = "active";
			$_SESSION["campaign_id"] = $campaign_id;
		} elseif (isset($_POST["SAVE_CAMPAIGN"])) {
			$campaign_id = $CommonFunc->createCampaign($_POST["campaign_name"], $store_id);
			$_SESSION["campaign_id"] = $campaign_id;
			$campaign_saved = "complete";
			$ad_saved = "active";
		}

		if(isset($_POST["UPDATE_AD"])) {
			$ad_struct = $_SESSION["ad_struct"];
			$ad_struct = processAdData($ad_struct);
			$ad_struct->associated_store = $store_id;
			$ad_result = $opr->updateAd($ad_struct);
			if($ad_result != -1) {
				$_SESSION["ad_struct"] = $ad_struct;
				$ad_id = $ad_result;
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "active";
				$_SESSION["ad_struct"]->ad_id = $ad_id;
				$_SESSION["ad_struct"]->campaign_id = $_SESSION["campaign_id"];
				// echo json_encode($_SESSION["ad_struct"]);
			} else {
				$_SESSION["ad_struct"] = $ad_struct;
				$ad_saved = "active";
			}
		}

		if(isset($_POST["SAVE_AUDIENCE"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			if($CommonFunc->updateAudience($_POST["ad_id"], $_POST["min_entry_age"], $_POST["max_entry_age"], $_POST["entry_gender"], $_POST["moby_audience"], $_POST["loyalty_audience"], $_POST["salary_group"], $_POST["club_membership"], $_POST["defence_service"], $_POST["work_type"], $_POST["watch_brand"], $_POST["car_brand"], $_POST["residence_type"], $_POST["transport_type"], $_POST["miles_card"], $_POST["credit_card"])) {
				$_SESSION["ad_struct"]->min_entry_age = $_POST["min_entry_age"];
				$_SESSION["ad_struct"]->max_entry_age = $_POST["max_entry_age"];
				$_SESSION["ad_struct"]->entry_gender = $_POST["entry_gender"];
				$_SESSION["ad_struct"]->salary_group = $_POST["salary_group"];
				$_SESSION["ad_struct"]->club_membership = $_POST["club_membership"];
				$_SESSION["ad_struct"]->defence_service = $_POST["defence_service"];
				$_SESSION["ad_struct"]->work_type = $_POST["work_type"];
				$_SESSION["ad_struct"]->watch_brand = $_POST["watch_brand"];
				$_SESSION["ad_struct"]->car_brand = $_POST["car_brand"];
				$_SESSION["ad_struct"]->residence_type = $_POST["residence_type"];
				$_SESSION["ad_struct"]->transport_type = $_POST["transport_type"];
				$_SESSION["ad_struct"]->miles_card = $_POST["miles_card"];
				$_SESSION["ad_struct"]->credit_card = $_POST["credit_card"];
				$_SESSION["ad_struct"]->audience_saved = TRUE;
				$audience_saved = "complete";
				$ad_saved = "complete";
				$campaign_saved = "complete";
				$locations_saved = "active";
			}
		}

		if(isset($_POST["SAVE_AD_LOCATIONS"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			$audience_saved = "complete";
			if($opr->addLocationToAd($ad_id, $_POST["lat"], $_POST["long"], $_POST["location_state"])) {
				$locations_saved = "complete";
				$audience_saved = "complete";
				$ad_saved = "complete";
				$campaign_saved = "complete";
				$questions_saved = "active";
			}
		}

		if(isset($_POST["DELETE_LOCATION"])) {
			$ad_id = $_POST["ad_id"];
			$location_count = $_POST["location_counter"];
			$opr->deleteLocation($ad_id, $location_count);
			$audience_saved = "complete";
			$ad_saved = "complete";
			$campaign_saved = "complete";
			$locations_saved = "active";
		}

		if(isset($_POST["SAVE_LOCATION"])) {
			$ad_id = $_POST["ad_id"];
			$opr->AddNewLocationToAd($ad_id, $_POST["lat"], $_POST["long"], $_POST["location_state"], $_POST["landmark"], $_POST["email"], $_POST["contact"]);
			$audience_saved = "complete";
			$ad_saved = "complete";
			$campaign_saved = "complete";
			$locations_saved = "active";
			
		}

		if(isset($_POST["SAVE_AD_QUESTIONS"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			$audience_saved = "complete";
			$locations_saved = "complete";
			$campaign_saved = "complete";

			if($opr->addQuestionToAd($ad_id)) {
				$ad_saved = "complete";
				$questions_saved = "complete";
				$final_confirmation = "active";
				$ad_detail = $CommonFunc->getAdDetail($_SESSION["ad_struct"]->ad_id);
				$campaign_detail = $CommonFunc->getCampaignDetail($_SESSION["ad_struct"]->campaign_id);
				$quiz_detail = $CommonFunc->getQuizForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->quiz_count);
				$location_detail = $CommonFunc->getLocationForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->location_count);

				foreach ($location_detail as $l_key => $l_value) {
					$location_this = [];
					$location_this["location_id"] = $l_value["location_id"];
					$location_this["lat"] = $l_value["location_lat"];
					$location_this["lng"] = $l_value["location_long"];
					array_push($location, $location_this);
				}
			}
		}

		if(isset($_POST["UPDATE_AD_QUESTIONS"])) {
			$campaign_id = $_POST["campaign_id"];
			$ad_id = $_POST["ad_id"];
			$audience_saved = "complete";
			$locations_saved = "complete";
			$campaign_saved = "complete";

			if($opr->updateQuestionToAd($ad_id)) {
				$ad_saved = "complete";
				$questions_saved = "complete";
				$final_confirmation = "active";
				$ad_detail = $CommonFunc->getAdDetail($_SESSION["ad_struct"]->ad_id);
				$campaign_detail = $CommonFunc->getCampaignDetail($_SESSION["ad_struct"]->campaign_id);
				$quiz_detail = $CommonFunc->getQuizForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->quiz_count);
				$location_detail = $CommonFunc->getLocationForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->location_count);

				foreach ($location_detail as $l_key => $l_value) {
					$location_this = [];
					$location_this["location_id"] = $l_value["location_id"];
					$location_this["lat"] = $l_value["location_lat"];
					$location_this["lng"] = $l_value["location_long"];
					array_push($location, $location_this);
				}
			}
		}

		/*cehck if location already saved*/
		$location_saved = $CommonFunc->getLocationForAds($ad_id, 10);
		$_SESSION["ad_struct"]->locations = array();
		if(is_array($location_saved)) {
			foreach ($location_saved as $lsk => $lsv) {
				$this_location = [];
				$this_location["lat"] = $lsv["location_lat"];
				$this_location["long"] = $lsv["location_long"];
				$this_location["state"] = $lsv["location_state"];
				$this_location["landmark"] = $lsv["landmark"];
				$this_location["email"] = $lsv["email"];
				$this_location["contact"] = $lsv["contact"];
				array_push($_SESSION["ad_struct"]->locations, $this_location);	
			}
		}

		/*save qustions to the session vairable*/
		$quiz_detail = $CommonFunc->getQuizForAds($_SESSION["ad_struct"]->ad_id, 3);
		if (is_array($quiz_detail)) {
			foreach ($quiz_detail as $q_key => $q_value) {
				$this_question = [];
				$this_question["question"] = $q_value["question"];
				$this_question["options"] = $q_value["options"];
				$this_question["answer"] = $q_value["answer"];
				array_push($_SESSION["ad_struct"]->questions, $this_question);
			}
		}

		$saved_ad = $_SESSION["ad_struct"];
		$ad_id = $saved_ad->ad_id;
		$campaign_id = $saved_ad->campaign_id;
		$start_to_end_date = date_format(date_create($saved_ad->start_date), "m/d/Y")." - ".date_format(date_create($saved_ad->end_date), "m/d/Y");
		$exclusion_days_array = explode(",", $saved_ad->exclusion_days);
		
		if(isset($_POST["FORM_BA	 	CK"])) {
			
			if(isset($_POST["FROM_AD"])) {
				$campaign_saved = "active";
			}
			if(isset($_POST["FROM_AUDIENCE"])) {
				$campaign_saved = "complete";
				$ad_saved = "active";
			}
			if(isset($_POST["FROM_LOCATION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "active";
			}
			if(isset($_POST["FROM_QUESTION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "active";
			}
			if(isset($_POST["FROM_FINAL_CONFIRMATION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "complete";
				$questions_saved = "active";
			}
		}

		if(isset($_POST["FORM_NEXT"])) {
			if(isset($_POST["FROM_CAMPAIGN"])) {
				$campaign_saved = "complete";
				$ad_saved = "active";
			}
			if(isset($_POST["FROM_AD"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "active";
			}
			if(isset($_POST["FROM_AUDIENCE"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "active";
			}
			if(isset($_POST["FROM_LOCATION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "complete";
				$questions_saved = "active";
			}
			if(isset($_POST["FROM_QUESTION"])) {
				$campaign_saved = "complete";
				$ad_saved = "complete";
				$audience_saved = "complete";
				$locations_saved = "complete";
				$questions_saved = "complete";
				$final_confirmation = "active";
				$ad_detail = $CommonFunc->getAdDetail($_SESSION["ad_struct"]->ad_id);
				$campaign_detail = $CommonFunc->getCampaignDetail($_SESSION["ad_struct"]->campaign_id);
				$quiz_detail = $CommonFunc->getQuizForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->quiz_count);
				$location_detail = $CommonFunc->getLocationForAds($_SESSION["ad_struct"]->ad_id, $ad_detail->location_count);
			}
		}
		$code_type = $opr->getCodeType();
		
		include("ad_update_1.php");
	} elseif (isset($_GET["CREATE_STORE"])) {
		$opr = new Operations();
		if(isset($_POST["CREATE_SUB_WALLET"])) {
			include("classes/structure/Store.php");
			$store_struct = new StoreStructure();
			$store_struct = processStoreData($store_struct);
			$opr->createStore($store_struct);
		}
		include("create_store.php");
	} elseif (isset($_GET["PROFILE"])) {
		/* get detail of the user and store
		*/
		$opr = new Operations();
		$CommonFunc = new CommonFunctions();
		
		if(isset($_POST["UPDATE_SUB_WALLET_LOGO"])) {
			$user_id = $_POST["user_id"].".png";
			$user_photo = $_FILES["user_photo"];
			if($opr->storeProfileImage($user_photo["tmp_name"], $user_id)) {
				$opr->message_list[] = "Store logo changed succesfully";
			} else {
				$opr->error_list[] = "Error in upload";
			}
		}
		if(isset($_POST["UPDATE_SUB_WALLET_IMAGE"])) {
			$store_id = $_POST["store_id"].".png";
			$store_image = $_POST["store_image"];
			if($opr->storeStoreImage($store_image["tmp_name"], $store_image)) {
				$opr->message_list[] = "Store Image changed succesfully";
			} else {
				$opr->error_list[] = "Error in upload";
			}
		}
		if(isset($_POST["UPDATE_SUB_WALLET_LOGIN"])) {
			$user_id = $_POST["user_id"];
			$password = $_POST["user_password"];
			$confirm_password = $_POST["confirm_password"];
			if($password == $confirm_password) {
				$opr->changePassword($user_id, $password);
			} else {
				$opr->error_list[] = BOTH_PASSWORD_NOT_SAME;
			}
		}
		if(isset($_POST["UPDATE_SUB_WALLET"])) {
			require_once("classes/structure/Store.php");
			$store_struct = new StoreStructure();
			$store_struct = processStoreData($store_struct);
			$opr->updateStoreProfile($store_struct);
		}
		$store_detail = $CommonFunc->getStoreDetail($store_id);
		$owner_detail = $CommonFunc->getUserDetail($store_detail->owner_id);
		include("profile.php");
	} elseif (isset($_GET["VIEW_STORES"])) {
		$opr = new Operations();
		$CommonFunc = new CommonFunctions();
		include("view_stores.php");
	} elseif (isset($_GET["STORE_DETAIL"])) {
		$opr = new Operations();
		$CommonFunc = new CommonFunctions();
		$store_detail = $CommonFunc->getStoreDetail($_GET["store_id"]);
		$owner_detail = $CommonFunc->getUserDetail($store_detail->owner_id);
		if(isset($_POST["UPDATE_SUB_WALLET_LOGO"])) {
			$user_id = $_POST["user_id"].".png";
			$user_photo = $_FILES["user_photo"];
			if($opr->storeProfileImage($user_photo["tmp_name"], $user_id)) {
				$opr->message_list[] = "Store logo changed succesfully";
			} else {
				$opr->error_list[] = "Error in upload";
			}
		}
		if(isset($_POST["UPDATE_SUB_WALLET_IMAGE"])) {
			$store_id = $_POST["store_id"].".png";
			$store_image = $_POST["store_image"];
			if($opr->storeStoreImage($store_image["tmp_name"], $store_image)) {
				$opr->message_list[] = "Store Image changed succesfully";
			} else {
				$opr->error_list[] = "Error in upload";
			}
		}
		if(isset($_POST["UPDATE_SUB_WALLET_LOGIN"])) {
			$user_id = $_POST["user_id"];
			$password = $_POST["user_password"];
			$confirm_password = $_POST["confirm_password"];
			if($password == $confirm_password) {
				$opr->changePassword($user_id, $password);
			} else {
				$opr->error_list[] = BOTH_PASSWORD_NOT_SAME;
			}
		}
		if(isset($_POST["UPDATE_SUB_WALLET"])) {
			require_once("classes/structure/Store.php");
			$store_struct = new StoreStructure();
			$store_struct = processStoreData($store_struct);
			$opr->updateStore($store_struct);
		}
		include("store_detail.php");
	} elseif (isset($_GET["VIEW_AD_ACTIVITIES"])) {
		$opr = new Operations();
		$CommonFunc = new CommonFunctions();
		$store_detail = $CommonFunc->getStoreDetail($store_id);
		$ad_detail = $CommonFunc->getAdDetail($_GET["ad_id"]);
		$transactions_in_ad = $CommonFunc->getTransactionForAd($_GET["ad_id"]);
		include("view_ad_activity.php");
	}elseif (isset($_GET["SETTINGS"])) {
		$opr = new Operations();
		if(isset($_POST["add_salary_group"])) {
			$opr->insertCodeSetting($_POST["code_type"], $_POST["code_value"]);
		}
		
		if(isset($_POST["UPDATE_PROFILE_ADVERTISMENT"])) {
			$advertisment_profile = $_FILES["advertisment_drop"];
			$opr->storeProfileAdvertismentImage($advertisment_profile["tmp_name"]);
		}
		$settings = $opr->getCodeType();
		include("setting.php");
	} elseif (isset($_GET["MESSAGES"])) {
		$opr = new Operations();
		if(isset($_POST["SAVE_MESSAGE"])) {
			require_once("classes/structure/Message.php");
			$message_struct = new Message();
			$message_struct = processMessageData($message_struct);
			$opr->createMessage($message_struct);
		}
		$code_type = $opr->getCodeType();
		include("add_messages.php");
	} elseif (isset($_GET["VIEW_AUDIENCE"])) {
		$opr = new Operations();
		$all_audience = $opr->getAudience();
		include("view_audience.php");
	} elseif (isset($_GET["UPLOAD_AUDIENCE"])) {
		if(isset($_POST["SUBMIT_AUDIENCE_FILE"])) {
			include 'vendors/PHPExcel/Classes/PHPExcel/IOFactory.php';
			$filename = $_FILES["audience_file"];
			$fileNewName = date("YmdHis").".xlsx";
			$files = move_uploaded_file($_FILES["audience_file"]["tmp_name"], "audience_file/".$fileNewName);
			$inputFileName = "audience_file/".$fileNewName;
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
			$opr = new Operations();
			$opr->uploadAudience($sheetData);
		}
		include("upload_audience.php");
	} elseif (isset($_GET["GET_TRANSACTION"])) {
		$opr = new Operations();
		$all_transaction = $opr->getTransactions($from_date, $to_date);
		include("transactions.php");
	} else {
		$opr = new Operations();
		if($user_type == "store") {
			include("ad_show.php");
		} else {
			$all_transaction = $opr->getTransactions($from_date, $to_date);
		include("transactions.php");
		}
		
	}
} else {
	if(isset($_GET["LOGIN"])) {
		include("login.php");
	} else {
		include("login.php");
		
	}
}


function processStoreData($store_struct) {

	if(isset($_POST["store_id"])) {
		$store_struct->store_id = $_POST["store_id"];
	}
	if(isset($_POST["store_name"])) {
		$store_struct->store_name = $_POST["store_name"];
	}
	if(isset($_POST["store_website"])) {
		$store_struct->store_website = $_POST["store_website"];
	}
	if(isset($_POST["store_contact"])) {
		$store_struct->store_contact = $_POST["store_contact"];
	}
	if(isset($_POST["location_lat"])) {
		$store_struct->location_lat = $_POST["location_lat"];
	}
	if(isset($_POST["location_long"])) {
		$store_struct->location_long = $_POST["location_long"];
	}
	if(isset($_POST["store_address"])) {
		$store_struct->store_address = $_POST["store_address"];
	}
	if(isset($_POST["store_city"])) {
		$store_struct->store_city = $_POST["store_city"];
	}
	if(isset($_POST["store_state"])) {
		$store_struct->store_state = $_POST["store_state"];
	}
	if(isset($_POST["store_pincode"])) {
		$store_struct->store_pincode = $_POST["store_pincode"];
	}
	if(isset($_POST["store_landmark"])) {
		$store_struct->store_landmark = $_POST["store_landmark"];
	}
	if(isset($_FILES["store_image"])) {
		$store_struct->store_image = $_FILES["store_image"];
	}
	if(isset($_FILES["user_photo"])) {
		$store_struct->user_photo = $_FILES["user_photo"];
	}
	if(isset($_POST["owner_id"])) {
		$store_struct->owner_id = $_POST["owner_id"];
	}
	if(isset($_POST["owner_contact"])) {
		$store_struct->owner_contact = $_POST["owner_contact"];
	}
	if(isset($_POST["user_email"])) {
		$store_struct->user_email = $_POST["user_email"];
	}
	if(isset($_POST["user_password"])) {
		$store_struct->user_password = $_POST["user_password"];
	}
	if(isset($_POST["confirm_password"])) {
		$store_struct->confirm_password = $_POST["confirm_password"];
	}
	if(isset($_POST["wallet_guid"])) {
		$store_struct->wallet_guid = $_POST["wallet_guid"];
	}
	if(isset($_POST["wallet_amount"])) {
		$store_struct->wallet_amount = $_POST["wallet_amount"];
	}
	if(isset($_POST["company_cin"])) {
		$store_struct->company_cin = $_POST["company_cin"];
	}
	if(isset($_POST["incorporation_date"])) {
		$store_struct->incorporation_date = $_POST["incorporation_date"];
	}
	if(isset($_POST["company_gst"])) {
		$store_struct->company_gst = $_POST["company_gst"];
	}
	if(isset($_POST["subscribed"])) {
		if($_POST["subscribed"] == "on") {
			$store_struct->subscribed = "yes";
		}
	}
	// if(isset($_POST[""])) {
	// 	$store_struct-> = $_POST[""];
	// }

	return $store_struct;
}

function processAdData($ad_struct) {
	if(isset($_POST["campaign_id"])) {
		$ad_struct->campaign_id = $_POST["campaign_id"];
	}
	if(isset($_POST["ad_name"])) {
		$ad_struct->ad_name = $_POST["ad_name"];
	}
	if(isset($_POST["product_name"])) {
		$ad_struct->product_name = $_POST["product_name"];
	}
	if(isset($_POST["product_url"])) {
		$ad_struct->product_url = $_POST["product_url"];
	}
	if(isset($_POST["company_name"])) {
		$ad_struct->company_name = $_POST["company_name"];
	}
	if(isset($_POST["company_url"])) {
		$ad_struct->company_url = $_POST["company_url"];
	}
	if(isset($_FILES["company_logo"])) {
		$ad_struct->company_logo_image = $_FILES["company_logo"];
	}
	if(isset($_POST["coverage_radius"])) {
		$ad_struct->coverage_radius = $_POST["coverage_radius"];
	}
	if(isset($_POST["reward_amount"])) {
		$ad_struct->reward_amount = $_POST["reward_amount"];
	}
	if(isset($_FILES["ads_banner"])) {
		$ad_struct->ads_banner_image = $_FILES["ads_banner"];
	}
	if(isset($_POST["associated_store"])) {
		$ad_struct->associated_store = $_POST["associated_store"];
	}
	if(isset($_POST["off_deal"])) {
		$ad_struct->off_deal = $_POST["off_deal"];
	}
	if(isset($_POST["coupon_code"])) {
		$ad_struct->coupon_code = $_POST["coupon_code"];
	}
	if(isset($_POST["deal_link"])) {
		$ad_struct->deal_link = $_POST["deal_link"];
	}
	if(isset($_POST["loyalty_audience"])) {
		$ad_struct->loyalty_audience = $_POST["loyalty_audience"];
	} 
	if(isset($_POST["moby_audience"])) {
		$ad_struct->moby_audience = $_POST["moby_audience"];
	}
	if(isset($_POST["date-range-picker"])) {
		$date_value1 =$_POST["start_date"];
		$date_value2 =$_POST["end_date"];
		$ad_struct->start_date = date_format(date_create($date_value1), "Y-m-d");
		$ad_struct->end_date = date_format(date_create($date_value2), "Y-m-d");
	}
	if(isset($_POST["exclusion_days"])) {
		$exclusion_days = implode(",", $_POST["exclusion_days"]);
		$ad_struct->exclusion_days = $exclusion_days;
	}

	return $ad_struct;
}

function processMessageData($message_struct) {
	if(isset($_POST["message_title"])) {
		$message_struct->message_title = $_POST["message_title"];
	}
	if(isset($_POST["message_content"])) {
		$message_struct->message_content = $_POST["message_content"];
	}
	if(isset($_POST["min_entry_age"])) {
		$message_struct->min_entry_age = $_POST["min_entry_age"];
	}
	if(isset($_POST["max_entry_age"])) {
		$message_struct->max_entry_age = $_POST["max_entry_age"];
	}
	if(isset($_POST["entry_gender"])) {
		$message_struct->entry_gender = $_POST["entry_gender"];
	}
	if(isset($_POST["salary_group"])) {
		$message_struct->salary_group = $_POST["salary_group"];
	}
	if(isset($_POST["work_type"])) {
		$message_struct->work_type = $_POST["work_type"];
	}
	if(isset($_POST["residence_type"])) {
		$message_struct->residence_type = $_POST["residence_type"];
	}
	if(isset($_POST["transport_type"])) {
		$message_struct->transport_type = $_POST["transport_type"];
	}
	if(isset($_POST["club_type"])) {
		$message_struct->club_type = $_POST["club_type"];
	}
	if(isset($_POST["defence_service"])) {
		$message_struct->defence_service = $_POST["defence_service"];
	}
	if(isset($_POST["watch_brand"])) {
		$message_struct->watch_brand = $_POST["watch_brand"];
	}
	if(isset($_POST["car_brand"])) {
		$message_struct->car_brand = $_POST["car_brand"];
	}
	if(isset($_POST["miles_card"])) {
		$message_struct->miles_card = $_POST["miles_card"];
	}
	if(isset($_POST["credit_card"])) {
		$message_struct->credit_card = $_POST["credit_card"];
	}
	return $message_struct;
}

?>