package com.snq.nearbucks.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.object.UserActivity;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * Created by rahul on 02-05-2015.
 */
public class ActivityAdapter extends BaseAdapter {

    private List<UserActivity> mActivityList;
    private Context mContext;
    //private SparseBooleanArray positionsMapper;
    //private int previousPosition;

    public ActivityAdapter(Context context, List<UserActivity> adList) {
        mContext = context;
        mActivityList = adList;
        //positionsMapper = new SparseBooleanArray();
    }


    @Override
    public int getCount() {
        return mActivityList.size();
    }

    @Override
    public Object getItem(int i) {
        return mActivityList.get(i);
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
            view = inflater.inflate(R.layout.item_activity, viewGroup, false);
            holder = new ViewHolder(view);
            view.setTag(holder);
        }
        else {
            holder = (ViewHolder) view.getTag();
        }
        UserActivity ua = mActivityList.get(position);
        Picasso.with(mContext).load(ua.getAdProductPhotoURL()).resize(1280,720).centerCrop().into(holder.iv_product_picture);
        holder.tv_name.setText(ua.getAdName());
        if(ua.getType()==0){
            holder.iv_type.setImageResource(R.drawable.ic_my_location_white_24dp);
            holder.tv_activity_typeName.setText("Check in");
            holder.tv_activity_reward.setText("Rs. "+ua.getRewardGranted()+"");
        }else{
            holder.iv_type.setImageResource(R.drawable.ic_question_answer_white_24dp);
            holder.tv_activity_typeName.setText("Quiz");
            holder.tv_activity_reward.setText("Rs. "+ua.getRewardGranted()+"");
        }
        holder.tv_activity_date.setText(ua.getDate());
        return view;
    }
    public static class ViewHolder{

        @InjectView(R.id.tv_activity_adName)
        public TextView tv_name;
        @InjectView(R.id.tv_activity_reward)
        public TextView tv_activity_reward;
        @InjectView(R.id.tv_activity_date)
        public TextView tv_activity_date;
        @InjectView(R.id.iv_activity_type)
        public ImageView iv_type;
        @InjectView(R.id.tv_activity_typeName)
        public TextView tv_activity_typeName;
        @InjectView(R.id.iv_activity_productPhoto)
        public ImageView iv_product_picture;

        public ViewHolder(View v) {
            ButterKnife.inject(this, v);
        }
    }
}
