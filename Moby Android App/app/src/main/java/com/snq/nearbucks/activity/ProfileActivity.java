package com.snq.nearbucks.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ImageView;
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
import com.snq.nearbucks.listener.OnProfileUpdatedListener;
import com.snq.nearbucks.manager.AccountManager;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.DropDownObject;
import com.snq.nearbucks.object.User;
import com.snq.nearbucks.utils.URL;
import com.squareup.picasso.Picasso;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import butterknife.ButterKnife;
import butterknife.InjectView;

public class ProfileActivity extends AppCompatActivity implements OnProfileUpdatedListener {

    @InjectView(R.id.toolbar)
    Toolbar toolbar;
    @InjectView(R.id.tv_profile_name)
    TextView tv_profile_name;
    @InjectView(R.id.tv_profile_profession)
    TextView tv_profile_profession;
    @InjectView(R.id.tv_profile_salary)
    TextView tv_profile_salary;
    @InjectView(R.id.tv_profile_checkIns)
    TextView tv_profile_checkIns;
    @InjectView(R.id.tv_profile_quizAnswered)
    TextView tv_profile_quizAnswered;
    @InjectView(R.id.tv_profile_email)
    TextView tv_profile_email;
    @InjectView(R.id.tv_profile_contact)
    TextView tv_profile_contact;
    @InjectView(R.id.tv_profile_address)
    TextView tv_profile_address;
    @InjectView(R.id.kbv_profile_coverPic)
    ImageView kbv_profile_coverPic;
    @InjectView(R.id.iv_profile_photo)
    ImageView iv_profile_photo;
    @InjectView(R.id.iv_profile_fbLink)
    ImageView iv_profile_fbLink;
    @InjectView(R.id.iv_profile_twitterLink)
    ImageView iv_profile_twitterLink;
    @InjectView(R.id.iv_profile_gplusLink)
    ImageView iv_profile_gplusLink;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("Profile");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        PBManager.getInstance().showPB(this,"Fetching Profile...", false);
        fetchProfile();
    }

    private void fetchProfile() {
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
                                Toast.makeText(ProfileActivity.this, message, Toast.LENGTH_LONG).show();
                                return;
                            }
                            JSONObject message = res.getJSONObject("message");
                            updateUser(message);
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
                params.put(URL.REQUEST_IDENTIFIER, URL.PROFILE_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                return params;
            }

        };
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.PROFILE_IDENTIFIER);
    }

    private void updateUser(JSONObject user_detail) throws JSONException {
        User user = new User();
        user.setName(user_detail.getString("user_name"));
        user.setEmail(user_detail.getString("user_email"));
        user.setUserContact(user_detail.getString("user_contact"));
        user.setGender(user_detail.getString("user_gender"));
        user.setAddress(user_detail.getString("user_address"));
        user.setCity(user_detail.getString("user_city"));
        user.setState(user_detail.getString("user_state"));
        user.setPincode(Integer.parseInt((user_detail.getString("user_pincode").equalsIgnoreCase("")?"0":user_detail.getString("user_pincode"))));
        user.setSalary(getSalary(user,user_detail));
        user.setProfession(getWorkType(user,user_detail));
        user.setClubMembership(getClubMembership(user,user_detail));
        user.setDefenseService(getDefenceService(user,user_detail));
        user.setWatchBrand(getWatchBrand(user,user_detail));
        user.setCarBrand(getCarBrand(user,user_detail));
        user.setResidenceType(getResidenceType(user,user_detail));
        user.setTransportType(getTransportType(user,user_detail));
        user.setMilesCard(getMilesCard(user,user_detail));
        user.setCreditCard(getCreditCard(user,user_detail));
        user.setWalletAmount(Integer.parseInt(user_detail.getString("wallet_amount")));
        user.setFbLink(user_detail.getString("fb_link"));
        user.setTwitterLink(user_detail.getString("twitter_link"));
        user.setGplusLink(user_detail.getString("gplus_link"));
        user.setCheckIns(Integer.parseInt(user_detail.getString("checkin")));
        user.setQuizAnswered(Integer.parseInt(user_detail.getString("quiz_answered")));
        user.setDob(user_detail.getString("user_dob"));
        user.setAge(user_detail.getInt("user_age"));
        user.setProfileImage(user_detail.getString("profile_image"));
        user.setProfileCoverPic(user_detail.getString("moby_ad"));
        AccountManager.getInstance().setUser(user);
        setUpProfile();
    }

    private DropDownObject getCreditCard(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("credit_card");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setCreditCardDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getMilesCard(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("miles_card");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setMilesCardDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getTransportType(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("transport_type");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setTransportTypeDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getResidenceType(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("residence_type");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setResidenceTypeDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getCarBrand(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("car_brand");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setCarBrandDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getWatchBrand(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("watch_brand");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setWatchBrandDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getDefenceService(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("defence_service");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setDefenseServiceDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getClubMembership(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("club_membership");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setClubMembershipDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getWorkType(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("work_type");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setProfessionDropDownObjects(dropDownObjects);
        return result;
    }

    private DropDownObject getSalary(User user, JSONObject user_detail) throws JSONException {
        JSONArray array = user_detail.getJSONArray("salary_group");
        ArrayList<DropDownObject> dropDownObjects = new ArrayList<>();
        DropDownObject result = new DropDownObject();
        for(int i=0;i<array.length();i++){
            JSONObject object = array.getJSONObject(i);
            if(object.has("seleted")) {
                DropDownObject dropDownObject = new DropDownObject();
                dropDownObject.setCodeID(object.getInt("code_id"));
                dropDownObject.setCodeValue(object.getString("code_value"));
                dropDownObject.setSelected(object.getBoolean("seleted"));
                dropDownObjects.add(dropDownObject);
                if(object.getBoolean("seleted")){
                    result = dropDownObject;
                }
            }
        }
        user.setSalaryDropDownObjects(dropDownObjects);
        return result;
    }

    private void setUpProfile() {
        tv_profile_name.setText(AccountManager.getInstance().getUser().getName());
        tv_profile_profession.setText(AccountManager.getInstance().getUser().getProfession().getCodeValue());
        tv_profile_salary.setText(AccountManager.getInstance().getUser().getSalary().getCodeValue());
        tv_profile_email.setText(AccountManager.getInstance().getUser().getEmail());
        tv_profile_contact.setText(AccountManager.getInstance().getUser().getUserContact());
        tv_profile_address.setText(AccountManager.getInstance().getUser().getCompleteAddress());
        tv_profile_checkIns.setText(AccountManager.getInstance().getUser().getCheckIns()+"");
        tv_profile_quizAnswered.setText(AccountManager.getInstance().getUser().getQuizAnswered()+"");

        if(AccountManager.getInstance().getUser().getProfileImage()!=null &&!AccountManager.getInstance().getUser().getProfileImage().isEmpty()) {
            Picasso.with(this).load(AccountManager.getInstance().getUser().getProfileImage()).resize(200,200).centerCrop().into(iv_profile_photo);
        }else{
            Picasso.with(this).load(R.drawable.buser).into(iv_profile_photo);
        }
        if(AccountManager.getInstance().getUser().getProfileCoverPic()!=null &&!AccountManager.getInstance().getUser().getProfileCoverPic().isEmpty()) {
            Picasso.with(this).load(AccountManager.getInstance().getUser().getProfileCoverPic()).resize(640,480).centerCrop().into(kbv_profile_coverPic);
        }else{
            Picasso.with(this).load(R.drawable.mountains).into(kbv_profile_coverPic);
        }
    }


    @Override
    protected void onResume() {
        super.onResume();
        BApplication.getInstance().addUIListener(OnProfileUpdatedListener.class,this);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        BApplication.getInstance().removeUIListener(OnProfileUpdatedListener.class,this);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.profile_menu, menu);
        return true;
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                //NavUtils.navigateUpFromSameTask(this);
                return true;
            case R.id.menu_action_edit:
                startActivity(new Intent(this,EditProfileActivity.class));
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

    @Override
    public void onProfileUpdated() {
        fetchProfile();
    }
}
