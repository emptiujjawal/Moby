package com.snq.nearbucks.activity;

import android.annotation.TargetApi;
import android.app.LoaderManager.LoaderCallbacks;
import android.content.CursorLoader;
import android.content.Intent;
import android.content.Loader;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.support.annotation.NonNull;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.EditorInfo;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.GraphRequest;
import com.facebook.GraphResponse;
import com.facebook.login.LoginResult;
import com.facebook.login.widget.LoginButton;
import com.google.android.gms.auth.api.Auth;
import com.google.android.gms.auth.api.signin.GoogleSignInAccount;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.auth.api.signin.GoogleSignInResult;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.firebase.auth.FirebaseAuth;
import com.snq.nearbucks.R;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.manager.AccountManager;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.User;
import com.snq.nearbucks.utils.URL;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import butterknife.ButterKnife;
import butterknife.InjectView;

import static android.Manifest.permission.READ_CONTACTS;

/**
 * A login screen that offers login via email/password.
 */
public class LoginActivity extends AppCompatActivity implements LoaderCallbacks<Cursor>, GoogleApiClient.OnConnectionFailedListener {

    /**
     * Id to identity READ_CONTACTS permission request.
     */
    private static final int REQUEST_READ_CONTACTS = 0;

    /**
     * A dummy authentication store containing known user names and passwords.
     * TODO: remove after connecting to a real authentication system.
     */
    private static final String[] DUMMY_CREDENTIALS = new String[]{
            "foo@example.com:hello", "bar@example.com:world"
    };
    private static final int RC_SIGN_IN = 100;

    // UI references.
    private AutoCompleteTextView mEmailView;
    private EditText mPasswordView;
    private View mProgressView;
    @InjectView(R.id.b_sign_in_with_google)
    Button b_googleLogin;
    @InjectView(R.id.b_sign_in_with_fb)
    Button b_fbLogin;
    @InjectView(R.id.login_button)
    LoginButton b_loginWithFB;
    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    private GoogleApiClient client;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        ButterKnife.inject(this);
        // Set up the login form.
        mEmailView = (AutoCompleteTextView) findViewById(R.id.email);
        populateAutoComplete();

