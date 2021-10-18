package com.snq.nearbucks.object;

import com.orm.SugarRecord;
import com.orm.dsl.Unique;

/**
 * Created by rahul on 4/1/17.
 */
public class UserTransaction extends SugarRecord {

    @Unique
    private long uid;
    private long userID;
    private int type;
    private String date;
    private String adName;
    private String adProductPhotoURL;
    private long productID;
    private int amount;

    public UserTransaction(){}

    public long getUid() {
        return uid;
    }

    public void setUid(long uid) {
        this.uid = uid;
    }

    public long getUserID() {
        return userID;
    }

    public void setUserID(long userID) {
        this.userID = userID;
    }

    public int getType() {
        return type;
    }

    public void setType(int type) {
        this.type = type;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public long getProductID() {
        return productID;
    }

    public void setProductID(long productID) {
        this.productID = productID;
    }

    public int getAmount() {
        return amount;
    }

    public void setAmount(int amount) {
        this.amount = amount;
    }

    public String getAdName() {
        return adName;
    }

    public void setAdName(String adName) {
        this.adName = adName;
    }

    public String getAdProductPhotoURL() {
        return adProductPhotoURL;
    }

    public void setAdProductPhotoURL(String adProductPhotoURL) {
        this.adProductPhotoURL = adProductPhotoURL;
    }
}
