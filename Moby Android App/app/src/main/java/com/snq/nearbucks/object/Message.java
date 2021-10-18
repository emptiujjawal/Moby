package com.snq.nearbucks.object;

import android.util.Log;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

/**
 * Created by rahul on 11/6/17.
 */

public class Message {

    String title;
    String content;
    String dateTime;
    boolean seen;

    public Message(){}

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getDateTime() {
        return dateTime;
    }

    public void setDateTime(String dateTime) {
        this.dateTime = dateTime;
    }

    public boolean isSeen() {
        return seen;
    }

    public void setSeen(boolean seen) {
        this.seen = seen;
    }

    public static Message fromJSON(JSONObject messageObj) throws JSONException {
        Message message = new Message();
        // Deserialize json into object fields
        message.setTitle(messageObj.getString("title"));
        message.setContent(messageObj.getString("content"));
        message.setDateTime(messageObj.getString("datetime"));
        message.setSeen(messageObj.getBoolean("message_seen"));
        return message;
    }
}