        mPasswordView = (EditText) findViewById(R.id.password);
        mPasswordView.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                if (id == R.id.login || id == EditorInfo.IME_NULL) {
                    //attemptLogin();
                    return true;
                }
                return false;
            }
        });

        Button mEmailSignInButton = (Button) findViewById(R.id.email_sign_in_button);
        mEmailSignInButton.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                makeSignInRequest(mEmailView.getText().toString(), "","","","", mPasswordView.getText().toString(),URL.PARAMETER_LOGGED_IN_USING_EMAIL);

            }
        });

        Button mEmailSignUpRedirectButton = (Button) findViewById(R.id.email_sign_up_redirect_button);
        mEmailSignUpRedirectButton.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(LoginActivity.this,SignupActivity.class));
                finish();
            }
        });
        mProgressView = findViewById(R.id.login_progress);

        //setUp google login
        setUpGoogleLogin();


        //setUp fb login
        setUpFBLogin();
    }

    CallbackManager callbackManager;
    private void setUpFBLogin() {
        callbackManager = CallbackManager.Factory.create();
        b_loginWithFB.setReadPermissions("email");
        b_loginWithFB.registerCallback(callbackManager, new FacebookCallback<LoginResult>() {
            @Override
            public void onSuccess(final LoginResult loginResult) {
                // App code
                GraphRequest request = GraphRequest.newMeRequest(
                        loginResult.getAccessToken(),
                        new GraphRequest.GraphJSONObjectCallback() {
                            @Override
                            public void onCompleted(JSONObject object, GraphResponse response) {
                                Log.v("LoginActivity", response.toString());
                                // Application code
                                try {
                                    String email = object.getString("email");
                                    String name = object.getString("name");
                                    String gender = object.getString("gender");
                                    makeSignInRequest(email,name,gender,"","https://graph.facebook.com/" + loginResult.getAccessToken().getUserId()+ "/picture?type=large", "",URL.PARAMETER_LOGGED_IN_USING_FACEBOOK);
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            }
                        });
                Bundle parameters = new Bundle();
                parameters.putString("fields", "id,name,email,gender,birthday");
                request.setParameters(parameters);
                request.executeAsync();
            }

            @Override
            public void onCancel() {

            }

            @Override
            public void onError(FacebookException error) {

            }
        });
        b_fbLogin.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                b_loginWithFB.performClick();
            }
        });

    }

    private void setUpGoogleLogin() {
        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
            .requestEmail().requestProfile()
            .build();
        client = new GoogleApiClient.Builder(this)
                .enableAutoManage(this, this)
                .addApi(Auth.GOOGLE_SIGN_IN_API, gso)
                .build();
        b_googleLogin.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent signInIntent = Auth.GoogleSignInApi.getSignInIntent(client);
                startActivityForResult(signInIntent, RC_SIGN_IN);
            }
        });
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        callbackManager.onActivityResult(requestCode, resultCode, data);
        // Result returned from launching the Intent from GoogleSignInApi.getSignInIntent(...);
        if (requestCode == RC_SIGN_IN) {
            GoogleSignInResult result = Auth.GoogleSignInApi.getSignInResultFromIntent(data);
            handleSignInResult(result);
        }
    }

    private void handleSignInResult(GoogleSignInResult result) {
        Log.d(LoginActivity.class.getName(), "handleSignInResult:" + result.isSuccess());
        if (result.isSuccess()) {
            // Signed in successfully, show authenticated UI.
            GoogleSignInAccount acct = result.getSignInAccount();
            makeSignInRequest(acct.getEmail(),acct.getDisplayName(),"","",acct.getPhotoUrl().getPath(),"",URL.PARAMETER_LOGGED_IN_USING_GOOGLE);

        } else {
            // Signed out, show unauthenticated UI.
           Toast.makeText(this,"Error!",Toast.LENGTH_SHORT).show();
        }
    }

    private void makeSignInRequest(final String email, final String name,final String gender,final String dob,final String photoUrl, final String password, final String loggedInUsing) {
        if(loggedInUsing.equalsIgnoreCase(URL.PARAMETER_LOGGED_IN_USING_EMAIL)){
            if(checkForInput(email,password)) {
                return;
            }
        }
        PBManager.getInstance().showPB(LoginActivity.this, "Signing in...", false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        Log.d(LoginActivity.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        User user = null;
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            JSONObject message = jsonObject.getJSONObject("message");
                            JSONObject user_detail = message.getJSONObject("user_detail");
                            user = User.fromJSON(user_detail);
                            user.setEmail(email);
                            user.setPassword(password);
                            user.setProfileImage(photoUrl);
                            user.setUserContact(FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        AccountManager.getInstance().setUser(user);
                        startActivity(new Intent(LoginActivity.this,MapsActivity.class));
                        finish();
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d(LoginActivity.class.getName(), "Error: " + error.getMessage());
                Toast.makeText(LoginActivity.this,"Error!",Toast.LENGTH_SHORT).show();
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
                params.put(URL.PARAMETER_USER_PROFILE_PHOTO,photoUrl);
                params.put(URL.PARAMETER_USER_NAME,name);
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

    private void populateAutoComplete() {
        if (!mayRequestContacts()) {
            return;
        }

        getLoaderManager().initLoader(0, null, this);
    }

    private boolean mayRequestContacts() {
        if (Build.VERSION.SDK_INT < Build.VERSION_CODES.M) {
            return true;
        }
        if (checkSelfPermission(READ_CONTACTS) == PackageManager.PERMISSION_GRANTED) {
            return true;
        }
        if (shouldShowRequestPermissionRationale(READ_CONTACTS)) {
            Snackbar.make(mEmailView, R.string.permission_rationale, Snackbar.LENGTH_INDEFINITE)
                    .setAction(android.R.string.ok, new OnClickListener() {
                        @Override
                        @TargetApi(Build.VERSION_CODES.M)
                        public void onClick(View v) {
                            requestPermissions(new String[]{READ_CONTACTS}, REQUEST_READ_CONTACTS);
                        }
                    });
        } else {
            requestPermissions(new String[]{READ_CONTACTS}, REQUEST_READ_CONTACTS);
        }
        return false;
    }

    /**
     * Callback received when a permissions request has been completed.
     */
    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions,
                                           @NonNull int[] grantResults) {
        if (requestCode == REQUEST_READ_CONTACTS) {
            if (grantResults.length == 1 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                populateAutoComplete();
            }
        }
    }

    private boolean isEmailValid(String email) {
        //TODO: Replace this with your own logic
        return email.contains("@");
    }

    private boolean isPasswordValid(String password) {
        //TODO: Replace this with your own logic
        return password.length() > 4;
    }

    @Override
    public Loader<Cursor> onCreateLoader(int i, Bundle bundle) {
        return new CursorLoader(this,
                // Retrieve data rows for the device user's 'profile' contact.
                Uri.withAppendedPath(ContactsContract.Profile.CONTENT_URI,
                        ContactsContract.Contacts.Data.CONTENT_DIRECTORY), ProfileQuery.PROJECTION,

                // Select only email addresses.
                ContactsContract.Contacts.Data.MIMETYPE +
                        " = ?", new String[]{ContactsContract.CommonDataKinds.Email
                .CONTENT_ITEM_TYPE},

                // Show primary email addresses first. Note that there won't be
                // a primary email address if the user hasn't specified one.
                ContactsContract.Contacts.Data.IS_PRIMARY + " DESC");
    }

    @Override
    public void onLoadFinished(Loader<Cursor> cursorLoader, Cursor cursor) {
        List<String> emails = new ArrayList<>();
        cursor.moveToFirst();
        while (!cursor.isAfterLast()) {
            emails.add(cursor.getString(ProfileQuery.ADDRESS));
            cursor.moveToNext();
        }

        addEmailsToAutoComplete(emails);
    }

    @Override
    public void onLoaderReset(Loader<Cursor> cursorLoader) {

    }

    private void addEmailsToAutoComplete(List<String> emailAddressCollection) {
        //Create adapter to tell the AutoCompleteTextView what to show in its dropdown list.
        ArrayAdapter<String> adapter =
                new ArrayAdapter<>(LoginActivity.this,
                        android.R.layout.simple_dropdown_item_1line, emailAddressCollection);

        mEmailView.setAdapter(adapter);
    }

    @Override
    public void onStart() {
        super.onStart();
    }

    @Override
    public void onStop() {
        super.onStop();
    }

    @Override
    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {

    }


    private interface ProfileQuery {
        String[] PROJECTION = {
                ContactsContract.CommonDataKinds.Email.ADDRESS,
                ContactsContract.CommonDataKinds.Email.IS_PRIMARY,
        };

        int ADDRESS = 0;
        int IS_PRIMARY = 1;
    }

}

