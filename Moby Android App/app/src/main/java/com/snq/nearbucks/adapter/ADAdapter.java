package com.snq.nearbucks.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.object.AD;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * Created by rahul on 02-05-2015.
 */
public class ADAdapter extends BaseAdapter {

    private List<AD> mADList;
    private Context mContext;
    //private SparseBooleanArray positionsMapper;
    //private int previousPosition;

    public ADAdapter(Context context, List<AD> adList) {
        mContext = context;
        mADList = adList;
        //positionsMapper = new SparseBooleanArray();
    }


    @Override
    public int getCount() {
        return mADList.size();
    }

    @Override
    public Object getItem(int i) {
        return mADList.get(i);
    }

    @Override
    public long getItemId(int i) {
        return i;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        final int position = i;
        ViewHolder holder = null;

        if (view == null) {
            LayoutInflater inflater = (LayoutInflater) mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view = inflater.inflate(R.layout.item_ad_d1, viewGroup, false);
            holder = new ViewHolder(view);
            view.setTag(holder);
        }
        else {
            holder = (ViewHolder) view.getTag();
        }
        AD ad = mADList.get(position);
        Picasso.with(mContext).load(ad.getProductPhotoURL()).resize(1280,720).centerCrop().into(holder.iv_product_picture);
        Picasso.with(mContext).load(ad.getCompanyPhotoURL()).into(holder.iv_picture);
        holder.tv_name.setText(ad.getProductName());
        holder.tv_wip.setText("Rs. "+ad.getCheckInReward()+"");
        holder.tv_qap.setText("Rs. "+ad.getQuizReward()+"");
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
        @InjectView(R.id.iv_ad_product_photo)
        public ImageView iv_product_picture;

        public ViewHolder(View v) {
            ButterKnife.inject(this, v);
        }
    }
}
