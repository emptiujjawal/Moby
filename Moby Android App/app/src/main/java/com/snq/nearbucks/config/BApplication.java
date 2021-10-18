package com.snq.nearbucks.config;

import android.app.Activity;
import android.app.Instrumentation;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.Resources;
import android.os.Handler;
import android.preference.PreferenceManager;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.Volley;
import com.facebook.AccessToken;
import com.facebook.login.LoginManager;
import com.firebase.ui.auth.AuthUI;
import com.google.android.gms.auth.api.Auth;
import com.google.android.gms.auth.api.signin.GoogleSignIn;
import com.google.android.gms.auth.api.signin.GoogleSignInClient;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.orm.SugarApp;
import com.snq.nearbucks.activity.GetMobileNoActivity;
import com.snq.nearbucks.activity.LoginActivity;
import com.snq.nearbucks.activity.MainActivity;
import com.snq.nearbucks.activity.WelcomeActivity;
import com.snq.nearbucks.listener.BaseUIListener;
import com.snq.nearbucks.manager.AccountManager;

import java.util.Collection;
import java.util.Collections;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.CopyOnWriteArrayList;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.ThreadFactory;

public class BApplication extends SugarApp {
    // app
    private static BApplication instance;
    // Note: Your consumer key and secret should be obfuscated in your source code before shipping.
    private static final String TWITTER_KEY = "i0tM4M0WmOCFiCkHoA4VrwMt7";
    private static final String TWITTER_SECRET = "EWmLHMLndK1r1ubaSPxhLTPVPAjqnPpTzjjbCgTMpY770iT4i6";


    public static final String TAG = BApplication.class
            .getSimpleName();

    private RequestQueue mRequestQueue;
    private Map<Class<? extends BaseUIListener>, Collection<? extends BaseUIListener>> uiListeners;


    /**
     * Create main application
     */
    public BApplication() {
        instance = this;
        handler = new Handler();
        backgroundExecutor = Executors
                .newSingleThreadExecutor(new ThreadFactory() {
                    @Override
                    public Thread newThread(Runnable runnable) {
                        Thread thread = new Thread(runnable,
                                "Background executor service");
                        thread.setPriority(Thread.MIN_PRIORITY);
                        thread.setDaemon(true);
                        return thread;
                    }
                });
        uiListeners = new HashMap<Class<? extends BaseUIListener>, Collection<? extends BaseUIListener>>();
    }


    /**
     * Thread to execute tasks in background..
     */
    private final ExecutorService backgroundExecutor;
    /**
     * Handler to execute runnable in UI thread.
     */
    private final Handler handler;
    /**
     * Create main application
     *
     * @param context
     */
    public BApplication(final Context context) {
        this();
        attachBaseContext(context);

    }


    public static void setSP(String key, String value) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString(key, value);
        editor.commit();
    }

    public static void setSPLong(String key, long value) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putLong(key, value);
        editor.commit();
    }

    public static void setSPBoolean(String key, boolean value) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putBoolean(key, value);
        editor.commit();
    }


    public static void setSPInteger(String key, int value) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putInt(key, value);
        editor.commit();
    }

    public static Long getSPLong(String key) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        return sharedPreferences.getLong(key, -1); // 0 - professor 1 - student
    }

    public static Integer getSPInteger(String key) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        return sharedPreferences.getInt(key, 0); // 0 - professor 1 - student
    }

    public static String getSPString(String key) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        return sharedPreferences.getString(key, "");
    }

    public static Boolean getSPBoolean(String key) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        return sharedPreferences.getBoolean(key, false);
    }

    public static Boolean getSPAntiBoolean(String key) {
        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(getInstance());
        return sharedPreferences.getBoolean(key, true);
    }


    @Override
    public void onCreate() {
        super.onCreate();
        //initDigits();
    }

