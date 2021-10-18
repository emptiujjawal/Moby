package com.snq.nearbucks.service;

import android.Manifest;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.os.Bundle;
import android.os.IBinder;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.util.Log;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.Geofence;
import com.google.android.gms.location.GeofencingRequest;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.LocationSettingsRequest;
import com.google.android.gms.location.LocationSettingsResult;
import com.google.android.gms.location.LocationSettingsStatusCodes;
import com.google.android.gms.maps.model.LatLng;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.listener.OnADsChangedListener;
import com.snq.nearbucks.listener.OnGeofenceTriggeredListener;
import com.snq.nearbucks.listener.OnLocationChangedListener;
import com.snq.nearbucks.manager.ADManager;
import com.snq.nearbucks.object.AD;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rahul on 16-07-2016.
 */
public class DeviceLocationService extends Service implements
        ResultCallback<LocationSettingsResult>,
        GoogleApiClient.ConnectionCallbacks, GoogleApiClient.OnConnectionFailedListener, OnADsChangedListener, OnGeofenceTriggeredListener {

    private static final long INTERVAL = 1000 * 5;
    private static final long FASTEST_INTERVAL = 1000 * 5;
    public LocationRequest mLocationRequest;
    public GoogleApiClient mGoogleApiClient;
    private Location mLocation;
    private LocationListener locationListener;

    @Override
    public void onCreate() {
        super.onCreate();
        createLocationRelatedObjects();
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        if (mGoogleApiClient != null && mGoogleApiClient.isConnected()) {
            startLocationUpdates();
        }
        BApplication.getInstance().addUIListener(OnADsChangedListener.class, this);
        BApplication.getInstance().addUIListener(OnGeofenceTriggeredListener.class, this);
        return super.onStartCommand(intent, flags, startId);
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        BApplication.getInstance().removeUIListener(OnADsChangedListener.class, this);
        BApplication.getInstance().removeUIListener(OnGeofenceTriggeredListener.class, this);
        removeAllGeofence();
    }

    private void createLocationRelatedObjects() {
        mLocationRequest = new LocationRequest();
        mLocationRequest.setInterval(INTERVAL);
        mLocationRequest.setFastestInterval(FASTEST_INTERVAL);
        mLocationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .addApi(LocationServices.API)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(this)
                .build();
        locationListener = new LocationListener() {
            @Override
            public void onLocationChanged(Location location) {
                if (location == null)
                    return;
                //if(isBetterLocation(location,mLocation)) {
                //removeGeofence();
                mLocation = location;
                BApplication.getInstance().runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        for (OnLocationChangedListener listener : BApplication.getInstance().getUIListeners(OnLocationChangedListener.class)) {
                            listener.onLocationChanged(mLocation);
                        }
                    }
                });
                //}
                //stopLocationUpdates();
                //NoteManager.getInstance().setLocation(mLocation);
                //EventBus.getDefault().post(new Events.OnLocationReceived(mLocation));
                //stopLocationUpdates();
            /*LatLng latLng = new LatLng(mLocation.getLatitude(), mLocation.getLongitude());
            fetchLBS(spinner.getSelectedItemPosition(), latLng);*/
            }
        };
        mGoogleApiClient.connect();
    }

    private static final int TWO_MINUTES = 1000 * 60 * 2;

    /**
     * Determines whether one Location reading is better than the current Location fix
     *
     * @param location            The new Location that you want to evaluate
     * @param currentBestLocation The current Location fix, to which you want to compare the new one
     */
    public static boolean isBetterLocation(Location location, Location currentBestLocation) {
        if (currentBestLocation == null) {
            // A new location is always better than no location
            return true;
        }

        // Check whether the new location fix is newer or older
/*        long timeDelta = location.getTime() - currentBestLocation.getTime();
        boolean isSignificantlyNewer = timeDelta > TWO_MINUTES;
        boolean isSignificantlyOlder = timeDelta < -TWO_MINUTES;
        boolean isNewer = timeDelta > 0;

        // If it's been more than two minutes since the current location, use the new location
        // because the user has likely moved
        if (isSignificantlyNewer) {
            return true;
            // If the new location is more than two minutes older, it must be worse
        } else if (isSignificantlyOlder) {
            return false;
        }*/

        // Check whether the new location fix is more or less accurate
        int accuracyDelta = (int) (location.getAccuracy() - currentBestLocation.getAccuracy());
        boolean isLessAccurate = accuracyDelta > 0;
        boolean isMoreAccurate = accuracyDelta < 0;
        boolean isSignificantlyLessAccurate = accuracyDelta > 200;

        // Check if the old and new location are from the same provider
        boolean isFromSameProvider = isSameProvider(location.getProvider(),
                currentBestLocation.getProvider());

        //Check whether new location is at least 5000m away from the current location
        float distanceInMeters = location.distanceTo(currentBestLocation);
        boolean isPrettyFarAway = distanceInMeters > 10000;

        // Determine location quality using a combination of timeliness and accuracy
        if (isMoreAccurate && isPrettyFarAway) {
            return true;
        } else if (!isLessAccurate && isPrettyFarAway) {
            return true;
        } else if (!isSignificantlyLessAccurate && isFromSameProvider && isPrettyFarAway) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether two providers are the same
     */
    public static boolean isSameProvider(String provider1, String provider2) {
        if (provider1 == null) {
            return provider2 == null;
        }
        return provider1.equals(provider2);
    }


    @Override
    public void onConnected(@Nullable Bundle bundle) {
        buildLocationSettingsRequest();
        checkLocationSettings();
        getLastKnownLocation();
        Log.d("LOC", "Connected... ");
    }

    // Get last known location
    public void getLastKnownLocation() {
        Log.d(TAG, "getLastKnownLocation()");
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        Location lastLocation = LocationServices.FusedLocationApi.getLastLocation(mGoogleApiClient);
        if (lastLocation != null) {
            Log.i(TAG, "LasKnown location. " +
                    "Long: " + lastLocation.getLongitude() +
                    " | Lat: " + lastLocation.getLatitude());
            mLocation = lastLocation;
            BApplication.getInstance().runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    for (OnLocationChangedListener listener : BApplication.getInstance().getUIListeners(OnLocationChangedListener.class)) {
                        listener.onLocationChanged(mLocation);
                    }
                }
            });
        } else {
            Log.w(TAG, "No location retrieved yet");
        }
    }

    protected void checkLocationSettings() {
        PendingResult<LocationSettingsResult> result =
                LocationServices.SettingsApi.checkLocationSettings(
                        mGoogleApiClient,
                        mLocationSettingsRequest
                );
        result.setResultCallback(this);
    }

    protected LocationSettingsRequest mLocationSettingsRequest;
    protected static final int REQUEST_CHECK_SETTINGS = 0x1;

    protected void buildLocationSettingsRequest() {
        LocationSettingsRequest.Builder builder = new LocationSettingsRequest.Builder();
        builder.addLocationRequest(mLocationRequest);
        mLocationSettingsRequest = builder.build();
    }


    @Override
    public void onConnectionSuspended(int i) {
    }

    @Override
    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {
    }

    protected void startLocationUpdates() {
        if (ContextCompat.checkSelfPermission(this,
                Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {
            return;
        }

        //Application.getInstance().showPD(this,"Waiting for location...");
        //Roast.makeText(this, "Waiting for location...");
        LocationServices.FusedLocationApi.requestLocationUpdates(
                mGoogleApiClient, mLocationRequest, locationListener);
        Log.d("LOC", "Location update started ..............: ");
    }

    protected void stopLocationUpdates() {
        LocationServices.FusedLocationApi.removeLocationUpdates(
                mGoogleApiClient, locationListener);
        Log.d("LOC", "Location update stopped .......................");
    }


    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    private static final String TAG = "DeviceLocation";

    @Override
    public void onResult(LocationSettingsResult locationSettingsResult) {

        final Status status = locationSettingsResult.getStatus();
        switch (status.getStatusCode()) {
            case LocationSettingsStatusCodes.SUCCESS:
                Log.i(TAG, "All location settings are satisfied.");
                startLocationUpdates();
                break;
            case LocationSettingsStatusCodes.RESOLUTION_REQUIRED:
                Log.i(TAG, "Location settings are not satisfied. Show the user a dialog to" +
                        "upgrade location settings ");
/*
                try {
                    // Show the dialog by calling startResolutionForResult(), and check the result
                    // in onActivityResult().
                    status.startResolutionForResult(DeviceLocationService.this, REQUEST_CHECK_SETTINGS);
                } catch (IntentSender.SendIntentException e) {
                    Log.i(TAG, "PendingIntent unable to execute request.");
                }*/
                break;
            case LocationSettingsStatusCodes.SETTINGS_CHANGE_UNAVAILABLE:
                //Application.getInstance().pd.dismiss();
                Log.i(TAG, "Location settings are inadequate, and cannot be fixed here. Dialog " +
                        "not created.");
                break;
        }
    }

    @Override
    public void onADsChanged() {
        removeAllGeofence();
        for (int i = 0; i < ADManager.getInstance().getAdList().size(); i++) {
            AD ad = ADManager.getInstance().getAdList().get(i);
            Geofence geofence = createGeofence(String.valueOf(ad.getUid()), ad.getADLatLng(), ad.getCoverageRadius());
            GeofencingRequest geofenceRequest = createGeofenceRequest(geofence);
            addGeofence(geofenceRequest);
        }
    }

    private static final long GEO_DURATION = 60 * 60 * 1000;
    private static final String GEOFENCE_REQ_ID = "My Geofence";
    private static final float GEOFENCE_RADIUS = 500.0f; // in meters

    // Create a Geofence
    private Geofence createGeofence(String ADID, LatLng latLng, float radius) {
        Log.d("GEOFENCE", "createGeofence");
        return new Geofence.Builder()
                .setRequestId(ADID)
                .setCircularRegion(latLng.latitude, latLng.longitude, radius)
                .setExpirationDuration(GEO_DURATION)
                .setTransitionTypes(Geofence.GEOFENCE_TRANSITION_ENTER)
                .build();
    }

    // Create a Geofence Request
    private GeofencingRequest createGeofenceRequest(Geofence geofence) {
        Log.d("GEOFENCE", "createGeofenceRequest");
        return new GeofencingRequest.Builder()
                .setInitialTrigger(GeofencingRequest.INITIAL_TRIGGER_ENTER)
                .addGeofence(geofence)
                .build();
    }

    private PendingIntent geoFencePendingIntent;
    private final int GEOFENCE_REQ_CODE = 0;

    private PendingIntent createGeofencePendingIntent() {
        Log.d("GEOFENCE", "createGeofencePendingIntent");
        if (geoFencePendingIntent != null)
            return geoFencePendingIntent;

        Intent intent = new Intent(this, GeofenceTrasitionService.class);
        geoFencePendingIntent = PendingIntent.getService(
                this, GEOFENCE_REQ_CODE, intent, PendingIntent.FLAG_UPDATE_CURRENT);
        return geoFencePendingIntent;
    }

    // Add the created GeofenceRequest to the device's monitoring list
    private void addGeofence(GeofencingRequest request) {
        Log.d("GEOFENCE", "addGeofence");
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }

        LocationServices.GeofencingApi.addGeofences(
                mGoogleApiClient,
                request,
                createGeofencePendingIntent()
        );
    }

    // remove the created GeofenceRequest from the device's monitoring list
    private void removeAllGeofence() {
        Log.d("GEOFENCE", "removing all");
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        if (mGoogleApiClient == null || geoFencePendingIntent == null)
            return;
        LocationServices.GeofencingApi.removeGeofences(
                mGoogleApiClient, geoFencePendingIntent);
    }

    // remove the created GeofenceRequest from the device's monitoring list
    private void removeGeofences(List<Geofence> geofences) {
        Log.d("GEOFENCE", "removing all");
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }

        try {
            ArrayList<String> geofenceIds = new ArrayList<String>();
            for (Geofence geofence : geofences)
                geofenceIds.add(geofence.getRequestId());

            if (mGoogleApiClient == null || geoFencePendingIntent == null)
                return;
            LocationServices.GeofencingApi.removeGeofences(
                    mGoogleApiClient, geofenceIds).setResultCallback(new ResultCallback<Status>() {

                @Override
                public void onResult(Status status) {
                    if (status.isSuccess())
                        Log.d("Geofence Status:", "removed");
                    else Log.d("Geofence Status:", "remove failed!");
                }
            });
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @Override
    public void OnGeofenceTriggered(List<Geofence> geofences) {
        removeGeofences(geofences);
    }
}
