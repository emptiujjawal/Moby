<?php
include("constant.php");
include("Operations.php");
include("CommonFunctions.php");

$CommonFunc = new CommonFunctions();

/* if campaign id is obtained then campaign is saved
 - if campaign name is obtained then campaign should be saved */
include("structure/Campaign.php");
$campaign_struct = new CampaignStructure();
$campaign_struct = processCampaignData($campaign_struct);
/* save the campaign detail and get its id */
if($campaign_struct->campaign_id == "") {
	$campaign_struct->campaign_id = $CommonFunc->createCampaign($campaign_struct->campaign_name, $campaign_struct->store_id);
}

/* process ad data and save the ad */
include("structure/Ad.php");
$ad_struct = new AdStructure();
$ad_struct = processAdData($ad_struct);
$ad_id = $CommonFunc->createAd($ad_struct);
if($ad_id != -1) {
	
} else {
	/* ad not created */
}

function processAdData($ad_struct) {
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
	if(isset($_POST["company_logo"])) {
		$ad_struct->company_logo = $_POST["company_logo"];
	}
	if(isset($_POST["coverage_radius"])) {
		$ad_struct->coverage_radius = $_POST["coverage_radius"];
	}
	if(isset($_POST["ads_banner"])) {
		$ad_struct->ads_banner = $_POST["ads_banner"];
	}
	if(isset($_POST["associated_store"])) {
		$ad_struct->associated_store = $_POST["associated_store"];
	}
	if(isset($_POST["min_entry_age"])) {
		$ad_struct->min_entry_age = $_POST["min_entry_age"];
	}
	if(isset($_POST["max_entry_age"])) {
		$ad_struct->max_entry_age = $_POST["max_entry_age"];
	}
	if(isset($_POST["entry_gender"])) {
		$ad_struct->entry_gender = $_POST["entry_gender"];
	}
	if(isset($_POST["location_count"])) {
		$ad_struct->location_count = $_POST["location_count"];
	}
	if(isset($_POST["question_count"])) {
		$ad_struct->question_count = $_POST["question_count"];
	}
	if(isset($_POST["quiz_reward"])) {
		$ad_struct->quiz_reward = $_POST["quiz_reward"];
	}
	return $ad_struct;
}

function processCampaignData($campaign_struct) {
	if(isset($_POST["campaign_id"])) {
		$campaign_struct->campaign_id = $_POST["campaign_id"];
	}
	if(isset($_POST["campaign_name"])) {
		$campaign_struct->campaign_name = $_POST["campaign_name"];
	}
	if(isset($_POST["store_id"])) {
		$campaign_struct->store_id = $_POST["store_id"];
	}
	return $campaign_struct;
}


 ?>