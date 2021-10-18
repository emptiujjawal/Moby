package com.snq.nearbucks.listener;

import com.google.android.gms.common.api.Status;

/**
 * Created by rahul on 4/1/17.
 */
public interface OnLocationResolutionRequiredListener extends BaseUIListener {

    /**
     * Location changed.
     *
     * @param location
     * @param status
     */
    void onLocationResolutionRequired(Status status);
}
