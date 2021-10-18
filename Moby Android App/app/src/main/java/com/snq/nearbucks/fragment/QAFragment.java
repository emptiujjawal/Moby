package com.snq.nearbucks.fragment;

import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.firebase.auth.FirebaseAuth;
import com.snq.nearbucks.R;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.manager.ADManager;
import com.snq.nearbucks.manager.PBManager;
import com.snq.nearbucks.object.AD;
import com.snq.nearbucks.object.Question;
import com.snq.nearbucks.object.Submission;
import com.snq.nearbucks.utils.URL;
import com.squareup.picasso.Picasso;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * A simple {@link Fragment} subclass.
 */
public class QAFragment extends Fragment implements View.OnClickListener {

    @InjectView(R.id.iv_add_productPhoto)
    ImageView iv_productPhoto;
    @InjectView(R.id.tv_add_productName)
    TextView tv_productName;
    @InjectView(R.id.tv_add_companyName)
    TextView tv_companyName;
    @InjectView(R.id.tv_add_question)
    TextView tv_question;
    @InjectView(R.id.tv_add_option1)
    TextView tv_option1;
    @InjectView(R.id.tv_add_option2)
    TextView tv_option2;
    @InjectView(R.id.tv_add_option3)
    TextView tv_option3;
    @InjectView(R.id.tv_add_option4)
    TextView tv_option4;
    @InjectView(R.id.iv_add_previous)
    ImageView iv_previous;
    @InjectView(R.id.iv_add_next)
    ImageView iv_next;
    @InjectView(R.id.iv_qa_close)
    ImageView iv_close;
    long uid;
    AD ad;
    int qNo = 0;
    public QAFragment() {
        // Required empty public constructor
    }

    public static QAFragment newInstance(long uid) {
        QAFragment frag = new QAFragment();
        Bundle args = new Bundle();
        args.putLong("uid", uid);
        frag.setArguments(args);
        return frag;
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view =  inflater.inflate(R.layout.fragment_qa, container, false);
        ButterKnife.inject(this,view);
        tv_option1.setOnClickListener(this);
        tv_option2.setOnClickListener(this);
        tv_option3.setOnClickListener(this);
        tv_option4.setOnClickListener(this);
        iv_next.setOnClickListener(this);
        iv_previous.setOnClickListener(this);
        iv_close.setOnClickListener(this);
        uid = getArguments().getLong("uid",-1);
        ad = ADManager.getInstance().getADByUID(uid);
        setUpAD();
        setQuestion();
        return view;
    }

