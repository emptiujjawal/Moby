package com.snq.nearbucks.activity;

import android.os.Bundle;
import android.support.v4.app.FragmentManager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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
import com.snq.nearbucks.fragment.SelectSalaryDF;
import com.snq.nearbucks.listener.OnDropDownValueChangedListener;
import com.snq.nearbucks.listener.OnProfileUpdatedListener;
import com.snq.nearbucks.listener.OnSalaryChangedListener;
import com.snq.nearbucks.manager.AccountManager;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.DropDownObject;
import com.snq.nearbucks.object.User;
import com.snq.nearbucks.utils.URL;
import com.squareup.picasso.Picasso;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import butterknife.ButterKnife;
import butterknife.InjectView;

public class EditProfileActivity extends AppCompatActivity implements OnDropDownValueChangedListener {
    
    @InjectView(R.id.toolbar)
    Toolbar toolbar;
    @InjectView(R.id.et_edit_name)
    EditText et_edit_name;
    @InjectView(R.id.tv_edit_profession)
    TextView tv_edit_profession;
    @InjectView(R.id.tv_edit_salary)
    TextView tv_edit_salary;
    @InjectView(R.id.tv_edit_clubMembership)
    TextView tv_edit_clubMembership;
    @InjectView(R.id.tv_edit_defenceService)
    TextView tv_edit_defenceService;
    @InjectView(R.id.tv_edit_watchBrand)
    TextView tv_edit_watchBrand;
    @InjectView(R.id.tv_edit_carBrand)
    TextView tv_edit_carBrand;
    @InjectView(R.id.tv_edit_residenceType)
    TextView tv_edit_residenceType;
    @InjectView(R.id.tv_edit_transportType)
    TextView tv_edit_transportType;
    @InjectView(R.id.tv_edit_milesCard)
    TextView tv_edit_milesCard;
    @InjectView(R.id.tv_edit_creditCard)
    TextView tv_edit_creditCard;
    @InjectView(R.id.tv_edit_email)
    TextView tv_edit_email;
    @InjectView(R.id.tv_edit_contact)
    TextView tv_edit_contact;
    @InjectView(R.id.et_edit_address)
    EditText et_edit_address;
    @InjectView(R.id.et_edit_city)
    EditText et_edit_city;
    @InjectView(R.id.et_edit_state)
    EditText et_edit_state;
    @InjectView(R.id.et_edit_pincode)
    EditText et_edit_pincode;
    @InjectView(R.id.iv_edit_photo)
    ImageView iv_edit_photo;
    @InjectView(R.id.b_edit_facebook)
    Button b_edit_facebook;
    @InjectView(R.id.b_edit_twitter)
    Button b_edit_twitter;
    @InjectView(R.id.b_edit_gplus)
    Button b_edit_gplus;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_profile);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("Edit Profile");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        setUpProfile();
    }


    @Override
    public void OnDropDownValueChanged(int type, int position) {
        updateProfile(type,position);
        setUpProfile();
    }

    private void updateProfile(int type, int position) {
        List<DropDownObject> arrayList = getDDOArray(type,position);
        if(arrayList==null)return;
        for(int i=0;i<arrayList.size();i++){
            if(i==position) {
                arrayList.get(i).setSelected(true);
            }else{
                arrayList.get(i).setSelected(false);
            }
        }
    }

    private List<DropDownObject> getDDOArray(int type, int position) {
        switch (type){
            case 0:{
                AccountManager.getInstance().getUser().setSalary(AccountManager.getInstance().getUser().getSalaryDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getSalaryDropDownObjects();
            }
            case 1:{
                AccountManager.getInstance().getUser().setProfession(AccountManager.getInstance().getUser().getProfessionDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getProfessionDropDownObjects();
            }
            case 2:{
                AccountManager.getInstance().getUser().setClubMembership(AccountManager.getInstance().getUser().getClubMembershipDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getClubMembershipDropDownObjects();
            }
            case 3:{
                AccountManager.getInstance().getUser().setDefenseService(AccountManager.getInstance().getUser().getDefenseServiceDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getDefenseServiceDropDownObjects();
            }
            case 4:{
                AccountManager.getInstance().getUser().setResidenceType(AccountManager.getInstance().getUser().getResidenceTypeDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getResidenceTypeDropDownObjects();
            }
            case 5:{
                AccountManager.getInstance().getUser().setTransportType(AccountManager.getInstance().getUser().getTransportTypeDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getTransportTypeDropDownObjects();
            }
            case 6:{
                AccountManager.getInstance().getUser().setMilesCard(AccountManager.getInstance().getUser().getMilesCardDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getMilesCardDropDownObjects();
            }
            case 7:{
                AccountManager.getInstance().getUser().setCreditCard(AccountManager.getInstance().getUser().getCreditCardDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getCreditCardDropDownObjects();
            }
            case 8:{
                AccountManager.getInstance().getUser().setWatchBrand(AccountManager.getInstance().getUser().getWatchBrandDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getWatchBrandDropDownObjects();
            }
            case 9:{
                AccountManager.getInstance().getUser().setCarBrand(AccountManager.getInstance().getUser().getCarBrandDropDownObjects().get(position));
                return AccountManager.getInstance().getUser().getCarBrandDropDownObjects();
            }
        }
        return null;
    }

    private void setUpProfile() {
        et_edit_name.setText(AccountManager.getInstance().getUser().getName());
        tv_edit_profession.setText(AccountManager.getInstance().getUser().getProfession().getCodeValue());
        tv_edit_salary.setText(AccountManager.getInstance().getUser().getSalary().getCodeValue());

        tv_edit_clubMembership.setText(AccountManager.getInstance().getUser().getClubMembership().getCodeValue());
        tv_edit_defenceService.setText(AccountManager.getInstance().getUser().getDefenseService().getCodeValue());
        tv_edit_watchBrand.setText(AccountManager.getInstance().getUser().getWatchBrand().getCodeValue());
        tv_edit_carBrand.setText(AccountManager.getInstance().getUser().getCarBrand().getCodeValue());
        tv_edit_residenceType.setText(AccountManager.getInstance().getUser().getResidenceType().getCodeValue());
        tv_edit_transportType.setText(AccountManager.getInstance().getUser().getTransportType().getCodeValue());
        tv_edit_milesCard.setText(AccountManager.getInstance().getUser().getMilesCard().getCodeValue());
        tv_edit_creditCard.setText(AccountManager.getInstance().getUser().getCreditCard().getCodeValue());
        tv_edit_email.setText(AccountManager.getInstance().getUser().getEmail());
        tv_edit_contact.setText(AccountManager.getInstance().getUser().getUserContact());
        et_edit_address.setText(AccountManager.getInstance().getUser().getAddress());
        et_edit_state.setText(AccountManager.getInstance().getUser().getState());
        et_edit_city.setText(AccountManager.getInstance().getUser().getCity());
        if(AccountManager.getInstance().getUser().getPincode()!=0) {
            et_edit_pincode.setText(AccountManager.getInstance().getUser().getPincode()+"");
        }

        if(AccountManager.getInstance().getUser().getProfileImage()!=null &&!AccountManager.getInstance().getUser().getProfileImage().isEmpty()) {
            Picasso.with(this).load(AccountManager.getInstance().getUser().getProfileImage()).resize(300,300).centerCrop().into(iv_edit_photo);
        }else{
            Picasso.with(this).load(R.drawable.buser).into(iv_edit_photo);
        }

        tv_edit_salary.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(0,AccountManager.getInstance().getUser().getSalaryDropDownObjects());
            }
        });
        tv_edit_profession.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(1, AccountManager.getInstance().getUser().getProfessionDropDownObjects());
            }
        });
        tv_edit_clubMembership.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(2, AccountManager.getInstance().getUser().getClubMembershipDropDownObjects());
            }
        });
        tv_edit_defenceService.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(3, AccountManager.getInstance().getUser().getDefenseServiceDropDownObjects());
            }
        });
        tv_edit_residenceType.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(4, AccountManager.getInstance().getUser().getResidenceTypeDropDownObjects());
            }
        });
        tv_edit_transportType.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(5, AccountManager.getInstance().getUser().getTransportTypeDropDownObjects());
            }
        });
        tv_edit_milesCard.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(6, AccountManager.getInstance().getUser().getMilesCardDropDownObjects());
            }
        });
        tv_edit_creditCard.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(7, AccountManager.getInstance().getUser().getCreditCardDropDownObjects());
            }
        });
        tv_edit_watchBrand.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(8, AccountManager.getInstance().getUser().getWatchBrandDropDownObjects());
            }
        });
        tv_edit_carBrand.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showList(9, AccountManager.getInstance().getUser().getCarBrandDropDownObjects());
            }
        });

        iv_edit_photo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

            }
        });

    }

    private void showList(int type, List<DropDownObject> dropDownObjects) {
        FragmentManager fm = getSupportFragmentManager();
        ArrayList<DropDownObject> list = new ArrayList<>(dropDownObjects.size());
        list.addAll(dropDownObjects);
        SelectSalaryDF selectSalaryDF = SelectSalaryDF.newInstance(type,list);
        selectSalaryDF.show(fm, "selectSalaryDF");
    }

    @Override
    protected void onResume() {
        super.onResume();
        BApplication.getInstance().addUIListener(OnDropDownValueChangedListener.class,this);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        BApplication.getInstance().removeUIListener(OnDropDownValueChangedListener.class, this);
    }

