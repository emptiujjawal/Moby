package com.snq.nearbucks.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.object.Store;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * Created by rahul on 02-05-2015.
 */
public class StoreAdapter extends BaseAdapter {

    private List<Store> mStoreList;
    private Context mContext;
    //private SparseBooleanArray positionsMapper;
    //private int previousPosition;

    public StoreAdapter(Context context, List<Store> storeList) {
        mContext = context;
        mStoreList = storeList;
        //positionsMapper = new SparseBooleanArray();
    }


    @Override
    public int getCount() {
        return 10;
    }

    @Override
    public Object getItem(int i) {
        return mStoreList.get(i);
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
            view = inflater.inflate(R.layout.item_store, viewGroup, false);
            holder = new ViewHolder(view);
            view.setTag(holder);
        }
        else {
            holder = (ViewHolder) view.getTag();
        }
        return view;
    }
    public static class ViewHolder{

        @InjectView(R.id.tv_store_name)
        public TextView tv_name;
        @InjectView(R.id.tv_store_detail)
        public TextView tv_detail;
        @InjectView(R.id.tv_store_distance)
        public TextView tv_distance;
        @InjectView(R.id.iv_store_photo)
        public ImageView iv_picture;

        public ViewHolder(View v) {
            ButterKnife.inject(this, v);
        }
    }
}
