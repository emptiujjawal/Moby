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
import com.snq.nearbucks.object.Message;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * Created by rahul on 02-05-2015.
 */
public class NotificationAdapter extends BaseAdapter {

    private List<Message> messageList;
    private Context mContext;

    public NotificationAdapter(Context context, List<Message> messageList) {
        mContext = context;
        this.messageList = messageList;
    }


    @Override
    public int getCount() {
        return messageList.size();
    }

    @Override
    public Object getItem(int i) {
        return messageList.get(i);
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
            view = inflater.inflate(R.layout.item_notification, viewGroup, false);
            holder = new ViewHolder(view);
            view.setTag(holder);
        }
        else {
            holder = (ViewHolder) view.getTag();
        }
        Message message = messageList.get(position);
        holder.tv_message_title.setText(message.getTitle());
        holder.tv_message_date.setText(message.getDateTime());
        holder.tv_message_content.setText(message.getContent());
        return view;
    }
    public static class ViewHolder{

        @InjectView(R.id.tv_message_title)
        public TextView tv_message_title;
        @InjectView(R.id.tv_message_date)
        public TextView tv_message_date;
        @InjectView(R.id.tv_message_content)
        public TextView tv_message_content;

        public ViewHolder(View v) {
            ButterKnife.inject(this, v);
        }
    }
}
