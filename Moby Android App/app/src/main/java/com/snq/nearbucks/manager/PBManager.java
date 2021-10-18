package com.snq.nearbucks.manager;

import android.app.ProgressDialog;
import android.content.Context;

import com.snq.nearbucks.config.BApplication;

/**
 * Created by rahul on 04-07-2016.
 */
public class PBManager {

    private static PBManager instance;
    public static PBManager getInstance(){
        if(instance==null){
            instance = new PBManager();
        }
        return instance;
    }

    private PBManager() {
    }

    ProgressDialog pd;
    public void showPB(Context context, String message, boolean isCancelable){
        pd = new ProgressDialog(context);
        //pd.setTitle("Please wait...");
        pd.setMessage(message);
        pd.setCancelable(isCancelable);
        pd.setIndeterminate(true);
        pd.show();
    }

    public void cancelPB(){
        if(pd == null)
            return;
        pd.cancel();
    }

    public void showPB(String message, boolean isCancelable) {
        pd = new ProgressDialog(BApplication.getInstance());
        //pd.setTitle("Please wait...");
        pd.setMessage(message);
        pd.setCancelable(isCancelable);
        pd.setIndeterminate(true);
        pd.show();
    }
}
