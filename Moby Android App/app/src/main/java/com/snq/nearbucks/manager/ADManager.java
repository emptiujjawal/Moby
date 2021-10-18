package com.snq.nearbucks.manager;

import android.location.Location;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.firebase.auth.FirebaseAuth;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.listener.OnADsChangedListener;
import com.snq.nearbucks.listener.OnLocationChangedListener;
import com.snq.nearbucks.listener.OnLocationTypeChangedListener;
import com.snq.nearbucks.object.AD;
import com.snq.nearbucks.service.DeviceLocationService;
import com.snq.nearbucks.utils.URL;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Map;
import java.util.Set;

/**
 * Created by rahul on 04-07-2016.
 */
public class ADManager implements OnLocationChangedListener,OnLocationTypeChangedListener{

    private Location currentLocation;
    private int currentLocationADCount = -1;
    private List<AD> adList;
    Set<Long> notifiedAds;
    private static ADManager instance;
    public static ADManager getInstance(){
        if(instance==null){
            instance = new ADManager();
        }
        return instance;
    }

    private ADManager() {
        notifiedAds = new HashSet<>();
        adList = new ArrayList<>();
        List<AD> temp = AD.listAll(AD.class);
        if(temp!=null && temp.size()>0) {
            adList.addAll(temp);
        }
        BApplication.getInstance().addUIListener(OnLocationChangedListener.class,this);
        BApplication.getInstance().addUIListener(OnLocationTypeChangedListener.class,this);
    }

    public boolean isAdNotified(long adUID){
        return notifiedAds.contains(adUID);
    }


    public void addToNotifiedAds(long adUID){
        notifiedAds.add(adUID);
    }

    public void addAD(AD ad){
        if(ad ==null)
            return;
        adList.add(ad);
    }
    public AD getAD(int position){
        return adList.get(position);
    }
    public AD getADByUID(long uid){
        //if(adList.size()==0){
          //  adList.addAll(AD.listAll(AD.class));
        //}
        for(AD ad: adList) {
            if(ad.getUid()==uid) {
                return ad;
            }
        }
        return null;
    }

    public List<AD> getAdList(){
/*        if(adList.isEmpty()){
            adList.addAll(AD.listAll(AD.class));
        }*/
        return adList;
    }

    public void updateADs(JSONArray array) throws JSONException {
        adList.clear();
        notifiedAds.clear();
        for(int i=0;i<array.length();i++){
            JSONObject jsonObject = array.getJSONObject(i);
            JSONArray locations = jsonObject.getJSONArray("location");
            if(locations.length()>0) {
                for (int j = 0; j < locations.length(); j++) {
                    AD ad = AD.fromJSONAndLocation(jsonObject,locations.getJSONObject(j));
                    adList.add(ad);
                }
            }else{
                AD ad = AD.fromJSON(jsonObject);
                adList.add(ad);
            }
        }
        currentLocationADCount = adList.size();
    }

    @Override
    public void onLocationChanged(Location location) {
        if(DeviceLocationService.isBetterLocation(location,currentLocation) || (adList.isEmpty()&&currentLocationADCount==-1)) {
            currentLocation = location;
            fetchADs();
        }
    }

    private void fetchADs() {
        if(currentLocation==null)
            return;
        final LatLngBounds llb = NBManager.getInstance().toBounds(new LatLng(currentLocation.getLatitude(),currentLocation.getLongitude()),10000);
        //PBManager.getInstance().showPB("Fetching ADs...", false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        Log.d(ADManager.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        try {
                            JSONObject res = new JSONObject(response);
                            boolean error = res.getBoolean("error");
                            if(error){
                                String message = res.getString("message");
                                Toast.makeText(BApplication.getInstance(), message, Toast.LENGTH_LONG).show();
                                currentLocationADCount = 0;
                                return;
                            }
                            JSONArray message = res.getJSONArray("message");
                            updateADs(message);
                            for (OnADsChangedListener listener : BApplication.getInstance().getUIListeners(OnADsChangedListener.class)) {
                                listener.onADsChanged();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(ADManager.class.getName(), "Error: " + error.getMessage());
                PBManager.getInstance().cancelPB();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(URL.REQUEST_IDENTIFIER, URL.FETCH_ADS_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                params.put(URL.PARAMETER_USER_LOCATION_LAT, currentLocation.getLatitude()+"");
                params.put(URL.PARAMETER_USER_LOCATION_LONG, currentLocation.getLongitude()+"");
                params.put(URL.PARAMETER_LOCATION_LAT_1, llb.southwest.latitude+"");
                params.put(URL.PARAMETER_LOCATION_LONG_1, llb.southwest.longitude+"");
                params.put(URL.PARAMETER_LOCATION_LAT_2, llb.northeast.latitude+"");
                params.put(URL.PARAMETER_LOCATION_LONG_2, llb.northeast.longitude+"");
                return params;
            }

        };
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.FETCH_ADS_IDENTIFIER);
    }

    @Override
    public void onLocationTypeChanged() {
        adList.clear();
        currentLocationADCount = -1;
        for (OnADsChangedListener listener : BApplication.getInstance().getUIListeners(OnADsChangedListener.class)) {
            listener.onADsChanged();
        }
        if(NBManager.getInstance().getUserLocationType()==1){
            fetchStateADs();
        }
    }

    private void fetchStateADs() {
        if(NBManager.getInstance().getUserSelectedState()==null)
            return;
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        Log.d(ADManager.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        try {
                            JSONObject res = new JSONObject(response);
                            boolean error = res.getBoolean("error");
                            if(error){
                                String message = res.getString("message");
                                Toast.makeText(BApplication.getInstance(), message, Toast.LENGTH_LONG).show();
                                currentLocationADCount = 0;
                                return;
                            }
                            JSONArray message = res.getJSONArray("message");
                            updateADs(message);
                            for (OnADsChangedListener listener : BApplication.getInstance().getUIListeners(OnADsChangedListener.class)) {
                                listener.onADsChanged();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(ADManager.class.getName(), "Error: " + error.getMessage());
                PBManager.getInstance().cancelPB();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(URL.REQUEST_IDENTIFIER, URL.FETCH_ADS_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                params.put(URL.PARAMETER_LOCATION_STATE, NBManager.getInstance().getUserSelectedState());
                return params;
            }

        };
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.FETCH_ADS_IDENTIFIER);
    }

}
