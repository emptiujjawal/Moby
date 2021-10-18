package com.snq.nearbucks.activity;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.google.firebase.auth.FirebaseAuth;
import com.snq.nearbucks.R;
import com.snq.nearbucks.adapter.TransactionAdapter;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.UserTransaction;
import com.snq.nearbucks.utils.URL;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import butterknife.ButterKnife;
import butterknife.InjectView;

public class WalletActivity extends AppCompatActivity {

    @InjectView(R.id.toolbar)
    Toolbar toolbar;
    @InjectView(R.id.lv_transaction)
    ListView lv_transaction;
    @InjectView(R.id.tv_emptyView_title)
    TextView tv_emptyView_title;
    private TransactionAdapter mAdapter;
    public List<UserTransaction> userTransactionList;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_wallet);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("Wallet Statement");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        setUpAdapter();
    }


    private void setUpAdapter() {
        userTransactionList = new ArrayList<>();
        mAdapter = new TransactionAdapter(this, userTransactionList);
        lv_transaction.setAdapter(mAdapter);
        fetchADs();
    }

    private void fetchADs() {
        PBManager.getInstance().showPB(this,"Fetching Transactions...", false);
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
                                Toast.makeText(WalletActivity.this, message, Toast.LENGTH_LONG).show();
                                return;
                            }
                            JSONObject message = res.getJSONObject("message");
                            JSONArray timeline = message.getJSONArray("timeline");
                            if(timeline.length()>0) {
                                lv_transaction.setVisibility(View.VISIBLE);
                                tv_emptyView_title.setVisibility(View.GONE);
                                updateTimeline(timeline);
                            }else{
                                lv_transaction.setVisibility(View.GONE);
                                tv_emptyView_title.setVisibility(View.VISIBLE);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(LoginActivity.class.getName(), "Error: " + error.getMessage());
                PBManager.getInstance().cancelPB();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(URL.REQUEST_IDENTIFIER, URL.WALLET_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                return params;
            }

        };
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.FETCH_ADS_IDENTIFIER);
    }

    private void updateTimeline(JSONArray timeline) throws JSONException {
        userTransactionList.clear();
        for(int i =0; i<timeline.length();i++){
            JSONObject activity = timeline.getJSONObject(i);
            UserTransaction ut = new UserTransaction();
            ut.setType(activity.getString("transaction_type").equalsIgnoreCase("Debit")?0:1);
            ut.setAdName(activity.getString("ad_name"));
            ut.setAmount(Integer.parseInt(activity.getString("transaction_amount")));
            ut.setDate(activity.getString("timestamp"));
            ut.setAdProductPhotoURL(activity.getString("ad_banner"));
            userTransactionList.add(ut);
        }
        mAdapter.notifyDataSetChanged();
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                //NavUtils.navigateUpFromSameTask(this);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}