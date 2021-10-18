package com.snq.nearbucks.manager;

import android.content.Context;
import android.location.Location;
import android.location.LocationManager;

import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.maps.android.SphericalUtil;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.listener.OnLocationChangedListener;

/**
 * Created by rahul on 04-07-2016.
 */
public class NBManager implements OnLocationChangedListener{

    LatLngBounds latLngBounds;
    Location location;
    LocationManager lm;
    int userLocationType = 0;  // 0 for GPS and 1 for state name
    String userSelectedState;
    private static NBManager instance;
    public static NBManager getInstance(){
        if(instance==null){
            instance = new NBManager();
        }
        return instance;
    }

    private NBManager() {
        BApplication.getInstance().addUIListener(OnLocationChangedListener.class,this);
        lm = (LocationManager) BApplication.getInstance().getSystemService(Context.LOCATION_SERVICE);
    }

    @Override
    public void onLocationChanged(Location location) {
        this.location = location;
    }

    public LatLngBounds toBounds(LatLng center, double radius) {
        LatLng southwest = SphericalUtil.computeOffset(center, radius * Math.sqrt(2.0), 225);
        LatLng northeast = SphericalUtil.computeOffset(center, radius * Math.sqrt(2.0), 45);
        return latLngBounds = new LatLngBounds(southwest, northeast);
    }

    public LatLngBounds getLatLngBounds(){
        if(latLngBounds == null){
            return toBounds(new LatLng(location.getLatitude(),location.getLongitude()),20000);
        }
        return latLngBounds;
    }

    public Location getCurrentLocation(){
        return location;
    }

    public int getUserLocationType() {
        return userLocationType;
    }

    public void setUserLocationType(int userLocationType) {
        this.userLocationType = userLocationType;
    }

    public String getUserSelectedState() {
        return userSelectedState;
    }

    public void setUserSelectedState(String userSelectedState) {
        this.userSelectedState = userSelectedState;
    }
}
