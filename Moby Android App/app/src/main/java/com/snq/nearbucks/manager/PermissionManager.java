package com.snq.nearbucks.manager;

import android.content.Context;

/**
 * Created by rahul on 04-07-2016.
 */
public class PermissionManager{


    private static PermissionManager instance;
    public static PermissionManager getInstance(){
        if(instance==null){
            instance = new PermissionManager();
        }
        return instance;
    }

    private PermissionManager() {
    }

    public void requestLocationPermission(Context context){

    }
}
