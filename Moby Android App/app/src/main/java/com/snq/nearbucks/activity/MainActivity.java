package com.snq.nearbucks.activity;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.PorterDuff;
import android.graphics.PorterDuffColorFilter;
import android.location.Location;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.view.ViewPager;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.ImageView;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.snq.nearbucks.R;
import com.snq.nearbucks.adapter.MapADVPAdapter;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.fragment.ADsFragment;
import com.snq.nearbucks.fragment.DrawerFragment;
import com.snq.nearbucks.fragment.StoresFragment;
import com.snq.nearbucks.listener.OnLocationChangedListener;
import com.snq.nearbucks.object.AD;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

import static com.snq.nearbucks.utils.CommonUtils.dp2px;

public class MainActivity extends AppCompatActivity implements DrawerFragment.FragmentDrawerListener, OnMapReadyCallback, OnLocationChangedListener,StoresFragment.OnFragmentInteractionListener,ADsFragment.OnFragmentInteractionListener{

    @InjectView(R.id.toolbar)
    Toolbar toolbar;
    @InjectView(R.id.fl_main)
    FrameLayout fl_main;
    @InjectView(R.id.fab_main_toggleView)
    ImageView fab_toggleView;
    @InjectView(R.id.vp_ads)
    ViewPager vp_ads;

    List<AD> adList;
    HashMap<String,Integer> markerMap;


    private GoogleMap mMap;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        vp_ads.setClipToPadding(false);
        vp_ads.setPageMargin(dp2px(this, 15));
        initADs();
        MapADVPAdapter mapResidenceVPAdapter = new MapADVPAdapter(this, adList);
        vp_ads.setAdapter(mapResidenceVPAdapter);
        vp_ads.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {
                mMap.animateCamera(CameraUpdateFactory.newLatLng(adList.get(position).getADLatLng()));
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });
        FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
        ADsFragment adsFragment = new ADsFragment();
        fragmentTransaction.replace(R.id.fl_main, adsFragment, "ADsFragment");
        fragmentTransaction.commit();
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map_main);
        mapFragment.getMapAsync(this);
        fab_toggleView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                toggleView();
            }
        });
        //setUpBubble();
        //setUpDrawer();

    }

    private void initADs() {
        adList = new ArrayList<>();
/*        adList.add(new AD("LG Nexus 5X",R.drawable.nexus,R.drawable.lg,30,50,2.5,(new LatLng(28.5002321,77.169194))));
        adList.add(new AD("Volkswagen Vento",R.drawable.vento,R.drawable.volks,50,80,4,(new LatLng(28.4972475,77.1686121))));
        adList.add(new AD("Canon Camera",R.drawable.camera,R.drawable.canon,20,60,3.7,(new LatLng(28.498108,77.1653899))));
        adList.add(new AD("Apple Macbook Pro",R.drawable.mac,R.drawable.apple,35,80,1.3,(new LatLng(28.4965558,77.1656651))));
    */}

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }

    private DrawerFragment drawerFragment;
    private void setUpDrawer() {
        drawerFragment = (DrawerFragment)
                getSupportFragmentManager().findFragmentById(R.id.fragment_navigation_drawer);
        drawerFragment.setUp(R.id.fragment_navigation_drawer, (DrawerLayout) findViewById(R.id.drawer_layout), toolbar);
        drawerFragment.setDrawerListener(this);
    }
    private void toggleView() {
        if(fl_main.getVisibility()==View.VISIBLE){
            fl_main.setVisibility(View.GONE);
            fab_toggleView.setImageResource(R.drawable.ic_format_list_bulleted_white_48dp);
/*            FrameLayout.LayoutParams params = new FrameLayout.LayoutParams(FrameLayout.LayoutParams.WRAP_CONTENT, FrameLayout.LayoutParams.FILL_PARENT);
            params.gravity = (Gravity.TOP|Gravity.RIGHT);
            params.setMargins(dp2px(this,20),dp2px(this,20),dp2px(this,20),dp2px(this,20));
            fab_toggleView.setLayoutParams(params);*/
        }else{
            fl_main.setVisibility(View.VISIBLE);
            fab_toggleView.setImageResource(R.drawable.ic_map_white_48dp);
/*            FrameLayout.LayoutParams params = new FrameLayout.LayoutParams(FrameLayout.LayoutParams.WRAP_CONTENT, FrameLayout.LayoutParams.FILL_PARENT);
            params.gravity = (Gravity.BOTTOM|Gravity.RIGHT);
            params.setMargins(dp2px(this,20),dp2px(this,20),dp2px(this,20),dp2px(this,20));
            fab_toggleView.setLayoutParams(params);*/
        }
    }

    @Override
    protected void onResume() {
        super.onResume();
        BApplication.getInstance().addUIListener(OnLocationChangedListener.class,this);
    }

    @Override
    protected void onPause() {
        super.onPause();
        BApplication.getInstance().removeUIListener(OnLocationChangedListener.class,this);
    }

    @Override
    public void onLocationChanged(Location location) {

    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
        markerMap = new HashMap<>();
        mMap.getUiSettings().setMapToolbarEnabled(false);
        mMap.setOnMarkerClickListener(new GoogleMap.OnMarkerClickListener() {
            @Override
            public boolean onMarkerClick(Marker marker) {
                if(markerMap.containsKey(marker.getId())){
                    vp_ads.setCurrentItem(markerMap.get(marker.getId()),true);
                }
                return false;
            }
        });

        LatLng loc = new LatLng(28.496657,77.1648463);
        CameraPosition cameraPosition = new CameraPosition.Builder().
                target(loc).
                tilt(60).
                zoom(16).
                bearing(0).
                build();
        Bitmap ob = BitmapFactory.decodeResource(this.getResources(),R.drawable.ic_person_pin_white_36dp);
        Bitmap obm = Bitmap.createBitmap(ob.getWidth(), ob.getHeight(), ob.getConfig());
        Canvas canvas = new Canvas(obm);
        Paint paint = new Paint();
        paint.setColorFilter(new PorterDuffColorFilter(getResources().getColor(R.color.accent), PorterDuff.Mode.SRC_ATOP));
        canvas.drawBitmap(ob, 0f, 0f, paint);
        mMap.addMarker(new MarkerOptions().icon(BitmapDescriptorFactory.fromBitmap(obm)).position(loc).title("I'm here!"));

        ob = BitmapFactory.decodeResource(this.getResources(),R.drawable.ic_place_white_36dp);
        obm = Bitmap.createBitmap(ob.getWidth(), ob.getHeight(), ob.getConfig());

        canvas = new Canvas(obm);
        paint = new Paint();
        paint.setColorFilter(new PorterDuffColorFilter(getResources().getColor(R.color.primary_dark), PorterDuff.Mode.SRC_ATOP));
        canvas.drawBitmap(ob, 0f, 0f, paint);
        drawMarkers(obm);
        mMap.moveCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));
    }

    private void drawMarkers(Bitmap obm) {
        for(int i=0;i<adList.size();i++){
            AD ad = adList.get(i);
            Marker marker = mMap.addMarker(new MarkerOptions().icon(BitmapDescriptorFactory.fromBitmap(obm)).position(ad.getADLatLng()));
            //ad.setLocationMarker(marker);
            markerMap.put(marker.getId(),i);
        }
    }


    @Override
    public void onFragmentInteraction(Uri uri) {

    }

    @Override
    public void onDrawerItemSelected(View view, int position) {

    }
}
