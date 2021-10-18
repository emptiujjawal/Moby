package com.snq.nearbucks.object;

import android.util.Log;

import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.orm.SugarRecord;
import com.orm.dsl.Ignore;
import com.orm.dsl.Unique;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class BD extends SugarRecord {
    @Unique
    private long uid;
    private String productName;
    private String productPhotoURL;
    private String companyName;
    private String companyPhotoURL;
    private String website;
    private int checkInReward;
    private int quizReward;
    private int coverageRadius;
    private double latLocation;
    private double longLocation;
    private String locationContact;
    private String locationAddress;
    private String locationEmail;
    private String locationLandmark;
    private Store store;
    private boolean isProductDealAvailable;
    private String dealOff;
    private String dealCouponCode;
    private String dealBuyLink;
    @Ignore
    private double distanceToStore;
    @Ignore
    private double approxDistanceToStore;
    @Ignore
    private Marker locationMarker;
    @Ignore
    private List<Question> questions;

    public BD() {
    }

    public BD(int uid, String productName, String productPhotoURL, String companyPhotoURL, String companyName, int checkInReward, int quizReward, int coverageRadius, double lat, double lng) {
        this.uid = uid;
        this.productName = productName;
        this.productPhotoURL = productPhotoURL;
        this.companyPhotoURL = companyPhotoURL;
        this.companyName = companyName;
        this.checkInReward = checkInReward;
        this.quizReward = quizReward;
        this.coverageRadius = coverageRadius;
        this.latLocation = lat;
        this.longLocation = lng;
    }

    public String getWebsite() {
        return website.isEmpty()?"":website;
    }

    public void setWebsite(String website) {
        this.website = website;
    }
    public String getDealOff() {
        return dealOff;
    }

    public void setDealOff(String dealOff) {
        this.dealOff = dealOff;
    }

    public String getDealCouponCode() {
        return dealCouponCode;
    }

    public void setDealCouponCode(String dealCouponCode) {
        this.dealCouponCode = dealCouponCode;
    }

    public String getDealBuyLink() {
        return dealBuyLink;
    }

    public void setDealBuyLink(String dealBuyLink) {
        this.dealBuyLink = dealBuyLink;
    }

    public void setQuestions(List<Question> questions) {
        this.questions = questions;
    }

    public boolean isProductDealAvailable() {
        return isProductDealAvailable;
    }

    public void setProductDealAvailable(boolean productDealAvailable) {
        isProductDealAvailable = productDealAvailable;
    }

    public long getUid() {
        return uid;
    }

    public void setUid(long uid) {
        this.uid = uid;
    }

    public String getProductName() {
        return productName;
    }

    public void setProductName(String productName) {
        this.productName = productName;
    }

    public String getProductPhotoURL() {
        return productPhotoURL;
    }

    public void setProductPhotoURL(String productPhotoURL) {
        this.productPhotoURL = productPhotoURL;
    }

    public String getCompanyName() {
        return companyName;
    }

    public void setCompanyName(String companyName) {
        this.companyName = companyName;
    }

    public int getCheckInReward() {
        return checkInReward;
    }

    public void setCheckInReward(int checkInReward) {
        this.checkInReward = checkInReward;
    }

    public int getQuizReward() {
        return quizReward;
    }

    public void setQuizReward(int quizReward) {
        this.quizReward = quizReward;
    }


    public int getTotalReward() {
        return getCheckInReward() + getQuizReward();
    }

    public int getCoverageRadius() {
        return coverageRadius==0?5:coverageRadius;
    }

    public void setCoverageRadius(int coverageRadius) {
        this.coverageRadius = coverageRadius;
    }

    public double getLatLocation() {
        return latLocation;
    }

    public void setLatLocation(double latLocation) {
        this.latLocation = latLocation;
    }

    public double getLongLocation() {
        return longLocation;
    }

    public void setLongLocation(double longLocation) {
        this.longLocation = longLocation;
    }

    public Store getStore() {
        return store;
    }

    public void setStore(Store store) {
        this.store = store;
    }

    public double getDistanceToStore() {
        return distanceToStore;
    }

    public void setDistanceToStore(double distanceToStore) {
        this.distanceToStore = distanceToStore;
    }

    public Marker getLocationMarker() {
        return locationMarker;
    }

    public void setLocationMarker(Marker locationMarker) {
        this.locationMarker = locationMarker;
    }

    public LatLng getStoreLatLng() {
        return new LatLng(store.getLatLocation(), store.getLongLocation());
    }
    public LatLng getADLatLng() {
        if(getLatLocation()==0 || getLongLocation()==0){
            return new LatLng(store.getLatLocation(), store.getLongLocation());
        }
        return new LatLng(getLatLocation(), getLongLocation());
    }

    public String getLocationContact() {
        return locationContact;
    }

    public void setLocationContact(String locationContact) {
        this.locationContact = locationContact;
    }

    public String getLocationAddress() {
        return locationAddress;
    }

    public void setLocationAddress(String locationAddress) {
        this.locationAddress = locationAddress;
    }

    public String getLocationEmail() {
        return locationEmail;
    }

    public void setLocationEmail(String locationEmail) {
        this.locationEmail = locationEmail;
    }

    public String getLocationLandmark() {
        return locationLandmark;
    }

    public void setLocationLandmark(String locationLandmark) {
        this.locationLandmark = locationLandmark;
    }

    public double getApproxDistanceToStore() {
        return approxDistanceToStore;
    }

    public void setApproxDistanceToStore(double approxDistanceToStore) {
        this.approxDistanceToStore = approxDistanceToStore;
    }

    public List<Question> getQuestions() {
        if (questions == null || questions.isEmpty()) {
            questions = Question.find(Question.class, "ADID = ?", String.valueOf(getUid()));
        }
        return questions;
    }

    public void addQuestions(Question question) {
        if (questions == null) {
            questions = new ArrayList<>();
        }
        questions.add(question);
    }

    public void addSubmission(int qNo, Submission submission) {
        getQuestions().get(qNo).setSubmission(submission);
    }

    public String getCompanyPhotoURL() {
        return companyPhotoURL;
    }

    public void setCompanyPhotoURL(String companyPhotoURL) {
        this.companyPhotoURL = companyPhotoURL;
    }


    public static BD fromJSON(JSONObject jsonObject) throws JSONException {
        long uid =Long.parseLong(jsonObject.getString("ad_id"));
        List<BD> bds = BD.find(BD.class, "uid = ? ", String.valueOf(uid));
        BD bd;
        if(!bds.isEmpty()){
            bd = bds.get(0);
        }else{
            bd = new BD();
        }
        // Deserialize json into object fields
        bd.setUid(Long.parseLong(jsonObject.getString("ad_id")));
        bd.setProductName(jsonObject.getString("product_name"));
        bd.setProductPhotoURL(jsonObject.getString("ad_banner"));
        bd.setCompanyName(jsonObject.getString("company_name"));
        bd.setWebsite(jsonObject.getString("company_url"));
        bd.setCoverageRadius(Integer.parseInt(jsonObject.getString("ad_coverage")));
        bd.setCheckInReward(Integer.parseInt(jsonObject.getString("check_in_reward")));
        bd.setQuizReward(Integer.parseInt(jsonObject.getString("quiz_reward")));
        bd.setCompanyPhotoURL(jsonObject.getString("company_logo"));
        bd.setDealOff(jsonObject.has("off_deal") ? jsonObject.getString("off_deal") : "");
        bd.setDealCouponCode(jsonObject.has("coupon_code") ? jsonObject.getString("coupon_code") : "");
        bd.setDealBuyLink(jsonObject.has("deal_link") ? jsonObject.getString("deal_link") : "");
        JSONObject storeObject = jsonObject.getJSONObject("store_detail");
        Store store = Store.fromJSON(storeObject, bd.getUid());
        JSONArray quiz = jsonObject.getJSONArray("quiz");
        for (int i = 0; i < quiz.length(); i++) {
            JSONObject questionObj = quiz.getJSONObject(i);
            Question q = Question.fromJSON(questionObj, bd.getUid());
            bd.addQuestions(q);
        }
        bd.setStore(store);
        long id = bd.save();
        Log.d("AD id", bd.getId() + " or ID "+id);
        // Return new object
        return bd;
    }

    public static BD fromJSONAndLocation(JSONObject jsonObject, JSONObject location) throws JSONException {
        long uid =Long.parseLong(jsonObject.getString("ad_id")+location.getString("location_id"));
        List<BD> bds = BD.find(BD.class, "uid = ? ", String.valueOf(uid));
        BD bd;
        if(!bds.isEmpty()){
            bd = bds.get(0);
        }else{
            bd = new BD();
        }
        // Deserialize json into object fields
        bd.setUid(uid);
        bd.setProductName(jsonObject.getString("product_name"));
        bd.setProductPhotoURL(jsonObject.getString("ad_banner"));
        bd.setCompanyName(jsonObject.getString("company_name"));
        bd.setWebsite(jsonObject.getString("company_url"));
        bd.setCoverageRadius(Integer.parseInt(jsonObject.getString("ad_coverage")));
        bd.setCheckInReward(Integer.parseInt(jsonObject.getString("check_in_reward")));
        bd.setQuizReward(Integer.parseInt(jsonObject.getString("quiz_reward")));
        bd.setCompanyPhotoURL(jsonObject.getString("company_logo"));
        bd.setDealOff(jsonObject.has("off_deal") ? jsonObject.getString("off_deal") : "");
        bd.setDealCouponCode(jsonObject.has("coupon_code") ? jsonObject.getString("coupon_code") : "");
        bd.setDealBuyLink(jsonObject.has("deal_link") ? jsonObject.getString("deal_link") : "");
        bd.setLatLocation(location.getDouble("location_lat"));
        bd.setLongLocation(location.getDouble("location_long"));
        bd.setLocationAddress(location.getString("location_address"));
        bd.setLocationContact(location.getString("location_contact"));
        bd.setLocationEmail(location.getString("location_email"));
        bd.setLocationLandmark(location.getString("location_landmark"));
        JSONObject storeObject = jsonObject.getJSONObject("store_detail");
        Store store = Store.fromJSON(storeObject, bd.getUid());
        JSONArray quiz = jsonObject.getJSONArray("quiz");
        for (int i = 0; i < quiz.length(); i++) {
            JSONObject questionObj = quiz.getJSONObject(i);
            Question q = Question.fromJSON(questionObj, bd.getUid());
            bd.addQuestions(q);
        }
        bd.setStore(store);
        long id = bd.save();
        Log.d("AD id", bd.getId() + " or ID "+id);
        // Return new object
        return bd;
    }

}
