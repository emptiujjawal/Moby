package com.snq.nearbucks.fragment;


import android.content.ClipData;
import android.content.ClipboardManager;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.snq.nearbucks.R;
import com.snq.nearbucks.manager.ADManager;
import com.snq.nearbucks.object.AD;
import com.squareup.picasso.Picasso;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * A simple {@link Fragment} subclass.
 */
public class BuyProductFragment extends Fragment implements View.OnClickListener {

    @InjectView(R.id.iv_bp_productPhoto)
    ImageView iv_productPhoto;
    @InjectView(R.id.tv_bp_productName)
    TextView tv_productName;
    @InjectView(R.id.tv_bp_companyName)
    TextView tv_companyName;
    @InjectView(R.id.tv_bp_dealOff)
    TextView tv_bp_dealOff;
    @InjectView(R.id.tv_bp_couponCode1)
    TextView tv_bp_couponCode1;
    @InjectView(R.id.tv_bp_couponCode2)
    TextView tv_bp_couponCode2;
    @InjectView(R.id.b_add_buyNow)
    Button b_add_buyNow;
    @InjectView(R.id.iv_bp_close)
    ImageView iv_close;
    @InjectView(R.id.ll_buy_from_store)
    LinearLayout ll_buyFromStore;
    @InjectView(R.id.ll_buy_from_online)
    LinearLayout ll_buyFromOnline;
    @InjectView(R.id.ll_buy_cancel)
    LinearLayout ll_buyCancel;

    long uid;
    private AD ad;
    public BuyProductFragment() {
        // Required empty public constructor
    }


    public static BuyProductFragment newInstance(long uid) {
        BuyProductFragment frag = new BuyProductFragment();
        Bundle args = new Bundle();
        args.putLong("uid", uid);
        frag.setArguments(args);
        return frag;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view =  inflater.inflate(R.layout.fragment_buy_product, container, false);
        ButterKnife.inject(this,view);
        uid = getArguments().getLong("uid",-1);
        ad = ADManager.getInstance().getADByUID(uid);
        iv_close.setOnClickListener(this);
        ll_buyCancel.setOnClickListener(this);
        ll_buyFromOnline.setOnClickListener(this);
        ll_buyFromStore.setOnClickListener(this);
        setUpAD();
        return view;
    }
    private void setUpAD() {
        if(!ad.getProductPhotoURL().isEmpty()) {
            Picasso.with(getActivity()).load(ad.getProductPhotoURL()).resize(640, 480).centerCrop().into(iv_productPhoto);
        }tv_productName.setText(ad.getProductName());
        tv_companyName.setText(ad.getCompanyName()+"");
        tv_bp_dealOff.setText("Do you want to buy this product now?");
        tv_bp_couponCode1.setText(ad.getDealCouponCode());
        tv_bp_couponCode2.setText(ad.getDealCouponCode());
        b_add_buyNow.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String url = ad.getDealBuyLink();
                Intent i = new Intent(Intent.ACTION_VIEW);
                i.setData(Uri.parse(url));
                startActivity(i);
            }
        });
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.iv_bp_close: {
                FragmentManager fm = getActivity().getSupportFragmentManager();
                if (fm.getBackStackEntryCount() > 0) {
                    fm.popBackStack();
                }
                break;
            }
            case R.id.ll_buy_cancel: {
                showNoDialog(0);
                break;
            }
            case R.id.ll_buy_from_online: {
                showDialog(1);
                //setClipboardText(ad.getDealCouponCode());
                break;
            }
            case R.id.ll_buy_from_store: {
                showDialog(2);
                //setClipboardText(ad.getDealCouponCode());
                break;
            }
        }
    }

    private void setClipboardText(String coupon){
        ClipboardManager clipboard = (ClipboardManager)getActivity().getSystemService(Context.CLIPBOARD_SERVICE);
        ClipData clip = ClipData.newPlainText("MOBY Coupon", coupon);
        clipboard.setPrimaryClip(clip);
        Toast toast = Toast.makeText(getActivity(),
                "Your COUPON CODE is copied!", Toast.LENGTH_SHORT);
        toast.show();
    }


    private void showDialog(int type) {
        FragmentManager fm = getActivity().getSupportFragmentManager();
        BuyProductYesActionDF buyProductYesActionDF = BuyProductYesActionDF.newInstance(type,"Use this coupon code to avail discount on your purchase!",ad.getDealCouponCode(),ad.getDealBuyLink());
        buyProductYesActionDF.show(fm, "buyProductYesActionDF");
    }
    private void showNoDialog(int type) {
        FragmentManager fm = getActivity().getSupportFragmentManager();
        BuyProductActionDF buyProductActionDF = BuyProductActionDF.newInstance(type,"Are you sure you don't want to purchase this product now?","","");
        buyProductActionDF.show(fm, "buyProductActionDF");
    }
}
