<?php 

include("constant.php");
include("Operations.php");
include("CommonFunctions.php");
$response = array("error" => FALSE);

if (isset($_POST["json_identifier"])) {
// if (true) {
	if($_POST["json_identifier"] == "LOGIN") {
	// if (true) {
		require_once("structure/Login.php");
		$login_struct = new Login_Struct();
		$login_struct = processLoginData($login_struct);
		$opr = new Operations();
		$login = $opr->login($login_struct);
		if(is_array($login)) {
			$response["message"] = $login;
		} else {
			$response["error"] = TRUE;
			$response["message"] = $login;
		}
	} elseif ($_POST["json_identifier"] == "GET_ADS") {
	// } elseif (true) {
		require_once("structure/GetAds.php");
		$get_ads = new GetAds();
		$get_ads = processGetAds($get_ads);
		$opr = new Operations();
		if (isset($_POST["location_state"])) {
			$state_to_search = strtolower($_POST["location_state"]);
			$ads = $opr->getAdsForState($get_ads, $state_to_search);
		} else {
			$ads = $opr->getAdsForLocation($get_ads);
		}
		
		if(is_array($ads)) {
			$response["message"] = $ads;
		} else {
			$response["error"] = TRUE;
			$response["message"] = $ads;
		}
	} elseif ($_POST["json_identifier"] == "AD_LOCATED") {
		$opr = new Operations();
		$ad_located = $opr->storeLocatedByUser($_POST["ad_id"], $_POST["user_contact"]);
		if(is_array($ad_located)) {
			$response["message"] = $ad_located;
		} else {
			$response["error"] = TRUE;
			$response["message"] = $ad_located;
		}
	} elseif ($_POST["json_identifier"] == "QUIZ_ANSWERED") {
		include("Paytm.php");
		$opr = new Operations();
		$quiz_answered = $opr->questionAnswered($_POST["user_contact"], $_POST["quiz_answered"], "");
		if(is_array($quiz_answered)) {
			$response["message"] = $quiz_answered;
		} else {
			$response["error"] = FALSE;
			$response["message"]["display_message"] = $quiz_answered;
		}
	} elseif ($_POST["json_identifier"] == "USER_TIMELINE") {
		$opr = new Operations();
		$timeline = $opr->getTimeline($_POST["user_contact"]);
		if(is_array($timeline)) {
			$response["message"] = $timeline;
		} else {
			$response["error"] = TRUE;
			$response["message"] = $timeline;
		}
	} elseif ($_POST["json_identifier"] == "USER_TRANSACTION") {
		$opr = new Operations();
		$timeline = $opr->getTranscation($_POST["user_contact"]);
		if(is_array($timeline)) {
			$response["message"] = $timeline;
		} else {
			$response["error"] = TRUE;
			$response["message"] = $timeline;
		}
	} elseif ($_POST["json_identifier"] == "USER_PROFILE") {
		$opr = new Operations();
		$response["message"] = $opr->getUserProfile($_POST["user_contact"]);
	} elseif ($_POST["json_identifier"] == "PROFILE_UPDATE") {
		require_once("structure/Login.php");
		$login_struct = new Login_Struct();
		$login_struct = processLoginData($login_struct);
		$opr = new Operations();
		$update = $opr->updateUserProfile($login_struct);
		if(is_array($update)) {
			$response["message"] = $update;
		} else {
			$response["error"] = TRUE;
			$response["message"] = $update;
		}
	} elseif($_POST["json_identifier"] == "GET_TARGETED_AUDIENCE") {
		$opr = new Operations();
		$audience = $opr->getTargetedAudience($_POST);
		if(is_array($audience)) {
			$response["message"] = $audience;
		} else {
			$response["error"] = TRUE;
			$response["message"] = $audience;
		}
	} elseif ($_POST["json_identifier"] == "GET_MESSAGES") {
		if(isset($_POST["user_contact"])) {
			$opr = new Operations();
			$messages = $opr->getMessagesForUser($_POST["user_contact"]);
			if (is_array($messages)) {
				$response["message"] = $messages;
			} else {
				$response["error"] = TRUE;
				$response["message"] = $messages;
			}
		} else {
			$response["error"] = TRUE;
			$response["message"] = PARAMTER_MISSING;
		}
	} elseif ($_POST["json_identifier"] == "GET_STATUS") {
		if(isset($_POST["user_contact"])) {
			$opr = new Operations();
			$status = $opr->getStatusForUser($_POST["user_contact"]);
			$response["status"] = $status;
		} else {
			$response["error"] = TRUE;
			$response["message"] = PARAMTER_MISSING;
		}
	} else {
		$response["error"] = TRUE;
		$response["message"] = UNDEFINED_IDENTIFIER;
	}
} else {
	$response["error"] = TRUE;
	$response["message"] = IDENTFIER_MISSING;
}

