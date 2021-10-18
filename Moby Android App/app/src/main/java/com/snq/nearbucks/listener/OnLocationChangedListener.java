package com.snq.nearbucks.listener;

import android.location.Location;

/**
 * Created by rahul on 4/1/17.
 */
public interface OnLocationChangedListener extends BaseUIListener {

    /**
     * Location changed.
     *
     * @param location
     */
    void onLocationChanged(Location location);
}
