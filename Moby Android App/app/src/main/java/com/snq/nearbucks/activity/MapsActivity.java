package com.snq.nearbucks.activity;

import android.app.Activity;
import android.content.Intent;
import android.content.IntentSender;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.PorterDuff;
import android.graphics.PorterDuffColorFilter;
import android.graphics.Typeface;
import android.location.Location;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.content.ContextCompat;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.LocationSettingsRequest;
import com.google.android.gms.location.LocationSettingsResult;
import com.google.android.gms.location.LocationSettingsStates;
import com.google.android.gms.location.LocationSettingsStatusCodes;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.firebase.auth.FirebaseAuth;
import com.snq.nearbucks.R;
import com.snq.nearbucks.adapter.MapADVPAdapter;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.fragment.ADDetailFragment;
import com.snq.nearbucks.fragment.ADsFragment;
import com.snq.nearbucks.listener.OnADsChangedListener;
import com.snq.nearbucks.listener.OnLocationChangedListener;
import com.snq.nearbucks.listener.OnLocationTypeChangedListener;
import com.snq.nearbucks.manager.ADManager;
import com.snq.nearbucks.manager.AccountManager;
import com.snq.nearbucks.manager.NBManager;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.AD;
import com.snq.nearbucks.service.DeviceLocationService;
import com.snq.nearbucks.utils.URL;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import butterknife.ButterKnife;
import butterknife.InjectView;

import static android.Manifest.permission.ACCESS_FINE_LOCATION;
import static com.snq.nearbucks.utils.CommonUtils.dp2px;

public class MapsActivity extends BaseActivity implements OnLocationTypeChangedListener, OnLocationChangedListener, ADDetailFragment.OnADDetailFragmentInteraction, MapADVPAdapter.OnCardItemInteractionListener, OnMapReadyCallback, GoogleApiClient.ConnectionCallbacks, GoogleApiClient.OnConnectionFailedListener, ResultCallback<Status>, OnADsChangedListener {

    @InjectView(R.id.toolbar)
    Toolbar toolbar;
    @InjectView(R.id.ll_maps_title)
    LinearLayout ll_maps_title;
    @InjectView(R.id.tv_maps_currentLocation)
    TextView tv_maps_currentLocation;
    private GoogleMap mMap;
    @InjectView(R.id.vp_ads)
    ViewPager vp_ads;
    @InjectView(R.id.fl_main)
    FrameLayout fl_main;
    @InjectView(R.id.tv_maps_totalEarning)
    TextView tv_maps_totalEarning;

