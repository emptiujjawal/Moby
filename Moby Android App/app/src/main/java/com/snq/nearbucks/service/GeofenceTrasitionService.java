package com.snq.nearbucks.service;

import android.app.IntentService;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.graphics.BitmapFactory;
import android.support.v4.app.NotificationCompat;
import android.util.Log;

import com.google.android.gms.location.Geofence;
import com.google.android.gms.location.GeofenceStatusCodes;
import com.google.android.gms.location.GeofencingEvent;
import com.snq.nearbucks.R;
import com.snq.nearbucks.activity.MapsActivity;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.listener.OnGeofenceTriggeredListener;
import com.snq.nearbucks.listener.OnLocationChangedListener;
import com.snq.nearbucks.manager.ADManager;
import com.snq.nearbucks.object.AD;
import com.snq.nearbucks.utils.NotificationID;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

/**
 * Created by rahul on 5/26/17.
 */

public class GeofenceTrasitionService extends IntentService {

    private static final String TAG = GeofenceTrasitionService.class.getSimpleName();
    public static final int GEOFENCE_NOTIFICATION_ID = 0;
    public GeofenceTrasitionService() {
        super(TAG);
    }

    @Override
    protected void onHandleIntent(Intent intent) {
        // Retrieve the Geofencing intent
        GeofencingEvent geofencingEvent = GeofencingEvent.fromIntent(intent);

        // Handling errors
        if ( geofencingEvent.hasError() ) {
            String errorMsg = getErrorString(geofencingEvent.getErrorCode() );
            Log.e( TAG, errorMsg );
            return;
        }

        // Retrieve GeofenceTrasition
        int geoFenceTransition = geofencingEvent.getGeofenceTransition();
        // Check if the transition type
        if ( geoFenceTransition == Geofence.GEOFENCE_TRANSITION_ENTER) {
            // Get the geofence that were triggered
            final List<Geofence> triggeringGeofences = geofencingEvent.getTriggeringGeofences();
            // Create a detail message with Geofences received
            //String geofenceTransitionDetails = getGeofenceTrasitionDetails(geoFenceTransition, triggeringGeofences );
            String notificationTitle = getTitle(geoFenceTransition, triggeringGeofences );
            String notificationContent = getContent(triggeringGeofences );
            AD ad = null;
            if(triggeringGeofences.size()==1){
                ad = ADManager.getInstance().getADByUID(Long.parseLong(triggeringGeofences.get(0).getRequestId()));
                // Send notification details as a String
                if(ADManager.getInstance().isAdNotified(ad.getUid())) {
                    return;
                }else{
                    ADManager.getInstance().addToNotifiedAds(ad.getUid());
                }
            }

            // Send notification details as a String
                sendNotification(ad, notificationTitle, notificationContent);

            BApplication.getInstance().runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    for (OnGeofenceTriggeredListener listener : BApplication.getInstance().getUIListeners(OnGeofenceTriggeredListener.class)) {
                        listener.OnGeofenceTriggered(triggeringGeofences);
                    }
                }
            });
        }
    }
    // Create a detail message with Geofences received
    private String getTitle(int geoFenceTransition, List<Geofence> triggeringGeofences) {
        // get the ID of each geofence triggered
        ArrayList<String> triggeringGeofencesList = new ArrayList<>();
        if(triggeringGeofences.size()>1){
            return triggeringGeofences.size()+" nearby offers found!";
        }else{
            return ADManager.getInstance().getADByUID(Long.parseLong(triggeringGeofences.get(0).getRequestId())).getProductName();
        }
    }
    // Create a detail message with Geofences received
    private String getContent(List<Geofence> triggeringGeofences) {
        // get the ID of each geofence triggered
        ArrayList<String> triggeringGeofencesList = new ArrayList<>();
        if(triggeringGeofences.size()>1){
            return "Tap to view";
        }else{
            return "Earn Rs. "+ADManager.getInstance().getADByUID(Long.parseLong(triggeringGeofences.get(0).getRequestId())).getTotalReward();
        }
    }

    // Create a detail message with Geofences received
    private String getGeofenceTrasitionDetails(int geoFenceTransition, List<Geofence> triggeringGeofences) {
        // get the ID of each geofence triggered
        ArrayList<String> triggeringGeofencesList = new ArrayList<>();
        if(triggeringGeofences.size()>1){
            return triggeringGeofences.size()+" nearby offers found!";
        }else{
            return ADManager.getInstance().getADByUID(Long.parseLong(triggeringGeofences.get(0).getRequestId())).getProductName();
        }
/*
        String status = null;
        if ( geoFenceTransition == Geofence.GEOFENCE_TRANSITION_ENTER )
            status = "Entering ";
        else if ( geoFenceTransition == Geofence.GEOFENCE_TRANSITION_EXIT )
            status = "Exiting ";
        return status + TextUtils.join( ", ", triggeringGeofencesList);*/
    }

    // Send a notification
    private void sendNotification(AD ad, String notificationTitle, String notificationContent) {
        Log.i(TAG, "sendNotification: " + notificationTitle );
        // Intent to start the main Activity
        Intent notificationIntent = new Intent(BApplication.getInstance(), MapsActivity.class);
        if(ad!=null) {
            notificationIntent.putExtra("adid", ad.getUid());
        }
        PendingIntent resultPendingIntent =
                PendingIntent.getActivity(
                        this,
                        0,
                        notificationIntent,
                        PendingIntent.FLAG_CANCEL_CURRENT
                );

        // Creating and sending Notification
        NotificationManager notificatioMng =
                (NotificationManager) getSystemService( Context.NOTIFICATION_SERVICE );
        notificatioMng.notify(
                NotificationID.getID(),
                createNotification(notificationTitle,notificationContent, resultPendingIntent));
    }

    // Create a notification
    private Notification createNotification(String notificationTitle, String notificationContent, PendingIntent notificationPendingIntent) {
        NotificationCompat.Builder notificationBuilder = new NotificationCompat.Builder(this);
        notificationBuilder
                .setLargeIcon(BitmapFactory.decodeResource(getResources(), R.drawable.moby1))
                .setSmallIcon(R.drawable.babywhale)
                //.setColor(Color.RED)
                .setContentTitle(notificationTitle)
                .setContentText(notificationContent)
                .setContentIntent(notificationPendingIntent)
                .setDefaults(Notification.DEFAULT_LIGHTS | Notification.DEFAULT_VIBRATE | Notification.DEFAULT_SOUND)
                .setAutoCancel(true);
        return notificationBuilder.build();
    }

    // Handle errors
    private static String getErrorString(int errorCode) {
        switch (errorCode) {
            case GeofenceStatusCodes.GEOFENCE_NOT_AVAILABLE:
                return "GeoFence not available";
            case GeofenceStatusCodes.GEOFENCE_TOO_MANY_GEOFENCES:
                return "Too many GeoFences";
            case GeofenceStatusCodes.GEOFENCE_TOO_MANY_PENDING_INTENTS:
                return "Too many pending intents";
            default:
                return "Unknown error.";
        }
    }
}