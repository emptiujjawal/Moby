package com.snq.nearbucks.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.object.UserTransaction;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * Created by rahul on 02-05-2015.
 */
public class TransactionAdapter extends BaseAdapter {

    private List<UserTransaction> userTransactions;
    private Context mContext;
    //private SparseBooleanArray positionsMapper;
    //private int previousPosition;

    public TransactionAdapter(Context context, List<UserTransaction> userTransactions) {
        mContext = context;
        this.userTransactions = userTransactions;
        //positionsMapper = new SparseBooleanArray();
    }


    @Override
    public int getCount() {
        return userTransactions.size();
    }

    @Override
    public Object getItem(int i) {
        return userTransactions.get(i);
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
            view = inflater.inflate(R.layout.item_transaction, viewGroup, false);
            holder = new ViewHolder(view);
            view.setTag(holder);
        }
        else {
            holder = (ViewHolder) view.getTag();
        }
        UserTransaction ut= userTransactions.get(position);
        Picasso.with(mContext).load(ut.getAdProductPhotoURL()).resize(1280,720).centerCrop().into(holder.iv_product_picture);
        holder.tv_name.setText(ut.getAdName());
        if(ut.getType()==0){
            holder.iv_type.setImageResource(R.drawable.ic_arrow_upward_white_24dp);
            holder.tv_activity_typeName.setText("Debit");
            holder.tv_activity_reward.setText("Rs. "+ut.getAmount()+"");
        }else{
            holder.iv_type.setImageResource(R.drawable.ic_arrow_downward_white_24dp);
            holder.tv_activity_typeName.setText("Credit");
            holder.tv_activity_reward.setText("Rs. "+ut.getAmount()+"");
        }
        holder.tv_activity_date.setText(ut.getDate());
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