    //List<AD> adList;
    HashMap<String, Integer> markerMap;
    List<Marker> markers;
    HashMap<String, Integer> markerMapi;
    List<Marker> markersi;
    private Marker myLocationMarker;
    MapADVPAdapter mapResidenceVPAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle(R.string.empty);
        FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
        ADsFragment adsFragment = new ADsFragment();
        fragmentTransaction.replace(R.id.fl_main, adsFragment, "ADsFragment");
        fragmentTransaction.commit();
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);
        ll_maps_title.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //startActivity(new Intent(MapsActivity.this,SelectLocationActivity.class));
                NBManager.getInstance().setUserLocationType(0);
                NBManager.getInstance().setUserSelectedState("");
                for (OnLocationTypeChangedListener listener : BApplication.getInstance().getUIListeners(OnLocationTypeChangedListener.class)) {
                    listener.onLocationTypeChanged();
                }
                startService(new Intent(MapsActivity.this, DeviceLocationService.class));
                finish();
            }
        });
        createLocationSettingObejcts();
        checkPermissions();
    }

    private void setUpVP() {

        vp_ads.setClipToPadding(false);
        vp_ads.setPageMargin(dp2px(this, 15));
        mapResidenceVPAdapter = new MapADVPAdapter(this);
        vp_ads.setAdapter(mapResidenceVPAdapter);
        vp_ads.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {
                mMap.animateCamera(CameraUpdateFactory.newLatLngZoom(ADManager.getInstance().getAdList().get(position).getADLatLng(), 16));
                if (ADManager.getInstance().getAdList().get(position).getLocationMarker() != null){
                    ADManager.getInstance().getAdList().get(position).getLocationMarker().showInfoWindow();
                }
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });
    }

    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        long adid = intent.getLongExtra("adid", -1);
        moveToCurrentLocation();
        if (adid >= 0) {
            openThisAD(adid);
        }
    }

    private void moveToCurrentLocation() {
        if (currentLocation == null) {
            return;
        }
        mMap.animateCamera(CameraUpdateFactory.newLatLngZoom(new LatLng(currentLocation.getLatitude(), currentLocation.getLongitude()), 15));
    }

    private void openThisAD(long adid) {
        ADDetailFragment myf = ADDetailFragment.newInstance(adid, false);
        FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
        transaction.replace(R.id.fl_maps_adDetail, myf);
        transaction.addToBackStack(null);
        transaction.commit();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.maps_menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.maps_menu_switch_view: {
                switchView();
                invalidateOptionsMenu();
                break;
            }
            case R.id.maps_menu_timeline: {
                startActivity(new Intent(this, TimelineActivity.class));
                break;
            }
            case R.id.maps_menu_notification: {
                startActivity(new Intent(this, NotificationsActivity.class));
                break;
            }
            case R.id.maps_menu_profile: {
                startActivity(new Intent(this, ProfileActivity.class));
                break;
            }
            case R.id.maps_menu_dashboard: {
                startActivity(new Intent(this, TNPActivity.class));
                break;
            }
        }
        return super.onOptionsItemSelected(item);
    }

    private void switchView() {
        if (fl_main.getVisibility() == View.VISIBLE) {
            fl_main.setVisibility(View.GONE);
        } else {
            fl_main.setVisibility(View.VISIBLE);
        }
    }

    @Override
    public boolean onPrepareOptionsMenu(Menu menu) {
        MenuItem mi = menu.findItem(R.id.maps_menu_switch_view);
        if (fl_main.getVisibility() == View.VISIBLE) {
            mi.setIcon(getResources().getDrawable(R.drawable.ic_map_white_24dp));
        } else {
            mi.setIcon(getResources().getDrawable(R.drawable.ic_list_white_24dp));
        }
        return super.onPrepareOptionsMenu(menu);
    }

    /**
     * Manipulates the map once available.
     * This callback is triggered when the map is ready to be used.
     * This is where we can add markers or lines, add listeners or move the camera. In this case,
     * we just add a marker near Sydney, Australia.
     * If Google Play services is not installed on the device, the user will be prompted to install
     * it inside the SupportMapFragment. This method will only be triggered once the user has
     * installed Google Play services and returned to the app.
     */
    boolean updateVisibleMarkersList = false;
    @Override
    public void onMapReady(GoogleMap googleMap) {
        markers = new ArrayList<>();
        mMap = googleMap;
        mMap.getUiSettings().setMapToolbarEnabled(false);
        mMap.setOnMarkerClickListener(new GoogleMap.OnMarkerClickListener() {
            @Override
            public boolean onMarkerClick(Marker marker) {
                if (markerMap.containsKey(marker.getId())) {
                    vp_ads.setCurrentItem(markerMap.get(marker.getId()), true);
                }
                return false;
            }
        });
        mMap.setOnCameraMoveListener(new GoogleMap.OnCameraMoveListener() {
            @Override
            public void onCameraMove() {
                updateVisibleMarkersList = true;
                updateVisibleMarkerList();
            }
        });
        mMap.setInfoWindowAdapter(new GoogleMap.InfoWindowAdapter() {

            @Override
            public View getInfoWindow(Marker arg0) {
                return null;
            }

            @Override
            public View getInfoContents(Marker marker) {

                LinearLayout info = new LinearLayout(MapsActivity.this);
                info.setOrientation(LinearLayout.VERTICAL);

                TextView title = new TextView(MapsActivity.this);
                title.setTextColor(Color.BLACK);
                title.setGravity(Gravity.CENTER);
                title.setTypeface(null, Typeface.BOLD);
                title.setText(marker.getTitle());

                TextView snippet = new TextView(MapsActivity.this);
                snippet.setTextColor(Color.GRAY);
                snippet.setGravity(Gravity.CENTER);
                snippet.setText(marker.getSnippet());

                info.addView(title);
                info.addView(snippet);

                return info;
            }
        });
        //initADs();
        setUpVP();
  /*      if(ADManager.getInstance().getADByUID(3)!=null) {
            showPromotion();
        }*/
    }

    int youCanEarnMax = 0;
    private void updateVisibleMarkerList() {
        updateVisibleMarkersList = false;
        int prevValue = youCanEarnMax;
        youCanEarnMax = 0;
        LatLngBounds llb = mMap.getProjection().getVisibleRegion().latLngBounds;
        for(Marker m:markers){
            if(updateVisibleMarkersList){
                youCanEarnMax = prevValue;
                break;
            }
            if(llb.contains(m.getPosition())){
                AD ad = ADManager.getInstance().getAdList().get(markerMap.get(m.getId()));
                youCanEarnMax+=ad.getTotalReward();
            }
        }
        tv_maps_totalEarning.setText("You can earn - Rs. "+youCanEarnMax);
    }

    private void fetchADs() {
        if (currentLocation == null)
            return;
        PBManager.getInstance().showPB(MapsActivity.this, "Fetching ADs...", false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        Log.d(MapsActivity.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        try {
                            JSONObject res = new JSONObject(response);
                            JSONArray message = res.getJSONArray("message");
                            ADManager.getInstance().updateADs(message);
                            mapResidenceVPAdapter.update();
                            drawMarkers();
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(MapsActivity.class.getName(), "Error: " + error.getMessage());
                PBManager.getInstance().cancelPB();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(URL.REQUEST_IDENTIFIER, URL.FETCH_ADS_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                params.put(URL.PARAMETER_LOCATION_LAT, currentLocation.getLatitude() + "");
                params.put(URL.PARAMETER_LOCATION_LONG, currentLocation.getLatitude() + "");
                return params;
            }

        };

// Adding request to request queue
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.FETCH_ADS_IDENTIFIER);
    }

    LatLngBounds.Builder builder = new LatLngBounds.Builder();
    LatLngBounds llb;

    private void drawMarkers() {
        Bitmap ob = BitmapFactory.decodeResource(this.getResources(), R.drawable.ic_person_pin_white_36dp);
        Bitmap obm = Bitmap.createBitmap(ob.getWidth(), ob.getHeight(), ob.getConfig());
        Canvas canvas;
        Paint paint;
        ob = BitmapFactory.decodeResource(this.getResources(), R.drawable.ic_place_white_36dp);
        obm = Bitmap.createBitmap(ob.getWidth(), ob.getHeight(), ob.getConfig());

        canvas = new Canvas(obm);
        paint = new Paint();
        paint.setColorFilter(new PorterDuffColorFilter(getResources().getColor(R.color.primary_dark), PorterDuff.Mode.SRC_ATOP));
        canvas.drawBitmap(ob, 0f, 0f, paint);

        markerMap = new HashMap<>();
        markers = new ArrayList<>();
        for (int i = 0; i < ADManager.getInstance().getAdList().size(); i++) {
            AD ad = ADManager.getInstance().getAdList().get(i);
            Marker marker = mMap.addMarker(new MarkerOptions().icon(BitmapDescriptorFactory.fromBitmap(obm)).position(ad.getADLatLng()).title(ad.getProductName()).snippet(ad.getCompanyName()+"\t\t₹"+ad.getTotalReward()));
            ad.setLocationMarker(marker);
            builder.include(ad.getADLatLng());
            markerMap.put(marker.getId(), i);
            markers.add(marker);
            //Geofence geofence = createGeofence(String.valueOf(ad.getUid()), marker.getPosition(), ad.getCoverageRadius() );
            //GeofencingRequest geofenceRequest = createGeofenceRequest( geofence );
            //addGeofence( geofenceRequest );
        }
        if(currentLocation !=null) {
            builder.include(new LatLng(currentLocation.getLatitude(), currentLocation.getLongitude()));
        }try {

            llb = builder.build();
            mMap.animateCamera(CameraUpdateFactory.newLatLngBounds(llb, 600, 600, 0));
        }catch (Exception e){
            e.printStackTrace();
        }
        /*
        Bitmap obi = BitmapFactory.decodeResource(this.getResources(), R.drawable.ic_person_pin_white_36dp);
        Bitmap obmi = Bitmap.createBitmap(ob.getWidth(), ob.getHeight(), ob.getConfig());
        Canvas canvasi;
        Paint painti;
        obi = BitmapFactory.decodeResource(this.getResources(), R.drawable.ic_place_white_36dp);
        obmi = Bitmap.createBitmap(ob.getWidth(), ob.getHeight(), ob.getConfig());

        canvasi = new Canvas(obmi);
        painti = new Paint();
        painti.setColorFilter(new PorterDuffColorFilter(getResources().getColor(R.color.redprimary), PorterDuff.Mode.SRC_ATOP));
        canvasi.drawBitmap(obi, 0f, 0f, paint);

        markerMapi = new HashMap<>();
        markersi = new ArrayList<>();
        for (int i = 0; i < BankManager.getInstance().getAdList().size(); i++) {
            AD ad = ADManager.getInstance().getAdList().get(i);
            Marker markeri = mMap.addMarker(new MarkerOptions().icon(BitmapDescriptorFactory.fromBitmap(obmi)).position(ad.getADLatLng()).title(ad.getProductName()).snippet(ad.getCompanyName()+"\t\t₹"+ad.getTotalReward()));
            ad.setLocationMarker(markeri);
            builder.include(ad.getADLatLng());
            markerMap.put(marker.getId(), i);
            markers.add(marker);
            //Geofence geofence = createGeofence(String.valueOf(ad.getUid()), marker.getPosition(), ad.getCoverageRadius() );
            //GeofencingRequest geofenceRequest = createGeofenceRequest( geofence );
            //addGeofence( geofenceRequest );
        }
        if(currentLocation !=null) {
            builder.include(new LatLng(currentLocation.getLatitude(), currentLocation.getLongitude()));
        }try {

            llb = builder.build();
            mMap.animateCamera(CameraUpdateFactory.newLatLngBounds(llb, 600, 600, 0));
        }catch (Exception e){
            e.printStackTrace();
        }

         */

    }

    /*
        private void initADs() {
            adList = new ArrayList<>();
            if(AD.count(AD.class)>0){
                adList.addAll(AD.listAll(AD.class));
            }else {
                AD ad1 = new AD(0, "LG Nexus 5X", "http://cdn01.androidauthority.net/wp-content/uploads/2015/10/LG-Nexus-5X-Unboxing-22-840x473.jpg",
                        "http://core0.staticworld.net/images/article/2015/11/lg-logo-100629042-primary.idge.png","LG", 20, 30, 100, 28.5500616,77.1262228);
                AD ad2 = new AD(1, "Volkswagen Vento", "http://www.carblogindia.com/wp-content/uploads/2016/09/volkswagen-vento-official-image-front-angle-720x540.jpg",
                        "http://seeklogo.com/images/V/Volkswagen-logo-9A1203CE20-seeklogo.com.png","Volkswagen", 30, 40, 100, 28.55535466,77.12986874);
                AD ad3 = new AD(2, "Canon Camera", "https://s-media-cache-ak0.pinimg.com/736x/d1/29/47/d12947bb6c397193c91383470c405587.jpg",
                        "https://static4.pagesjaunes.fr/media/cviv/06113272_NV_0001_picto_02.png","Canon", 10, 50, 100, 28.5597334,77.12123568);
                AD ad4 = new AD(3, "Apple Macbook Pro", "http://img.staticmacg.com/2013/11/macgpic-1383660167-19683097179463-sc-op.jpg",
                        "https://image.freepik.com/free-icon/apple-logo_318-40184.jpg","Apple", 25, 60, 100, 28.5553450,77.12098345);
                AD ad5 = new AD(4, "Yamaha R15 V3", "https://www.motorbeam.com/wp-content/uploads/2014-Yamaha-YZFR125-Headlights.jpg",
                        "https://s-media-cache-ak0.pinimg.com/originals/a2/8a/f3/a28af38b88b35fc1f44038720c1eb816.jpg","Yamaha", 35, 50, 100, 28.551242,77.1231085);
                adList.add(ad1);
                adList.add(ad2);
                adList.add(ad3);
                adList.add(ad4);
                adList.add(ad5);
                AD.saveInTx(ad1,ad2,ad3,ad4,ad5);

                Question q1 = new Question(0,"Some random question 1 about product?","option 1,option 2,option 3,option 4","option 2",0);
                Question q2 = new Question(1,"Some random question 2 about product?","option 1,option 2,option 3,option 4","option 2",0);
                Question q3 = new Question(2,"Some random question 3 about product?","option 1,option 2,option 3,option 4","option 2",0);
                Question q4 = new Question(3,"Some random question 1 about product?","option 1,option 2,option 3,option 4","option 2",1);
                Question q5 = new Question(4,"Some random question 2 about product?","option 1,option 2,option 3,option 4","option 2",1);
                Question q6 = new Question(5,"Some random question 3 about product?","option 1,option 2,option 3,option 4","option 2",1);
                Question q7 = new Question(6,"Some random question 1 about product?","option 1,option 2,option 3,option 4","option 2",2);
                Question q8 = new Question(7,"Some random question 2 about product?","option 1,option 2,option 3,option 4","option 2",2);
                Question q9 = new Question(8,"Some random question 3 about product?","option 1,option 2,option 3,option 4","option 2",2);
                Question q10 = new Question(9,"Some random question 1 about product?","option 1,option 2,option 3,option 4","option 2",3);
                Question q11 = new Question(10,"Some random question 2 about product?","option 1,option 2,option 3,option 4","option 2",3);
                Question q12 = new Question(11,"Some random question 3 about product?","option 1,option 2,option 3,option 4","option 2",3);
                Question q13 = new Question(12,"Some random question 1 about product?","option 1,option 2,option 3,option 4","option 2",4);
                Question q14 = new Question(13,"Some random question 2 about product?","option 1,option 2,option 3,option 4","option 2",4);
                Question q15 = new Question(14,"Some random question 3 about product?","option 1,option 2,option 3,option 4","option 2",4);
                Question.saveInTx(q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15);
            }
        }*/
    @Override
    public void onCardItemInteraction(int position) {
        ADDetailFragment myf = ADDetailFragment.newInstance(ADManager.getInstance().getAdList().get(position).getUid(), false);
        FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
        transaction.replace(R.id.fl_maps_adDetail, myf);
        transaction.addToBackStack(null);
        transaction.commit();
    }

    public void showPromotion() {
        ADDetailFragment myf = ADDetailFragment.newInstance(3, true);
        FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
        transaction.replace(R.id.fl_maps_adDetail, myf);
        transaction.addToBackStack(null);
        transaction.commit();
    }

    private Location currentLocation;

    @Override
    protected void onResume() {
        super.onResume();
        BApplication.getInstance().checkUserLoggedIn(this);
        BApplication.getInstance().addUIListener(OnLocationChangedListener.class, this);
        BApplication.getInstance().addUIListener(OnADsChangedListener.class, this);
        BApplication.getInstance().addUIListener(OnLocationTypeChangedListener.class, this);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        BApplication.getInstance().removeUIListener(OnLocationChangedListener.class, this);
        BApplication.getInstance().removeUIListener(OnADsChangedListener.class, this);
        BApplication.getInstance().removeUIListener(OnLocationTypeChangedListener.class, this);
    }

    private static final int MY_PERMISSIONS_LOCATION = 103;

    private void checkPermissions() {
        // location
        if (ContextCompat.checkSelfPermission(this,
                ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this,
                    new String[]{ACCESS_FINE_LOCATION},
                    MY_PERMISSIONS_LOCATION);
        } else {
            checkForLocationSettings();
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String permissions[], int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSIONS_LOCATION: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    // permission was granted, yay! Do the
                    // contacts-related task you need to do.
                    checkForLocationSettings();

                } else {
                    Toast.makeText(MapsActivity.this, "You need to grant Location permission!", Toast.LENGTH_LONG).show();
                    finish();
                    // permission denied, boo! Disable the
                    // functionality that depends on this permission.
                }
                return;
            }

            // other 'case' lines to check for other
            // permissions this app might request
        }
    }

    @Override
    public void onLocationChanged(Location location) {
        if (DeviceLocationService.isBetterLocation(location, currentLocation)) {
            currentLocation = location;
            Log.d("Location :", currentLocation.toString());
            updateMapView();

        }
        //updateADsOnMap();
    }

    private void updateADsOnMap() {
        fetchADs();
    }

    private void updateMyLocationOnMap() {
        if(currentLocation==null)
            return;
        LatLng myLatLng = new LatLng(currentLocation.getLatitude(), currentLocation.getLongitude());
        Bitmap ob = BitmapFactory.decodeResource(this.getResources(), R.drawable.ic_person_pin_white_36dp);
        Bitmap obm = Bitmap.createBitmap(ob.getWidth(), ob.getHeight(), ob.getConfig());
        Canvas canvas = new Canvas(obm);
        Paint paint = new Paint();
        paint.setColorFilter(new PorterDuffColorFilter(getResources().getColor(R.color.flat_blue), PorterDuff.Mode.SRC_ATOP));
        canvas.drawBitmap(ob, 0f, 0f, paint);
        myLocationMarker = mMap.addMarker(new MarkerOptions().icon(BitmapDescriptorFactory.fromBitmap(obm)).position(myLatLng).title("I'm here!"));
        mMap.moveCamera(CameraUpdateFactory.newLatLng(myLatLng));
    }

    @Override
    public void onADDetailFragmentInteraction(int i) {
        switch (i) {
            case 0: { // close ad detail
                FragmentManager fm = getSupportFragmentManager();
                if (fm.getBackStackEntryCount() > 0) {
                    fm.popBackStack();
                }
                break;
            }
            case 1: { // show promotion
                FragmentManager fm = getSupportFragmentManager();
                if (fm.getBackStackEntryCount() > 0) {
                    fm.popBackStack();
                }
                vp_ads.setCurrentItem(3, true);
                break;
            }
        }
    }

    protected static final int REQUEST_CHECK_SETTINGS = 0x1;

    GoogleApiClient mGoogleApiClient;
    LocationSettingsRequest.Builder lsrBuilder;

    public void createLocationSettingObejcts() {
        Log.d("settingsRequest", "called");
        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .addApi(LocationServices.API)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(this).build();
        mGoogleApiClient.connect();
        LocationRequest locationRequest = LocationRequest.create();
        locationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        locationRequest.setInterval(30 * 1000);
        locationRequest.setFastestInterval(5 * 1000);
        lsrBuilder = new LocationSettingsRequest.Builder()
                .addLocationRequest(locationRequest);
        lsrBuilder.setAlwaysShow(true); //this is the key ingredient

    }

    private void checkForLocationSettings() {

        PendingResult<LocationSettingsResult> result =
                LocationServices.SettingsApi.checkLocationSettings(mGoogleApiClient, lsrBuilder.build());
        result.setResultCallback(new ResultCallback<LocationSettingsResult>() {
            @Override
            public void onResult(LocationSettingsResult result) {
                final Status status = result.getStatus();
                final LocationSettingsStates state = result.getLocationSettingsStates();
                switch (status.getStatusCode()) {
                    case LocationSettingsStatusCodes.SUCCESS:
                        Intent intent = new Intent("com.snq.nearbucks.locationsettingschanged");
                        sendBroadcast(intent);
                        break;
                    case LocationSettingsStatusCodes.RESOLUTION_REQUIRED:
                        // Location settings are not satisfied. But could be fixed by showing the user
                        // a dialog.
                        try {
                            // Show the dialog by calling startResolutionForResult(),
                            // and check the result in onActivityResult().
                            status.startResolutionForResult(MapsActivity.this, REQUEST_CHECK_SETTINGS);
                        } catch (IntentSender.SendIntentException e) {
                            // Ignore the error.
                        }
                        break;
                    case LocationSettingsStatusCodes.SETTINGS_CHANGE_UNAVAILABLE:
                        // Location settings are not satisfied. However, we have no way to fix the
                        // settings so we won't show the dialog.
                        break;
                }
            }
        });
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        switch (requestCode) {
// Check for the integer request code originally supplied to startResolutionForResult().
            case REQUEST_CHECK_SETTINGS:
                switch (resultCode) {
                    case Activity.RESULT_OK:
                        Intent intent = new Intent("com.snq.nearbucks.locationsettingschanged");
                        sendBroadcast(intent);
                        break;
                    case Activity.RESULT_CANCELED:
                        checkForLocationSettings();
                        break;
                }
                break;
        }
    }

    @Override
    public void onConnected(@Nullable Bundle bundle) {

    }

    @Override
    public void onConnectionSuspended(int i) {

    }

    @Override
    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {

    }

    @Override
    public void onResult(@NonNull Status status) {

    }

    @Override
    public void onADsChanged() {
        updateMapView();
    }

    private void updateMapView(){
        mMap.clear();
        updateMyLocationOnMap();
        mapResidenceVPAdapter.update();
        drawMarkers();
    }

    @Override
    public void onLocationTypeChanged() {
        if(NBManager.getInstance().getUserLocationType()==1){
            currentLocation = null;
            tv_maps_currentLocation.setText(NBManager.getInstance().getUserSelectedState());
        }else{
            tv_maps_currentLocation.setText("My Location");
        }
    }
}
