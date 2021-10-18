package com.snq.nearbucks.object;

import android.text.TextUtils;
import android.util.Log;

import com.orm.SugarRecord;
import com.orm.dsl.Ignore;
import com.orm.dsl.Unique;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by rahul on 4/1/17.
 */
public class Question extends SugarRecord {

    @Unique
    private long uid;
    private String question;
    private String options;
    @Ignore
    private List<String> optionList;
    private String answer;
    private long ADID;
    @Ignore
    private Submission submission;

    public Question() {
    }

    public Question(int uid, String question, String options, String answer, long ADID) {
        this.uid = uid;
        this.question = question;
        this.options = options;
        this.answer = answer;
        this.ADID = ADID;
    }

    public long getUid() {
        return uid;
    }

    public void setUid(long uid) {
        this.uid = uid;
    }

    public String getQuestion() {
        return question;
    }

    public void setQuestion(String question) {
        this.question = question;
    }

    public String getOptions() {
        return options;
    }

    public void setOptions(String options) {
        this.options = options;
    }

    public String getAnswer() {
        return answer;
    }

    public void setAnswer(String answer) {
        this.answer = answer;
    }

    public long getADID() {
        return ADID;
    }

    public void setADID(long ADID) {
        this.ADID = ADID;
    }

    public List<String> getOptionList() {
        if (optionList == null || optionList.isEmpty()) {
            optionList = Arrays.asList(options.split(","));
        }
        return optionList;
    }

    public void setOptionList(List<String> optionList) {
        this.optionList = optionList;
    }

    public Submission getSubmission() {
        return submission;
    }

    public void setSubmission(Submission submission) {
        this.submission = submission;
    }

    public static Question fromJSON(JSONObject questionObj, long adid) throws JSONException {
        long uid = Long.parseLong(questionObj.getString("quiz_id"));
        List<Question> questions = Question.find(Question.class, "uid = ? ", String.valueOf(uid));
        Question question;
        if(!questions.isEmpty()){
            question = questions.get(0);
        }else{
            question = new Question();
        }
        // Deserialize json into object fields
        question.setUid(Long.parseLong(questionObj.getString("quiz_id")));
        question.setQuestion(questionObj.getString("question"));
        question.setOptions(convertToString(questionObj.getJSONArray("options")));
        question.setADID(adid);
        long id = question.save();
        Log.d("Question id", question.getId() + " or ID "+id);
        // Return new object
        return question;
    }

    private static String convertToString(JSONArray options) {
        ArrayList<String> stringArray = new ArrayList<String>();
        for (int i = 0, count = options.length(); i < count; i++) {
            try {
                String value = options.getString(i);
                stringArray.add(value);
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
        return TextUtils.join(",", stringArray.toArray());
    }
}
