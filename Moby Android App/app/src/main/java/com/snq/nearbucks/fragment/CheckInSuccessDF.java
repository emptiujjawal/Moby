package com.snq.nearbucks.fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.DialogFragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import com.snq.nearbucks.R;

/**
 * Created by rahul on 5/25/17.
 */

public class CheckInSuccessDF extends DialogFragment {
    public CheckInSuccessDF() {
    }

    public static CheckInSuccessDF newInstance(String message) {
        CheckInSuccessDF frag = new CheckInSuccessDF();
        Bundle args = new Bundle();
        args.putString("message", message);
        frag.setArguments(args);
        return frag;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        return inflater.inflate(R.layout.dialog_check_in_success, container);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        TextView tv_message = (TextView) view.findViewById(R.id.tv_cis_message);
        tv_message.setText(getArguments().getString("message"));
        Button b_ok = (Button)view.findViewById(R.id.b_cis_ok);
        b_ok.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dismiss();
            }
        });
    }
}
