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
import com.snq.nearbucks.object.BD;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

public class BDAdapter extends BaseAdapter {

    private List<BD> mBDList;
    private Context mContext;
    //private SparseBooleanArray positionsMapper;
    //private int previousPosition;

    public BDAdapter(Context context, List<BD> adList) {
        mContext = context;
        mBDList = adList;
        //positionsMapper = new SparseBooleanArray();
    }

    @Override
    public int getCount() {
        return mBDList.size();
    }

    @Override
    public Object getItem(int i) {
        return mBDList.get(i);
    }

    @Override
    public long getItemId(int i) {
        return i;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        final int position = i;
        BDAdapter.ViewHolder holder = null;

        if (view == null) {
            LayoutInflater inflater = (LayoutInflater) mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view = inflater.inflate(R.layout.item_ad_d1, viewGroup, false);
            holder = new BDAdapter.ViewHolder(view);
            view.setTag(holder);
        }
        else {
            holder = (BDAdapter.ViewHolder) view.getTag();
        }
        BD bd = mBDList.get(position);
        Picasso.with(mContext).load(bd.getProductPhotoURL()).resize(1280,720).centerCrop().into(holder.iv_product_picture);
        Picasso.with(mContext).load(bd.getCompanyPhotoURL()).into(holder.iv_picture);
        holder.tv_name.setText(bd.getProductName());
        holder.tv_wip.setText("Rs. "+bd.getCheckInReward()+"");
        holder.tv_qap.setText("Rs. "+bd.getQuizReward()+"");
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
