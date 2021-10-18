package com.snq.nearbucks.fragment;

import android.app.Dialog;
import android.os.Bundle;
import android.support.v4.app.DialogFragment;
import android.support.v7.app.AlertDialog;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.adapter.MyStringAdapter;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.listener.OnDropDownValueChangedListener;
import com.snq.nearbucks.listener.OnSalaryChangedListener;
import com.snq.nearbucks.object.DropDownObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rahul on 5/25/17.
 */

public class SelectSalaryDF extends DialogFragment {
    public SelectSalaryDF() {
    }

    public static SelectSalaryDF newInstance(int type, ArrayList<DropDownObject> array) {
        SelectSalaryDF frag = new SelectSalaryDF();
        Bundle args = new Bundle();
        args.putSerializable("groupArray", array);
        args.putInt("type", type);
        frag.setArguments(args);
        return frag;
    }
    int type;
    /**
     * The system calls this only when creating the layout in a dialog.
     */
    @Override
    public Dialog onCreateDialog(Bundle savedInstanceState) {

        ArrayList<DropDownObject> values = (ArrayList<DropDownObject>) getArguments().getSerializable("groupArray");
        type = getArguments().getInt("type");
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        ListView modeList = new ListView(getActivity());
        MyStringAdapter adapter = new MyStringAdapter(getActivity(), values);
        modeList.setAdapter(adapter);
        builder.setView(modeList);
//        builder.setItems(R.array.salary_option, new DialogInterface.OnClickListener() {
//            public void onClick(DialogInterface dialog, int pos) {
//                for (OnSalaryChangedListener listener : BApplication.getInstance().getUIListeners(OnSalaryChangedListener.class)) {
//                    listener.onSalaryChanged(getActivity().getResources().getStringArray(R.array.salary_option)[pos]);
//                }
//            }
//        });
        modeList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                for (OnDropDownValueChangedListener listener : BApplication.getInstance().getUIListeners(OnDropDownValueChangedListener.class)) {
                    listener.OnDropDownValueChanged(type,i);
                }
                dismiss();
            }
        });
        return builder.create();
    }

}