//    private AuthCallback authCallback;
//
//    private void initDigits() {
//        TwitterAuthConfig authConfig = new TwitterAuthConfig(TWITTER_KEY, TWITTER_SECRET);
//        Digits.Builder digitsBuilder = new Digits.Builder().withTheme(R.style.CustomDigitsTheme);
//        Fabric.with(this, new TwitterCore(authConfig), digitsBuilder.build());
//        authCallback = new AuthCallback() {
//            @Override
//            public void success(DigitsSession session, String phoneNumber) {
//                // Do something with the session
//                Toast.makeText(instance, "Mobile no: " + phoneNumber + " Verified Successfully", Toast.LENGTH_SHORT).show();
//                startActivity(new Intent(getInstance(), LoginActivity.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK));
//            }
//
//            @Override
//            public void failure(DigitsException exception) {
//                // Do something on failure
//                Toast.makeText(instance, "Mobile No. Verification Failed!", Toast.LENGTH_SHORT).show();
//            }
//        };
//    }
//
//    public AuthCallback getAuthCallback() {
//        return authCallback;
//    }

    /**
     * Create main application
     *
     * @param instrumentation
     */
    public BApplication(final Instrumentation instrumentation) {
        this();
        attachBaseContext(instrumentation.getTargetContext());
    }

    public static BApplication getInstance() {

        if (instance == null) {
            instance = new BApplication();
        }
        return instance;
    }


    public static int dpToPixels(int dp, Resources res) {
        return (int) (res.getDisplayMetrics().density * dp + 0.5f);
    }

    public ProgressDialog pd;

    public void onPreExecute(Context context, String msg, boolean isCancelable) {
        pd = new ProgressDialog(context);
        //pd.setTitle("Please wait...");
        pd.setMessage(msg);
        pd.setCancelable(isCancelable);
        pd.setIndeterminate(true);
        //pd.setCancelable(true);
        pd.show();
    }

    public void onPreExecute(Context context, String msg, boolean isCancelable, DialogInterface.OnCancelListener ocl) {
        pd = new ProgressDialog(context);
        //pd.setTitle("Please wait...");
        pd.setMessage(msg);
        pd.setCancelable(isCancelable);
        pd.setIndeterminate(true);
        pd.setOnCancelListener(ocl);
        //pd.setCancelable(true);
        pd.show();
    }

    @SuppressWarnings("unchecked")
    private <T extends BaseUIListener> Collection<T> getOrCreateUIListeners(
            Class<T> cls) {
        Collection<T> collection = (Collection<T>) uiListeners.get(cls);
        if (collection == null) {
            collection = new CopyOnWriteArrayList<>();
            uiListeners.put(cls, collection);
        }
        return collection;
    }

    /**
     * @param cls Requested class of listeners.
     * @return List of registered UI listeners.
     */
    public <T extends BaseUIListener> Collection<T> getUIListeners(Class<T> cls) {
/*        if (closed)
            return Collections.emptyList();*/
            return Collections.unmodifiableCollection(getOrCreateUIListeners(cls));
    }

    /**
     * Register new listener.
     * <p/>
     * Should be called from {@link Activity#onResume()}.
     *
     * @param cls
     * @param listener
     */
    public <T extends BaseUIListener> void addUIListener(Class<T> cls,
                                                         T listener) {
        getOrCreateUIListeners(cls).add(listener);
    }

    /**
     * Unregister listener.
     * <p/>
     * Should be called from {@link Activity#onPause()}.
     *
     * @param cls
     * @param listener
     */
    public <T extends BaseUIListener> void removeUIListener(Class<T> cls,
                                                            T listener) {
        getOrCreateUIListeners(cls).remove(listener);
    }

    public RequestQueue getRequestQueue() {
        if (mRequestQueue == null) {
            mRequestQueue = Volley.newRequestQueue(getApplicationContext());
        }

        return mRequestQueue;
    }

    /**
     * Submits request to be executed in background.
     *
     * @param runnable
     */
    public void runInBackground(final Runnable runnable) {
        backgroundExecutor.submit(new Runnable() {
            @Override
            public void run() {
                try {
                    runnable.run();
                } catch (Exception e) {
                    //LogManager.getLogManager().(runnable, e);
                }
            }
        });
    }

    /**
     * Submits request to be executed in UI thread.
     *
     * @param runnable
     */
    public void runOnUiThread(final Runnable runnable) {
        handler.post(runnable);
    }

    public <T> void addToRequestQueue(Request<T> req, String tag) {
        // set the default tag if tag is empty
        req.setTag(TextUtils.isEmpty(tag) ? TAG : tag);
        getRequestQueue().add(req);
    }

    public <T> void addToRequestQueue(Request<T> req) {
        req.setTag(TAG);
        getRequestQueue().add(req);
    }

    public void cancelPendingRequests(Object tag) {
        if (mRequestQueue != null) {
            mRequestQueue.cancelAll(tag);
        }
    }

    public void logout(final AppCompatActivity context) {
        AuthUI.getInstance()
            .signOut(context)
            .addOnCompleteListener(new OnCompleteListener<Void>() {
                public void onComplete(@NonNull Task<Void> task) {
                    // user is now signed out
                    LoginManager.getInstance().logOut();
                    logoutGoogleAccount(context);
                    AccountManager.getInstance().logout();
                    startActivity(new Intent(context,GetMobileNoActivity.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK));
                }
            });
    }

    private void logoutGoogleAccount(AppCompatActivity context) {
        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                .requestEmail().requestProfile()
                .build();
        GoogleSignInClient mGoogleSignInClient = GoogleSignIn.getClient(context, gso);
        mGoogleSignInClient.signOut();
    }

    public void checkUserLoggedIn(AppCompatActivity activityContext) {
        FirebaseAuth auth = FirebaseAuth.getInstance();
        if (auth.getCurrentUser() == null) {
            AccountManager.getInstance().logout();
            //startActivity(new Intent(activityContext, WelcomeActivity.class));
            startActivity(new Intent(activityContext,WelcomeActivity.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK));
            activityContext.finish();
            return;
        }
        if(GoogleSignIn.getLastSignedInAccount(activityContext)==null&& AccessToken.getCurrentAccessToken()==null){
            startActivity(new Intent(activityContext,LoginActivity.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK));
            activityContext.finish();
            return;
        }
    }
}


