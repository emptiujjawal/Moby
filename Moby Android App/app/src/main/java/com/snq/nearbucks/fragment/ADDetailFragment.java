package com.snq.nearbucks.fragment;

import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
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
import com.snq.nearbucks.activity.LoginActivity;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.manager.ADManager;
import com.snq.nearbucks.manager.NBManager;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.AD;
import com.snq.nearbucks.utils.URL;
import com.squareup.picasso.Picasso;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link ADDetailFragment.OnADDetailFragmentInteraction} interface
 * to handle interaction events.
 */
public class ADDetailFragment extends Fragment {

    private OnADDetailFragmentInteraction mListener;

    @InjectView(R.id.iv_add_close)
    ImageView iv_close;
    @InjectView(R.id.tv_add_promotion)
    TextView tv_promotion;
    @InjectView(R.id.iv_add_productPhoto)
    ImageView iv_productPhoto;
    @InjectView(R.id.tv_add_productName)
    TextView tv_productName;
    @InjectView(R.id.tv_add_companyName)
    TextView tv_companyName;
    @InjectView(R.id.tv_add_storeWebsite)
    TextView tv_storeWebsite;
    @InjectView(R.id.tv_add_checkInReward)
    TextView tv_checkInReward;
    @InjectView(R.id.tv_add_quizReward)
    TextView tv_quizReward;
    @InjectView(R.id.tv_add_distance)
    TextView tv_distance;
    @InjectView(R.id.tv_add_storeAddress)
    TextView tv_storeAddress;
    @InjectView(R.id.tv_add_storeNBLandmark)
    TextView tv_storeNBLandmark;
    @InjectView(R.id.tv_add_storeContact)
    TextView tv_storeContact;
    @InjectView(R.id.b_add_checkIn)
    Button b_checkIn;

    int level = 0;
    long uid;
    AD ad;
    boolean isPromotion;

    public ADDetailFragment() {
        // Required empty public constructor
    }

