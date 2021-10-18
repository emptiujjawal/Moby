package com.snq.nearbucks.adapter;

import android.app.Activity;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.object.DropDownObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rahul on 10/17/17.
 */

public class MyStringAdapter  extends BaseAdapter {

    private static final String LOG_TAG = MyStringAdapter.class.getSimpleName();

    private Context context_;
    private List<DropDownObject> items;

    public MyStringAdapter(Context context, List<DropDownObject> items) {
        this.context_ = context;
        this.items = items;
    }

    @Override
    public int getCount() {
        return items.size();
    }

    @Override
    public Object getItem(int position) {
        return items.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            LayoutInflater mInflater = (LayoutInflater)
                    context_.getSystemService(Activity.LAYOUT_INFLATER_SERVICE);

            convertView = mInflater.inflate(R.layout.text_item, null);
        }

        TextView tv = (TextView) convertView.findViewById(R.id.tv_text);

        DropDownObject dropDownObject = items.get(position);

        Log.d(LOG_TAG,"Text: " + dropDownObject.getCodeValue());

        tv.setText(dropDownObject.getCodeValue());

        return convertView;
    }
}