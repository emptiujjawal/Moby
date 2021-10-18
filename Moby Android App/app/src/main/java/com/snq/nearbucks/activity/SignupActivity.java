package com.snq.nearbucks.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.google.firebase.auth.FirebaseAuth;
import com.snq.nearbucks.R;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.manager.AccountManager;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.User;
import com.snq.nearbucks.utils.URL;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import butterknife.ButterKnife;

/**
 * A sign up screen that offers sign up via email/password.
 */
public class SignupActivity extends AppCompatActivity {

    private static final String[] DUMMY_CREDENTIALS = new String[]{
            "foo@example.com:hello", "bar@example.com:world"
    };

    // UI references.
    private AutoCompleteTextView mEmailView;
    private EditText mPasswordView;
    private View mProgressView;
    private View mLoginFormView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);
        ButterKnife.inject(this);
        // Set up the login form.
        mEmailView = (AutoCompleteTextView) findViewById(R.id.email);
        mPasswordView = (EditText) findViewById(R.id.password);

        Button mEmailSignInButton = (Button) findViewById(R.id.email_sign_up_button);


        Button mEmailSignInRedirectButton = (Button) findViewById(R.id.email_sign_in_redirect_button);

        mEmailSignInRedirectButton.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(SignupActivity.this,LoginActivity.class));
                finish();
            }
        });
        mEmailSignInButton.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                makeSignInRequest(mEmailView.getText().toString(),mPasswordView.getText().toString(),URL.PARAMETER_LOGGED_IN_USING_EMAIL);
            }
        });

        mLoginFormView = findViewById(R.id.login_form);
    }
    private void makeSignInRequest(final String email, final String password, final String loggedInUsing) {
        if(loggedInUsing.equalsIgnoreCase(URL.PARAMETER_LOGGED_IN_USING_EMAIL)){
            if(checkForInput(email,password)) {
                return;
            }
        }
        PBManager.getInstance().showPB(SignupActivity.this, "Registering...", false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        Log.d(SignupActivity.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        String name = "";
                        String gender = "";
                        String dob = "";
                        int age = 0;
                        User user = null;
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            JSONObject message = jsonObject.getJSONObject("message");
                            JSONObject user_detail = message.getJSONObject("user_detail");
                            user = User.fromJSON(user_detail);
                            user.setEmail(email);
                            user.setPassword(password);
                            user.setUserContact(FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        AccountManager.getInstance().setUser(user);
                        startActivity(new Intent(SignupActivity.this,MapsActivity.class));
                        finish();
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(SignupActivity.class.getName(), "Error: " + error.getMessage());
                Toast.makeText(SignupActivity.this,"Error!",Toast.LENGTH_SHORT).show();
                PBManager.getInstance().cancelPB();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(URL.REQUEST_IDENTIFIER, URL.LOGIN_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                params.put(URL.PARAMETER_USER_EMAIL,email );
                params.put(URL.PARAMETER_USER_PASSWORD, password);
                params.put(URL.PARAMETER_LOGGED_IN_USING,loggedInUsing);
                return params;
            }

        };

// Adding request to request queue
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.LOGIN_IDENTIFIER);
    }

    private boolean checkForInput(String email, String password) {
        if(email==null || email.isEmpty()){
            Toast.makeText(this,"Email is empty!",Toast.LENGTH_SHORT).show();
            return true;
        }
        if(password==null || password.isEmpty()){
            Toast.makeText(this,"Password is empty!",Toast.LENGTH_SHORT).show();
            return true;
        }
        if(!isEmailValid(mEmailView.getText().toString())){
            Toast.makeText(this,"Email is not valid!",Toast.LENGTH_SHORT).show();
            return true;
        }
        return false;
    }

    private boolean isEmailValid(String email) {
        //TODO: Replace this with your own logic
        return email.contains("@");
    }
}