$response["post"] = $_POST;
echo json_encode($response);

function processGetAds($get_ads) {
	if(isset($_POST["user_contact"])) {
		$get_ads->user_contact = $_POST["user_contact"];
	}
	if(isset($_POST["user_lat"])) {
		$get_ads->user_lat = $_POST["user_lat"];
	}
	if(isset($_POST["user_long"])) {
		$get_ads->user_long = $_POST["user_long"];
	}
	if(isset($_POST["lat1"])) {
		$get_ads->location_lat_1 = floatval($_POST["lat1"]);
	}
	if(isset($_POST["long1"])) {
		$get_ads->location_long_1 = floatval($_POST["long1"]);
	}
	if(isset($_POST["lat2"])) {
		$get_ads->location_lat_2 = floatval($_POST["lat2"]);
	}
	if(isset($_POST["long2"])) {
		$get_ads->location_long_2 = floatval($_POST["long2"]);
	}
	return $get_ads;
}

function processLoginData($login_struct) {
	if(isset($_POST["user_contact"])) {
		$login_struct->user_contact = $_POST["user_contact"];
	}
	if(isset($_POST["login_using"])) {
		$login_struct->login_using = $_POST["login_using"];
	}
	if(isset($_POST["user_email"])) {
		$login_struct->user_email = $_POST["user_email"];
	}
	if(isset($_POST["user_password"])) {
		$login_struct->user_password = $_POST["user_password"];
	}
	if(isset($_POST["user_name"])) {
		$login_struct->user_name = $_POST["user_name"];
	}
	if(isset($_POST["user_profile_image"])) {
		$login_struct->user_profile_image = $_POST["user_profile_image"];
	}
	if(isset($_POST["user_dob"])) {
		$login_struct->user_dob = $_POST["user_dob"];
	}
	if(isset($_POST["user_age"])) {
		$login_struct->user_age = $_POST["user_age"];
	}
	if(isset($_POST["user_gender"])) {
		$login_struct->user_gender = $_POST["user_gender"];
	}
	if(isset($_POST["user_address"])) {
		$login_struct->user_address = $_POST["user_address"];
	}
	if(isset($_POST["user_location"])) {
		$login_struct->user_location = $_POST["user_location"];
	}
	if(isset($_POST["user_city"])) {
		$login_struct->user_city = $_POST["user_city"];
	}
	if(isset($_POST["user_state"])) {
		$login_struct->user_state = $_POST["user_state"];
	}
	if(isset($_POST["user_pincode"])) {
		$login_struct->user_pincode = $_POST["user_pincode"];
	}
	if(isset($_POST["user_salary"])) {
		$login_struct->user_salary = $_POST["user_salary"];
	}
	if(isset($_POST["club_membership"])) {
		$login_struct->club_membership = $_POST["club_membership"];
	}
	if(isset($_POST["defence_service"])) {
		$login_struct->defence_service = $_POST["defence_service"];
	}
	if(isset($_POST["work_type"])) {
		$login_struct->work_type = $_POST["work_type"];
	}
	if(isset($_POST["user_profession"])) {
		$login_struct->user_profession = $_POST["user_profession"];
	}
	if(isset($_POST["watch_brand"])) {
		$login_struct->watch_brand = $_POST["watch_brand"];
	}
	if(isset($_POST["car_brand"])) {
		$login_struct->car_brand = $_POST["car_brand"];
	}
	if(isset($_POST["residence_type"])) {
		$login_struct->residence_type = $_POST["residence_type"];
	}
	if(isset($_POST["locality"])) {
		$login_struct->locality = $_POST["locality"];
	}
	if(isset($_POST["transport_type"])) {
		$login_struct->transport_type = $_POST["transport_type"];
	}
	if(isset($_POST["miles_card"])) {
		$login_struct->miles_card = $_POST["miles_card"];
	}
	if(isset($_POST["credit_card"])) {
		$login_struct->credit_card = $_POST["credit_card"];
	}
	if(isset($_POST["fb_link"])) {
		$login_struct->fb_link = $_POST["fb_link"];
	}
	if(isset($_POST["twitter_link"])) {
		$login_struct->twitter_link = $_POST["twitter_link"];
	}
	if(isset($_POST["gplus_link"])) {
		$login_struct->gplus_link = $_POST["gplus_link"];
	}
	// if(isset($_POST[""])) {
	// 	$login_struct-> = $_POST[""];
	// }

	
	return $login_struct;
}

?>