    private void setUpAD() {
        if(!ad.getProductPhotoURL().isEmpty()) {
            Picasso.with(getActivity()).load(ad.getProductPhotoURL()).resize(640, 480).centerCrop().into(iv_productPhoto);
        }tv_productName.setText(ad.getProductName());
        tv_companyName.setText(ad.getCompanyName()+"");
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.iv_qa_close:{
                FragmentManager fm = getActivity().getSupportFragmentManager();
                if(fm.getBackStackEntryCount()>0) {
                    fm.popBackStack();
                }
                break;
            }
            case R.id.tv_add_option1:{
                Submission submission = new Submission();
                submission.setAnswer(1);
                submission.setQuestionID(ad.getQuestions().get(qNo).getUid());
                ad.addSubmission(qNo,submission);
                markAnswer(1);
                //waitForAnswer();
                break;
            }
            case R.id.tv_add_option2:{
                Submission submission = new Submission();
                submission.setAnswer(2);
                submission.setQuestionID(ad.getQuestions().get(qNo).getUid());
                ad.addSubmission(qNo,submission);
                markAnswer(2);
                //waitForAnswer();
                break;
            }
            case R.id.tv_add_option3:{
                Submission submission = new Submission();
                submission.setAnswer(3);
                submission.setQuestionID(ad.getQuestions().get(qNo).getUid());
                ad.addSubmission(qNo,submission);
                markAnswer(3);
                //waitForAnswer();
                break;
            }
            case R.id.tv_add_option4:{
                Submission submission = new Submission();
                submission.setAnswer(4);
                submission.setQuestionID(ad.getQuestions().get(qNo).getUid());
                ad.addSubmission(qNo,submission);
                markAnswer(4);
                //waitForAnswer();
                break;
            }
            case R.id.iv_add_next:{
                if(qNo==2){
                    if(areAllQuestionsAnswered()) {
                        submitSubmission();
                    }else{
                        Toast.makeText(getActivity(),"Please answer all the questions!",Toast.LENGTH_SHORT).show();
                    }
                }else {
                    nextQuestion();
                }
                break;
            }
            case R.id.iv_add_previous:{
                previousQuestion();
                break;
            }
        }
    }

    private void waitForAnswer() {
        Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            public void run() {
                nextQuestion();
            }
        }, 1000);
    }

    private boolean areAllQuestionsAnswered() {
        for(Question q: ad.getQuestions()){
            if(q.getSubmission()==null){
                return false;
            }
        }
        return true;
    }

    private void markAnswer(int i) {
        clearAll();
        switch (i){
            case 1:{
                tv_option1.setBackgroundColor(getResources().getColor(R.color.flat_green));
                break;
            }
            case 2:{
                tv_option2.setBackgroundColor(getResources().getColor(R.color.flat_green));
                break;
            }
            case 3:{
                tv_option3.setBackgroundColor(getResources().getColor(R.color.flat_green));
                break;
            }
            case 4:{
                tv_option4.setBackgroundColor(getResources().getColor(R.color.flat_green));
                break;
            }
        }

        if(qNo==2 && ad.getQuestions().get(qNo).getSubmission()!=null){
            iv_next.setImageResource(R.drawable.ic_done_white_24dp);
            iv_next.setColorFilter(getActivity().getResources().getColor(R.color.gray5));
        }else{
            iv_next.setImageResource(R.drawable.ic_keyboard_arrow_right_white_24dp);
            iv_next.setColorFilter(getActivity().getResources().getColor(R.color.gray5));
        }
    }

    private void clearAll() {
        tv_option1.setBackgroundColor(getResources().getColor(R.color.accent));
        tv_option2.setBackgroundColor(getResources().getColor(R.color.accent));
        tv_option3.setBackgroundColor(getResources().getColor(R.color.accent));
        tv_option4.setBackgroundColor(getResources().getColor(R.color.accent));
    }

    private void nextQuestion() {
        if(qNo<2){
            qNo+=1;
        }
        setQuestion();
    }

    private void previousQuestion() {
        if(qNo>0){
            qNo-=1;
            setQuestion();
        }
    }

    private void submitSubmission() {
        PBManager.getInstance().showPB(getActivity(), "Submitting answers...", false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                URL.SERVER_URL,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d(QAFragment.class.getName(), response.toString());
                        PBManager.getInstance().cancelPB();
                        try {
                            JSONObject res = new JSONObject(response);
                            if(res.has("error")) {
                                boolean error = res.getBoolean("error");
                                if (error) {
                                    if(res.has("message")) {
                                        String message = res.getString("message");
                                        Toast.makeText(getActivity(), message, Toast.LENGTH_LONG).show();
                                        return;
                                    }
                                }
                            }
                            if(res.has("message")) {
                                JSONObject message = res.getJSONObject("message");
                                if(message.has("display_message")) {
                                    String toastMessage = message.getString("display_message");
                                    Toast.makeText(getActivity(), toastMessage, Toast.LENGTH_LONG).show();
                                    if(message.has("credit_amount") &&message.has("wallet_amount") ) {
                                        showDialog(message.getString("credit_amount"), message.getString("wallet_amount"));
                                    }
                                    //Toast.makeText(getActivity(), "Quiz submission successful!", Toast.LENGTH_LONG).show();
                                    FragmentManager fm = getActivity().getSupportFragmentManager();
                                    if (fm.getBackStackEntryCount() > 0) {
                                        fm.popBackStack();
                                    }
                                    if (ad.getDealOff() != null && !ad.getDealOff().isEmpty()) {
                                        BuyProductFragment myf = BuyProductFragment.newInstance(uid);
                                        FragmentTransaction transaction = fm.beginTransaction();
                                        transaction.replace(R.id.fl_maps_adDetail, myf);
                                        transaction.addToBackStack(null);
                                        transaction.commit();
                                    }
                                }
                            }
                        } catch (JSONException e) {
                            Toast.makeText(getActivity(), "Error!", Toast.LENGTH_LONG).show();
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                Log.d(QAFragment.class.getName(), "Error: " + error.getMessage());
                PBManager.getInstance().cancelPB();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(URL.REQUEST_IDENTIFIER, URL.SUBMISSION_IDENTIFIER);
                params.put(URL.PARAMETER_USER_CONTACT, FirebaseAuth.getInstance().getCurrentUser().getPhoneNumber());
                params.put(URL.PARAMETER_QUIZ_ANSWERS, getAnswers());
                return params;
            }

        };

// Adding request to request queue
        BApplication.getInstance().addToRequestQueue(stringRequest, URL.CHECK_IN_IDENTIFIER);
/*        Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            public void run() {
                PBManager.getInstance().cancelPB();
                Toast.makeText(getActivity(),"Answers successfully submitted!",Toast.LENGTH_LONG).show();
                FragmentManager fm = getActivity().getSupportFragmentManager();
                if(fm.getBackStackEntryCount()>0) {
                    fm.popBackStack();
                }
                BuyProductFragment myf = BuyProductFragment.newInstance(uid);
                FragmentTransaction transaction = fm.beginTransaction();
                transaction.replace(R.id.fl_maps_adDetail, myf);
                transaction.addToBackStack(null);
                transaction.commit();
            }
        }, 3000);*/
    }

    private void showDialog(String credit_amount, String wallet_amount) {
        FragmentManager fm = getActivity().getSupportFragmentManager();
        CheckInSuccessDF checkInSuccessDF = CheckInSuccessDF.newInstance("Congratulations!\nRs. "+credit_amount+"\n Credited to your Paytm account!\nby MobyAds.");
        checkInSuccessDF.show(fm, "checkInSuccessDF");
    }
    private String getAnswers() {
        JSONArray jsonArray = new JSONArray();
        for(int i=0;i<ad.getQuestions().size();i++) {
            JSONObject q = new JSONObject();
            try {
                q.put("quiz_id", ad.getQuestions().get(i).getUid());
                q.put("answer", ad.getQuestions().get(i).getSubmission().getAnswer());
                jsonArray.put(q);
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
        return jsonArray.toString();
    }

    private void setQuestion() {
        clearAll();
        tv_question.setText("Q."+(qNo+1)+" "+ad.getQuestions().get(qNo).getQuestion());
        tv_option1.setText(ad.getQuestions().get(qNo).getOptionList().get(0));
        tv_option2.setText(ad.getQuestions().get(qNo).getOptionList().get(1));
        tv_option3.setText(ad.getQuestions().get(qNo).getOptionList().get(2));
        tv_option4.setText(ad.getQuestions().get(qNo).getOptionList().get(3));
        if(ad.getQuestions().get(qNo).getSubmission()!=null){
            int answer = ad.getQuestions().get(qNo).getSubmission().getAnswer();
            markAnswer(answer);
        }
        if(qNo==0){
            iv_previous.setEnabled(false);
        }else{
            iv_previous.setEnabled(true);
        }
        if(qNo==2 && ad.getQuestions().get(qNo).getSubmission()!=null){
            iv_next.setImageResource(R.drawable.ic_done_white_24dp);
            iv_next.setColorFilter(getActivity().getResources().getColor(R.color.gray5));
        }else{
            iv_next.setImageResource(R.drawable.ic_keyboard_arrow_right_white_24dp);
            iv_next.setColorFilter(getActivity().getResources().getColor(R.color.gray5));
        }
    }
}
