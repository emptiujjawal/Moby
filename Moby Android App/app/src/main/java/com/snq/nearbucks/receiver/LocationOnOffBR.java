package com.snq.nearbucks.receiver;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.location.LocationManager;

import com.snq.nearbucks.service.DeviceLocationService;


/**
 * Created by rahul on 16-07-2016.
 */
public class LocationOnOffBR extends BroadcastReceiver {

    LocationManager lm;
    @Override
    public void onReceive(Context context, Intent intent) {
        if (intent.getAction().matches("android.location.PROVIDERS_CHANGED")||intent.getAction().matches("com.snq.nearbucks.locationsettingschanged")) {
            /*Toast.makeText(context, "in android.location.PROVIDERS_CHANGED",
                    Toast.LENGTH_SHORT).show();*/
            lm = (LocationManager)context.getSystemService(Context.LOCATION_SERVICE);
            if(lm.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
                //Log.d("location", "on");
                Intent pushIntent = new Intent(context, DeviceLocationService.class);
                context.startService(pushIntent);
            }else{
                //Log.d("location", "off");
                Intent pushIntent = new Intent(context, DeviceLocationService.class);
                context.stopService(pushIntent);
            }
        }
    }
}