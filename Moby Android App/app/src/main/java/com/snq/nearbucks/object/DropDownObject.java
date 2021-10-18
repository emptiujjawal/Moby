package com.snq.nearbucks.object;

import java.io.Serializable;

/**
 * Created by rahul on 10/17/17.
 */

public class DropDownObject implements Serializable {

    private int codeID;
    private String codeValue;
    private boolean selected;

    public DropDownObject(){}

    public String getCodeID() {
        return codeID+"";
    }

    public void setCodeID(int codeID) {
        this.codeID = codeID;
    }

    public String getCodeValue() {
        return codeValue;
    }

    public void setCodeValue(String codeValue) {
        this.codeValue = codeValue;
    }

    public boolean isSelected() {
        return selected;
    }

    public void setSelected(boolean selected) {
        this.selected = selected;
    }
}
