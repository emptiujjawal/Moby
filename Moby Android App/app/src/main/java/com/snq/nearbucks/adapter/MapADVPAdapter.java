package com.snq.nearbucks.adapter;

import android.content.Context;
import android.support.v4.view.PagerAdapter;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.TextView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.manager.ADManager;
import com.snq.nearbucks.object.AD;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * Created by rahul on 01-06-2015.
 */
public class MapADVPAdapter extends PagerAdapter {

    Context mContext;
    public List<AD> mADList;
    public OnCardItemInteractionListener onCardItemInteractionListener;

    public MapADVPAdapter(Context context, List<AD> adList) {
        mContext = context;
        onCardItemInteractionListener = (OnCardItemInteractionListener)context;
        mADList = adList;
    }

    public MapADVPAdapter(Context context) {
        this.mContext =context;
        onCardItemInteractionListener = (OnCardItemInteractionListener)context;
        mADList = new ArrayList<>();
    }

    public void update(){
        mADList = ADManager.getInstance().getAdList();
        notifyDataSetChanged();
    }

    @Override
    public int getCount() {
        return mADList.size();
    }

    @Override
    public boolean isViewFromObject(View view, Object object) {
        return view == ((FrameLayout) object);
    }

    @Override
    public Object instantiateItem(ViewGroup container, final int position) {
        LayoutInflater inflater = (LayoutInflater) mContext
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View view = inflater.inflate(R.layout.item_ad, null);

        ViewHolder holder = new ViewHolder(view);
        AD ad = mADList.get(position);
        if(!ad.getProductPhotoURL().isEmpty()) {
            Picasso.with(mContext).load(ad.getProductPhotoURL()).resize(640, 480).centerCrop().into(holder.iv_picture);
        }
        if(!ad.getCompanyPhotoURL().isEmpty()) {
            Picasso.with(mContext).load(ad.getCompanyPhotoURL()).resize(300, 300).centerCrop().into(holder.iv_company);
        }
        holder.tv_name.setText(ad.getProductName());
        holder.tv_wip.setText(ad.getCheckInReward()+"");
        holder.tv_qap.setText("₹"+ad.getTotalReward());
        view.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                onCardItemInteractionListener.onCardItemInteraction(position);
                //mContext.startActivity(new Intent(mContext, ADDetailActivity.class));
            }
        });
        container.addView(view);

        return view;
    }

    public static class ViewHolder{

        @InjectView(R.id.tv_ad_name)
        public TextView tv_name;
        @InjectView(R.id.tv_ad_wip)
        public TextView tv_wip;
        @InjectView(R.id.tv_ad_qap)
        public TextView tv_qap;
        @InjectView(R.id.tv_ad_distance)
        public TextView tv_distance;
        @InjectView(R.id.iv_ad_photo)
        public ImageView iv_picture;
        @InjectView(R.id.iv_ad_company)
        public ImageView iv_company;

        public ViewHolder(View v) {
            ButterKnife.inject(this, v);
        }
    }

    @Override
    public void destroyItem(ViewGroup container, int position, Object object) {
        container.removeView((FrameLayout) object);
    }

    @Override
    public float getPageWidth(int position) {
        return 0.7f;
    }

    @Override
    public int getItemPosition(Object object) {
        return PagerAdapter.POSITION_NONE;
    }

    public interface OnCardItemInteractionListener {
        // TODO: Update argument type and name
        void onCardItemInteraction(int position);
    }
}
