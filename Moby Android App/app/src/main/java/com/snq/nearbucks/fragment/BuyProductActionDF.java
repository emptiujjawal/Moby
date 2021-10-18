package com.snq.nearbucks.fragment;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.DialogFragment;
import android.support.v4.app.FragmentManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import com.snq.nearbucks.R;

/**
 * Created by rahul on 5/25/17.
 */

public class BuyProductActionDF extends DialogFragment {
    public BuyProductActionDF() {
    }

    public static BuyProductActionDF newInstance(int type, String message, String coupon, String url) {
        BuyProductActionDF frag = new BuyProductActionDF();
        Bundle args = new Bundle();
        args.putString("message", message);
        args.putString("coupon", coupon);
        args.putString("url", url);
        args.putInt("type", type);
        frag.setArguments(args);
        return frag;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        return inflater.inflate(R.layout.dialog_buy_product_action, container);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        TextView tv_message = (TextView) view.findViewById(R.id.tv_cis_message);
        tv_message.setText(getArguments().getString("message"));
        TextView tv_coupon = (TextView) view.findViewById(R.id.tv_bpa_couponCode);
        String coupon = getArguments().getString("coupon");
        Button b_ok = (Button)view.findViewById(R.id.b_cis_ok);
        b_ok.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                int type = getArguments().getInt("type");
                if(type==1){
                    String url = getArguments().getString("url");
                    Intent i = new Intent(Intent.ACTION_VIEW);
                    i.setData(Uri.parse(url));
                    startActivity(i);
                }else if(type == 0){
                    FragmentManager fm = getActivity().getSupportFragmentManager();
                    if (fm.getBackStackEntryCount() > 0) {
                        fm.popBackStack();
                    }
                }
                dismiss();
            }
        });
    }
}
