package com.snq.nearbucks.fragment;

import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.adapter.ADAdapter;
import com.snq.nearbucks.adapter.MapADVPAdapter;
import com.snq.nearbucks.manager.ADManager;
import com.snq.nearbucks.object.AD;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link StoresFragment.OnFragmentInteractionListener} interface
 * to handle interaction events.
 */
public class ADsFragment extends Fragment {

    @InjectView(R.id.lv_ads)
    ListView lv_ads;
    private ADAdapter mAdapter;
    public List<AD> adList;

    public MapADVPAdapter.OnCardItemInteractionListener onCardItemInteractionListener;

    public ADsFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_ads, container, false);
        ButterKnife.inject(this, view);
        onCardItemInteractionListener = (MapADVPAdapter.OnCardItemInteractionListener)getActivity();
        setUpHostelAdapter();
        return view;
    }


    private void setUpHostelAdapter() {
        adList = ADManager.getInstance().getAdList();
        mAdapter = new ADAdapter(getActivity(), adList);
        //isLoadingMore = true;
        lv_ads.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                onCardItemInteractionListener.onCardItemInteraction(i);
            }
        });
        lv_ads.setAdapter(mAdapter);
        //lv_hostel.setScrollingCacheEnabled(false);
        /*lv_hostel.setOnLoadMoreListener(new LoadMoreListView.OnLoadMoreListener() {
            @Override
            public void onLoadMore() {
                if (!isLoadingMore &&!allFetched) {
                    isLoadingMore = true;
                    fetchHostels();
                }else{
                    lv_hostel.onLoadMoreComplete();
                }
            }
        })*/;
        fetchADs();
    }

    private void fetchADs() {
/*        adList.add(new AD("LG Nexus 5X",R.drawable.nexus,R.drawable.lg,30,50,2.5,(new LatLng(28.5002321,77.169194))));
        adList.add(new AD("Volkswagen Vento",R.drawable.vento,R.drawable.volks,50,80,4,(new LatLng(28.4972475,77.1686121))));
        adList.add(new AD("Canon Camera",R.drawable.camera,R.drawable.canon,20,60,3.7,(new LatLng(28.498108,77.1653899))));
        adList.add(new AD("Apple Macbook Pro",R.drawable.mac,R.drawable.apple,35,80,1.3,(new LatLng(28.4965558,77.1656651))));
        */mAdapter.notifyDataSetChanged();
    }

    /**
     * This interface must be implemented by activities that contain this
     * fragment to allow an interaction in this fragment to be communicated
     * to the activity and potentially other fragments contained in that
     * activity.
     * <p/>
     * See the Android Training lesson <a href=
     * "http://developer.android.com/training/basics/fragments/communicating.html"
     * >Communicating with Other Fragments</a> for more information.
     */
    public interface OnFragmentInteractionListener {
        // TODO: Update argument type and name
        void onFragmentInteraction(Uri uri);
    }
}
