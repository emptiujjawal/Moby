package com.snq.nearbucks.activity;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.config.BApplication;
import com.snq.nearbucks.listener.OnLocationTypeChangedListener;
import com.snq.nearbucks.listener.OnSalaryChangedListener;
import com.snq.nearbucks.manager.AccountManager;
import com.snq.nearbucks.manager.NBManager;
import com.snq.nearbucks.service.DeviceLocationService;

import butterknife.ButterKnife;
import butterknife.InjectView;

public class SelectLocationActivity extends AppCompatActivity {

    @InjectView(R.id.toolbar)
    Toolbar toolbar;
    @InjectView(R.id.b_sl_myLocation)
    Button b_sl_myLocation;
    @InjectView(R.id.et_stateList_search)
    EditText et_search;
    @InjectView(R.id.lv_stateList)
    ListView lv_areaList;
    private ArrayAdapter<String> mAdapter;
    String [] areas;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_select_location);
        ButterKnife.inject(this);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("Select Your Location");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        b_sl_myLocation.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                NBManager.getInstance().setUserLocationType(0);
                NBManager.getInstance().setUserSelectedState("");
                for (OnLocationTypeChangedListener listener : BApplication.getInstance().getUIListeners(OnLocationTypeChangedListener.class)) {
                    listener.onLocationTypeChanged();
                }
                startService(new Intent(SelectLocationActivity.this, DeviceLocationService.class));
                finish();
            }
        });
        setUpAdapter();
    }
    private void setUpAdapter() {
        // Adding items to listview
        areas = getResources().getStringArray(R.array.india_states);
        mAdapter = new ArrayAdapter<String>(this, R.layout.item_state_name, R.id.tv_stateName,areas);
        lv_areaList.setAdapter(mAdapter);
        lv_areaList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                String stateName = adapterView.getItemAtPosition(i).toString();
                NBManager.getInstance().setUserLocationType(1);
                NBManager.getInstance().setUserSelectedState(stateName);
                for (OnLocationTypeChangedListener listener : BApplication.getInstance().getUIListeners(OnLocationTypeChangedListener.class)) {
                    listener.onLocationTypeChanged();
                }
                stopService(new Intent(SelectLocationActivity.this, DeviceLocationService.class));
                finish();
            }
        });
        et_search.addTextChangedListener(new TextWatcher() {

            @Override
            public void onTextChanged(CharSequence cs, int arg1, int arg2, int arg3) {
                // When user changed the Text
                mAdapter.getFilter().filter(cs);
            }

            @Override
            public void beforeTextChanged(CharSequence arg0, int arg1, int arg2,
                                          int arg3) {
                // TODO Auto-generated method stub

            }

            @Override
            public void afterTextChanged(Editable arg0) {
                // TODO Auto-generated method stub
            }
        });
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}