    public static ADDetailFragment newInstance(long uid, boolean isPromotion) {
        ADDetailFragment frag = new ADDetailFragment();
        Bundle args = new Bundle();
        args.putLong("uid", uid);
        args.putBoolean("isPromotion", isPromotion);
        frag.setArguments(args);
        return frag;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_addetail, container, false);
        ButterKnife.inject(this, view);
        b_checkIn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (isPromotion) {
                    onButtonPressed(1);
                } else {
 /*                    switch (level) {
                        case 0: {
                            checkIn();
                           Handler handler = new Handler();
                            handler.postDelayed(new Runnable() {
                                public void run() {
                                    level = 1;
                                    PBManager.getInstance().cancelPB();
                                    Toast.makeText(getActivity(), "Check in successful!", Toast.LENGTH_LONG).show();
                                    b_checkIn.setText(R.string.take_the_quiz);
                                }
                            }, 3000);
                        }
                        break;
                        case 1: {
                    */
                    PBManager.getInstance().showPB(getActivity(), "Checking  your location...", false);
                    if (!isUserNearTheAD()) {
                        PBManager.getInstance().cancelPB();
                        Toast.makeText(getActivity(), "For Check in, You need to be within 300m of the AD location!", Toast.LENGTH_LONG).show();
                        return;
                    }
                    PBManager.getInstance().cancelPB();
                    QAFragment myf = QAFragment.newInstance(uid);
                    FragmentTransaction transaction = getActivity().getSupportFragmentManager().beginTransaction();
                    transaction.replace(R.id.fl_maps_adDetail, myf);
                    transaction.addToBackStack(null);
                    transaction.commit();
                    // break;
                    //}
                    //}
                }
            }
        });
        iv_close.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                onButtonPressed(0);
            }
        });
        uid = getArguments().getLong("uid", -1);
        isPromotion = getArguments().getBoolean("isPromotion", false);
        ad = ADManager.getInstance().getADByUID(uid);
        setUpAD();
        return view;
    }


    private void checkIn() {
        PBManager.getInstance().showPB(getActivity(), "Checking in...", false);
        if (!isUserNearTheAD()) {
            PBManager.getInstance().cancelPB();
            Toast.makeText(getActivity(), "For Check in, You need to be within 300m of the AD location!", Toast.LENGTH_LONG).show();
            return;
        }
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
                            if (error) {
                                String message = res.getString("message");
                                Toast.makeText(getActivity(), message, Toast.LENGTH_LONG).show();
                                return;
                            }
                            level = 1;
                            JSONObject message = res.getJSONObject("message");
                            String toastMessage = message.getString("display_message");
                            Toast.makeText(getActivity(), toastMessage, Toast.LENGTH_LONG).show();
                            showDialog(message.getString("credit_amount"), message.getString("wallet_amount"));
                            if (ad.getQuestions().isEmpty()) {
                                b_checkIn.setVisibility(View.GONE);
                            } else {
                                b_checkIn.setVisibility(View.VISIBLE);
                                b_checkIn.setText(R.string.take_the_quiz);
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
                params.put(URL.REQUEST_IDENTIFIER, URL.CHECK_IN_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                params.put(URL.PARAMETER_AD_ID, String.valueOf(ad.getUid()));
                return params;
            }

        };

// Adding request to request queue
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.CHECK_IN_IDENTIFIER);
    }

    private boolean isUserNearTheAD() {
        Location userLocation = NBManager.getInstance().getCurrentLocation();
        if (userLocation == null)
            return false;
        float distance[] = new float[1];
        if (ad.getADLatLng() == null)
            return false;
        Location.distanceBetween(userLocation.getLatitude(), userLocation.getLongitude(), ad.getLatLocation(), ad.getLongLocation(), distance);
        if (distance[0] < 300) {
            return true;
        } else {
            return false;
        }
    }

    private void showDialog(String credit_amount, String wallet_amount) {
        FragmentManager fm = getActivity().getSupportFragmentManager();
        CheckInSuccessDF checkInSuccessDF = CheckInSuccessDF.newInstance("Congratulations!\nRs. " + credit_amount + "\n Credited to your Paytm account!\nby MobyAds");
        checkInSuccessDF.show(fm, "checkInSuccessDF");
    }

    private void setUpAD() {
        if (!ad.getProductPhotoURL().isEmpty()) {
            Picasso.with(getActivity()).load(ad.getProductPhotoURL()).resize(640, 480).centerCrop().into(iv_productPhoto);
        }
        tv_productName.setText(ad.getProductName());
        tv_companyName.setText(ad.getCompanyName() + "");
        tv_storeWebsite.setText(ad.getLocationEmail());
        tv_checkInReward.setText("Rs. " + ad.getCheckInReward() + "");
        tv_quizReward.setText("₹"+ad.getTotalReward());
        tv_storeAddress.setText(ad.getLocationAddress());
        tv_storeNBLandmark.setText(ad.getLocationLandmark());
        tv_storeContact.setText(ad.getLocationContact());
        tv_distance.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(android.content.Intent.ACTION_VIEW,
                        Uri.parse("http://maps.google.com/maps?daddr=" + ad.getLatLocation() + "," + ad.getLongLocation()));
                startActivity(intent);
            }
        });

        //tv_storeAddress.setText(ad.getStore().getLandmark());
        if (isPromotion) {
            b_checkIn.setText(R.string.action_know_more);
            tv_promotion.setVisibility(View.VISIBLE);
        } else {
            b_checkIn.setText(R.string.action_engage);
            tv_promotion.setVisibility(View.GONE);
        }
    }

    // TODO: Rename method, update argument and hook method into UI event
    public void onButtonPressed(int i) {
        if (mListener != null) {
            mListener.onADDetailFragmentInteraction(i);
        }
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        if (context instanceof OnADDetailFragmentInteraction) {
            mListener = (OnADDetailFragmentInteraction) context;
        } else {
            throw new RuntimeException(context.toString()
                    + " must implement OnFragmentInteractionListener");
        }
    }

    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
    }

    /**
     * This interface must be implemented by activities that contain this
     * fragment to allow an interaction in this fragment to be communicated
     * to the activity and potentially other fragments contained in that
     * activity.
     * <p/>
     * See the Android Training lesson <a href=
     * "http://developer.android.com/training/basics/fragments/communicating.html"
     * >Communicating with Other Fragments</a> for more information.
     */
    public interface OnADDetailFragmentInteraction {
        // TODO: Update argument type and name
        void onADDetailFragmentInteraction(int i);
    }
}