//    @Override
//    public void onSalaryChanged(String salary) {
//        tv_edit_salary.setText(salary);
//    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.edit_menu, menu);
        return true;
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                //NavUtils.navigateUpFromSameTask(this);
                return true;
            case R.id.menu_action_save:
                saveProfile();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    private void saveProfile() {
        final User user = AccountManager.getInstance().getUser();
        user.setName(et_edit_name.getText().toString());
        user.setAddress(et_edit_address.getText().toString());
        user.setCity(et_edit_city.getText().toString());
        user.setState(et_edit_state.getText().toString());
        //user.setDob(tv_edit_dob.getText().toString());
        //user.setAge(CommonUtils.getAge());
        if(!et_edit_pincode.getText().toString().isEmpty()) {
            user.setPincode(Integer.parseInt(et_edit_pincode.getText().toString()));
        }

        PBManager.getInstance().showPB(this,"Updating Profile...", false);
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
                                Toast.makeText(EditProfileActivity.this, message, Toast.LENGTH_LONG).show();
                                return;
                            }
                            Toast.makeText(EditProfileActivity.this, "Profile updated successfully!", Toast.LENGTH_LONG).show();
                            //AccountManager.getInstance().setUser(user);
                            for (OnProfileUpdatedListener listener : BApplication.getInstance().getUIListeners(OnProfileUpdatedListener.class)) {
                                listener.onProfileUpdated();
                            }
                            finish();
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
                params.put(URL.REQUEST_IDENTIFIER, URL.UPDATE_PROFILE_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                params.put(URL.PARAMETER_USER_NAME, user.getName());
                params.put(URL.PARAMETER_USER_EMAIL, user.getEmail());
                params.put(URL.PARAMETER_USER_PROFESSION, user.getProfession().getCodeValue());
                params.put(URL.PARAMETER_USER_SALARY, user.getSalary().getCodeID());
                params.put(URL.PARAMETER_USER_ADDRESS, user.getAddress());
                params.put(URL.PARAMETER_USER_CITY, user.getCity());
                params.put(URL.PARAMETER_USER_STATE, user.getState());
                params.put(URL.PARAMETER_USER_PINCODE, String.valueOf(user.getPincode()));
                params.put(URL.PARAMETER_USER_GENDER, "");
                params.put(URL.PARAMETER_USER_AGE, "");
                params.put(URL.PARAMETER_USER_DOB, "");
                params.put(URL.PARAMETER_USER_CLUB_MEMBERSHIP, user.getClubMembership().getCodeID());
                params.put(URL.PARAMETER_USER_DEFENSE_SERVICE, user.getDefenseService().getCodeID());
                params.put(URL.PARAMETER_USER_WT, user.getProfession().getCodeID());
                params.put(URL.PARAMETER_USER_WB, user.getWatchBrand().getCodeID());
                params.put(URL.PARAMETER_USER_CB, user.getCarBrand().getCodeID());
                params.put(URL.PARAMETER_USER_RT, user.getResidenceType().getCodeID());
                params.put(URL.PARAMETER_USER_TT, user.getTransportType().getCodeID());
                params.put(URL.PARAMETER_USER_MILES_CARD, user.getMilesCard().getCodeID());
                params.put(URL.PARAMETER_USER_CREDIT_CARD, user.getCreditCard().getCodeID());
                return params;
            }

        };
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.UPDATE_PROFILE_IDENTIFIER);
    }
}
