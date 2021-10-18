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
import com.snq.nearbucks.listener.OnBDsChangedListener;
import com.snq.nearbucks.listener.OnLocationChangedListener;
import com.snq.nearbucks.listener.OnLocationTypeChangedListener;
import com.snq.nearbucks.object.BD;
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

public class BankManager implements OnLocationChangedListener,OnLocationTypeChangedListener {

    private Location currentLocation;

    private int currentLocationBankCount = -1;
    private List<BD> bankList;
    Set<Long> notifiedbanks;
    private static BankManager instance;
    public static BankManager getInstance(){
        if(instance==null){
            instance = new BankManager();
        }
        return instance;
    }

    private BankManager(){
        notifiedbanks  = new HashSet<>();
        bankList = new ArrayList<>();
        List<BD> tempi = BD.listAll(BD.class);
        if(tempi!=null && tempi.size()>0) {
            bankList.addAll(tempi);
        }
        BApplication.getInstance().addUIListener(OnLocationChangedListener.class,this);
        BApplication.getInstance().addUIListener(OnLocationTypeChangedListener.class,this);
    }

    public boolean isbankNotified(long bdUID){
        return notifiedbanks.contains(bdUID);
    }


    public void addToNotifiedbanks(long bdUID){
        notifiedbanks.add(bdUID);
    }

    public void addBD(BD bd){
        if(bd ==null)
            return;
        bankList.add(bd);
    }

    public BD getBD(int position){
        return bankList.get(position);
    }
    public BD getBDByUID(long uid){
        //if(adList.size()==0){
        //  adList.addAll(AD.listAll(AD.class));
        //}
        for(BD bd: bankList) {
            if(bd.getUid()==uid) {
                return bd;
            }
        }
        return null;
    }

    public List<BD> getBankList(){
/*        if(adList.isEmpty()){
            adList.addAll(AD.listAll(AD.class));
        }*/
        return bankList;
    }

    public void updateBDs(JSONArray array) throws JSONException {
        bankList.clear();
        notifiedbanks.clear();
        for(int i=0;i<array.length();i++){
            JSONObject jsonObject = array.getJSONObject(i);
            JSONArray locations = jsonObject.getJSONArray("location");
            if(locations.length()>0) {
                for (int j = 0; j < locations.length(); j++) {
                    BD bd = BD.fromJSONAndLocation(jsonObject,locations.getJSONObject(j));
                    bankList.add(bd);
                }
            }else{
                BD bd = BD.fromJSON(jsonObject);
                bankList.add(bd);
            }
        }
        currentLocationBankCount = bankList.size();
    }

    @Override
    public void onLocationChanged(Location location) {
        if(DeviceLocationService.isBetterLocation(location,currentLocation) || (bankList.isEmpty()&&currentLocationBankCount==-1)) {
            currentLocation = location;
            fetchBDs();
        }
    }

    private void fetchBDs() {
        if(currentLocation==null)
            return;
        final LatLngBounds llb = NBManager.getInstance().toBounds(new LatLng(currentLocation.getLatitude(),currentLocation.getLongitude()),10000);
        //PBManager.getInstance().showPB("Fetching ADs...", false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        Log.d(BankManager.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        try {
                            JSONObject res = new JSONObject(response);
                            boolean error = res.getBoolean("error");
                            if(error){
                                String message = res.getString("message");
                                Toast.makeText(BApplication.getInstance(), message, Toast.LENGTH_LONG).show();
                                currentLocationBankCount = 0;
                                return;
                            }
                            JSONArray message = res.getJSONArray("message");
                            updateBDs(message);
                            for (OnBDsChangedListener listener : BApplication.getInstance().getUIListeners(OnBDsChangedListener.class)) {
                                listener.onBDsChanged();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(BankManager.class.getName(), "Error: " + error.getMessage());
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
        bankList.clear();
        currentLocationBankCount = -1;
        for (OnBDsChangedListener listener : BApplication.getInstance().getUIListeners(OnBDsChangedListener.class)) {
            listener.onBDsChanged();
        }
        if(NBManager.getInstance().getUserLocationType()==1){
            fetchStateBDs();
        }
    }

    private void fetchStateBDs() {
        if(NBManager.getInstance().getUserSelectedState()==null)
            return;
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        Log.d(BankManager.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        try {
                            JSONObject res = new JSONObject(response);
                            boolean error = res.getBoolean("error");
                            if(error){
                                String message = res.getString("message");
                                Toast.makeText(BApplication.getInstance(), message, Toast.LENGTH_LONG).show();
                                currentLocationBankCount = 0;
                                return;
                            }
                            JSONArray message = res.getJSONArray("message");
                            updateBDs(message);
                            for (OnBDsChangedListener listener : BApplication.getInstance().getUIListeners(OnBDsChangedListener.class)) {
                                listener.onBDsChanged();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(BankManager.class.getName(), "Error: " + error.getMessage());
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


