package com.snq.nearbucks.activity;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;

import com.snq.nearbucks.config.BApplication;

public class BaseActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        BApplication.getInstance().checkUserLoggedIn(this);
    }
}
