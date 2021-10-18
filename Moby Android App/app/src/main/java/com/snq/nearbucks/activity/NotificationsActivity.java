package com.snq.nearbucks.activity;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
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
import com.snq.nearbucks.adapter.NotificationAdapter;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.listener.OnADsChangedListener;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.AD;
import com.snq.nearbucks.object.Message;
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

public class NotificationsActivity extends AppCompatActivity {

    @InjectView(R.id.toolbar)
    Toolbar toolbar;
    @InjectView(R.id.lv_notifications)
    ListView lv_notifications;
    @InjectView(R.id.tv_emptyView_title)
    TextView tv_emptyView_title;

    private NotificationAdapter mAdapter;
    public List<Message> messageList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notifications);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("Messages");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        setUpHostelAdapter();
    }
    private void setUpHostelAdapter() {
        messageList = new ArrayList<>();
        mAdapter = new NotificationAdapter(this, messageList);
        //isLoadingMore = true;
        lv_notifications.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
            }
        });
        lv_notifications.setAdapter(mAdapter);
        fetchMessages();
    }

    private void fetchMessages() {

        PBManager.getInstance().showPB(this,"Fetching Messages...", false);
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
                                Toast.makeText(BApplication.getInstance(), message, Toast.LENGTH_LONG).show();
                                lv_notifications.setVisibility(View.GONE);
                                tv_emptyView_title.setVisibility(View.VISIBLE);
                                return;
                            }
                            JSONArray messages= res.getJSONArray("message");
                            updateMessages(messages);
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
                params.put(URL.REQUEST_IDENTIFIER, URL.MESSAGE_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                return params;
            }

        };
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.FETCH_ADS_IDENTIFIER);
    }

    private void updateMessages(JSONArray messages) throws JSONException {
        messageList.clear();
        for(int i =0; i<messages.length();i++){
            JSONObject message = messages.getJSONObject(i);
            Message m = Message.fromJSON(message);
            messageList.add(m);
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
