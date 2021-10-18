package com.snq.nearbucks.activity;

import android.Manifest;
import android.app.Activity;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;


import com.firebase.ui.auth.AuthUI;
import com.firebase.ui.auth.ErrorCodes;
import com.firebase.ui.auth.IdpResponse;
import com.google.firebase.auth.FirebaseAuth;
import com.snq.nearbucks.R;

import java.util.Arrays;

import butterknife.ButterKnife;
import butterknife.InjectView;


public class GetMobileNoActivity extends AppCompatActivity {

    @InjectView(R.id.toolbar)
    public Toolbar toolbar;
    @InjectView(R.id.b_gmn_verifyMobile)
    public Button b_gmn_verifyMobile;
    @InjectView(R.id.b_gmn_paytm)
    public Button b_paytm;
    // Choose an arbitrary request code value
    private static final int RC_SIGN_IN = 123;
    long contactNo;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_get_mobile_no);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        getSupportActionBar().setElevation(0);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setTitle("Mobile Verification");
        checkPermissions();
        b_gmn_verifyMobile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //startActivity(new Intent(GetMobileNoActivity.this,FirebaseAuthActivity.class));
                startActivityForResult(
                        AuthUI.getInstance()
                                .createSignInIntentBuilder()
                                .setAvailableProviders(
                                        Arrays.asList(
                                                new AuthUI.IdpConfig.Builder(AuthUI.PHONE_VERIFICATION_PROVIDER).build()))
                                .build(),
                        RC_SIGN_IN);
            }
        });
        b_paytm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent launchIntent = getPackageManager().getLaunchIntentForPackage("net.one97.paytm");
                if(launchIntent != null){
                    startActivity(launchIntent);
                }
                else{
                    Toast.makeText(GetMobileNoActivity.this,"Please download PayTM App for creating account.",Toast.LENGTH_SHORT).show();
                }

            }
        });
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        // RC_SIGN_IN is the request code you passed into startActivityForResult(...) when starting the sign in flow.
        if (requestCode == RC_SIGN_IN) {
            IdpResponse response = IdpResponse.fromResultIntent(data);

            String phoneNo="";
            if (response != null){
                 phoneNo = response.getPhoneNumber();
            }

            // Successfully signed in
            if (resultCode == RESULT_OK) {Toast.makeText(this, "Mobile no: " + phoneNo + " Verified Successfully", Toast.LENGTH_SHORT).show();
                startActivity(new Intent(this, LoginActivity.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK));
                finish();
                return;
            } else {
                // Sign in failed

                Toast.makeText(this, "Mobile No. Verification Failed!", Toast.LENGTH_SHORT).show();
//                if (response == null) {
//                    // User pressed back button
//                    showSnackbar(R.string.sign_in_cancelled);
//                    return;
//                }
//
//                if (response.getErrorCode() == ErrorCodes.NO_NETWORK) {
//                    showSnackbar(R.string.no_internet_connection);
//                    return;
//                }
//
//                if (response.getErrorCode() == ErrorCodes.UNKNOWN_ERROR) {
//                    showSnackbar(R.string.unknown_error);
//                    return;
//                }
            }

            //showSnackbar(R.string.unknown_sign_in_response);
        }
    }

//    @Override
//    protected void onResume() {
//        super.onResume();
//        if(Digits.getActiveSession()!=null && Digits.isDigitsUser() && Digits.getActiveSession().isValidUser()){
//            setResults();
//        }
//    }

    private void setResults() {
        Intent intent = new Intent();
        setResult(1, intent);
        setResult(Activity.RESULT_OK,intent);
        finish();
    }
    private static final int MY_PERMISSIONS_SMS= 102;
    private void checkPermissions() {
        // location
        if (ContextCompat.checkSelfPermission(this,
                Manifest.permission.RECEIVE_SMS)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this,
                    new String[]{Manifest.permission.RECEIVE_SMS},
                    MY_PERMISSIONS_SMS);
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String permissions[], int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSIONS_SMS: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    // permission was granted, yay! Do the
                    // contacts-related task you need to do.

                } else {
                    Toast.makeText(GetMobileNoActivity.this,"You need to grant READ SMS permission!",Toast.LENGTH_LONG).show();
                    finish();
                    // permission denied, boo! Disable the
                    // functionality that depends on this permission.
                }
                return;
            }

            // other 'case' lines to check for other
            // permissions this app might request
        }
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        switch (item.getItemId()) {
            case android.R.id.home: {
                finish();
                break;
            }
        }
        return super.onOptionsItemSelected(item);
    }
}