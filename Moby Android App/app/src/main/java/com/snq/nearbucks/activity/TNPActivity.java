package com.snq.nearbucks.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.google.firebase.auth.FirebaseAuth;
import com.snq.nearbucks.R;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.utils.URL;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import butterknife.ButterKnife;
import butterknife.InjectView;

import static com.snq.nearbucks.R.id.lv_activity;
import static com.snq.nearbucks.R.id.tv_emptyView_title;
import static com.snq.nearbucks.R.id.tv_tnp_messageCount;
import static com.snq.nearbucks.R.id.tv_tnp_moneyCount;

public class TNPActivity extends AppCompatActivity {

    @InjectView(R.id.toolbar)
    Toolbar toolbar;
    @InjectView(R.id.ll_dashboard_profile)
    LinearLayout ll_dashboard_profile;
    @InjectView(R.id.tv_tnp_profileStatus)
    TextView tv_tnp_profileStatus;
    @InjectView(R.id.ll_dashboard_message)
    LinearLayout ll_dashboard_message;
    @InjectView(R.id.tv_tnp_messageCount)
    TextView tv_tnp_messageCount;
    @InjectView(R.id.ll_dashboard_wallet)
    LinearLayout ll_dashboard_wallet;
    @InjectView(R.id.tv_tnp_moneyCount)
    TextView tv_tnp_moneyCount;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tnp);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("My Dashboard");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        ll_dashboard_profile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(TNPActivity.this,ProfileActivity.class));
            }
        });
        ll_dashboard_message.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(TNPActivity.this,NotificationsActivity.class));
            }
        });
        ll_dashboard_wallet.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(TNPActivity.this,WalletActivity.class));
            }
        });
        getStatus();
    }

    private void getStatus() {
        PBManager.getInstance().showPB(TNPActivity.this, "Loading...", false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        Log.d(LoginActivity.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        try {
                            JSONObject res = new JSONObject(response);
                            boolean error = res.getBoolean("error");
                            if(error){
                                String message = res.getString("message");
                                Toast.makeText(TNPActivity.this, message, Toast.LENGTH_LONG).show();
                                return;
                            }
                            JSONObject status = res.getJSONObject("status");
                            String wallet_amount = status.getString("wallet_amount");
                            String profile_percentage = status.getInt("profile_percentage")+"";
                            String new_message = status.getInt("new_message")+"";

                            tv_tnp_messageCount.setText(new_message);
                            tv_tnp_profileStatus.setText(profile_percentage+"%");
                            tv_tnp_moneyCount.setText(wallet_amount);

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(LoginActivity.class.getName(), "Error: " + error.getMessage());
                Toast.makeText(TNPActivity.this,"Error!",Toast.LENGTH_SHORT).show();
                PBManager.getInstance().cancelPB();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(URL.REQUEST_IDENTIFIER, URL.GET_STATUS_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                return params;
            }

        };

// Adding request to request queue
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.LOGIN_IDENTIFIER);
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.profile_menu, menu);
        menu.findItem(R.id.menu_action_edit).setVisible(false);
        return true;
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                //NavUtils.navigateUpFromSameTask(this);
                return true;
            case R.id.menu_action_logout:
                BApplication.getInstance().logout(this);
                //NavUtils.navigateUpFromSameTask(this);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}
