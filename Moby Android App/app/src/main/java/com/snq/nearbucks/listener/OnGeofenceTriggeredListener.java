package com.snq.nearbucks.listener;

import com.google.android.gms.location.Geofence;

import java.util.List;

/**
 * Created by rahul on 4/1/17.
 */
public interface OnGeofenceTriggeredListener extends BaseUIListener {

    void OnGeofenceTriggered(List<Geofence> geofences);
}
