<?php 

class AdStructure {

	public $ad_id = "";
	public $campaign_id = null;
	public $ad_name = null;
	public $start_date = "";
	public $end_date = "";
	public $exclusion_days = "";
	public $product_name = null;
	public $product_url = null;
	public $company_name = null;
	public $company_url = null;
	public $company_logo = null;
	public $company_logo_image = [];
	public $coverage_radius = 0;
	public $ads_banner = null;
	public $ads_banner_image = [];
	public $associated_store = null; // id of the store
	public $reward_amount = 0;
	public $audience_saved = TRUE;
	public $min_entry_age = 0;
	public $max_entry_age = 100;
	public $entry_gender = "all";
	public $salary_group = "";
	public $club_membership = "";
	public $defence_service = "";
	public $work_type = "";
	public $watch_brand = "";
	public $car_brand = "";
	public $residence_type = "";
	public $transport_type = "";
	public $miles_card = "";
	public $credit_card = "";
	public $location_count = 0;
	public $question_count = 0;
	public $quiz_reward = 0;
	public $off_deal = "";
	public $coupon_code = "";
	public $deal_link = "";
	public $expiry_date = "";
	public $moby_audience = "off";
	public $loyalty_audience = "public";
	public $questions = array();
	public $locations = array();

}

?>