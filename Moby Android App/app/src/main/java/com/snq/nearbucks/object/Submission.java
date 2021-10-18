package com.snq.nearbucks.object;

import com.orm.SugarRecord;
import com.orm.dsl.Unique;

/**
 * Created by rahul on 4/1/17.
 */
public class Submission extends SugarRecord {

    @Unique
    private long uid;
    private long questionID;
    private int answer;
    private boolean status;

    public Submission(){}

    public long getUid() {
        return uid;
    }

    public void setUid(long uid) {
        this.uid = uid;
    }

    public long getQuestionID() {
        return questionID;
    }

    public void setQuestionID(long questionID) {
        this.questionID = questionID;
    }

    public int getAnswer() {
        return answer;
    }

    public void setAnswer(int answer) {
        this.answer = answer;
    }

    public boolean isStatus() {
        return status;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }
}
