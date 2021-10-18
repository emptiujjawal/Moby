package com.snq.nearbucks.object;

import android.util.Log;

import com.orm.SugarRecord;
import com.orm.dsl.Ignore;
import com.orm.dsl.Unique;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

/**
 * Created by rahul on 4/1/17.
 */
public class Store extends SugarRecord {

    @Unique
    private long uid;
    private String storeName;
    private String storePhotoURL;
    private String areaAddress;
    private String cityAddress;
    private String landmark;
    private int pincodeAddress;
    private double latLocation;
    private double longLocation;
    private long adid;
    @Ignore
    private double distanceToStore;

    public Store() {
    }

    public long getUid() {
        return uid;
    }

    public void setUid(long uid) {
        this.uid = uid;
    }

    public String getStoreName() {
        return storeName != null ? storeName : "";
    }

    public void setStoreName(String storeName) {
        this.storeName = storeName;
    }

    public String getStorePhotoURL() {
        return storePhotoURL;
    }

    public void setStorePhotoURL(String storePhotoURL) {
        this.storePhotoURL = storePhotoURL;
    }

    public String getAreaAddress() {
        return areaAddress != null ? areaAddress : "";
    }

    public void setAreaAddress(String areaAddress) {
        this.areaAddress = areaAddress;
    }

    public String getCityAddress() {
        return cityAddress != null ? cityAddress : "";
    }

    public void setCityAddress(String cityAddress) {
        this.cityAddress = cityAddress;
    }

    public int getPincodeAddress() {
        return pincodeAddress;
    }

    public void setPincodeAddress(int pincodeAddress) {
        this.pincodeAddress = pincodeAddress;
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

    public double getDistanceToStore() {
        return distanceToStore;
    }

    public void setDistanceToStore(double distanceToStore) {
        this.distanceToStore = distanceToStore;
    }

    public static Store fromJSON(JSONObject storeObject, long adid) throws JSONException {
        long uid = Long.parseLong(storeObject.getString("store_id"));
        List<Store> stores = Store.find(Store.class, "uid = ? ", String.valueOf(uid));
        Store store;
        if(!stores.isEmpty()){
            store = stores.get(0);
        }else{
            store = new Store();
        }
        // Deserialize json into object fields
        store.setUid(Long.parseLong(storeObject.getString("store_id")));
        store.setStoreName(storeObject.getString("store_name"));
        store.setStorePhotoURL(storeObject.getString("store_photo_url"));
        store.setAreaAddress("");
        store.setLatLocation(Double.parseDouble(storeObject.getString("store_lat")));
        store.setLongLocation(Double.parseDouble(storeObject.getString("store_long")));
        store.setADID(adid);
        store.setLandmark("");
        long id = store.save();
        Log.d("Store id", store.getId() + " or ID "+id);
        // Return new object
        return store;
    }

    public long getADID() {
        return adid;
    }

    public void setADID(long adid) {
        this.adid = adid;
    }

    public String getFullAddress() {
        return getAreaAddress() + ", " + getCityAddress()+", "+getPincodeAddress();
    }

    public String getLandmark() {
        return landmark != null ? landmark : "-";
    }

    public void setLandmark(String landmark) {
        this.landmark = landmark;
    }
}
