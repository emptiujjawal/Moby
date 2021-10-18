package com.snq.nearbucks.fragment;

import android.content.Context;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;

import com.snq.nearbucks.R;
import com.snq.nearbucks.adapter.StoreAdapter;
import com.snq.nearbucks.object.Store;

import java.util.ArrayList;
import java.util.List;

import butterknife.ButterKnife;
import butterknife.InjectView;

/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link StoresFragment.OnFragmentInteractionListener} interface
 * to handle interaction events.
 */
public class StoresFragment extends Fragment {

    @InjectView(R.id.lv_stores)
    ListView lv_stores;

    private StoreAdapter mAdapter;
    public static List<Store> storeList;

    private OnFragmentInteractionListener mListener;

    public StoresFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_stores, container, false);
        ButterKnife.inject(this, view);
        setUpHostelAdapter();
        return view;
    }


    private void setUpHostelAdapter() {
        storeList = new ArrayList<>();
        mAdapter = new StoreAdapter(getActivity(), storeList);
        //isLoadingMore = true;
        lv_stores.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {

            }
        });
        lv_stores.setAdapter(mAdapter);
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
        fetchStores();
    }

    private void fetchStores() {
    }

    // TODO: Rename method, update argument and hook method into UI event
    public void onButtonPressed(Uri uri) {
        if (mListener != null) {
            mListener.onFragmentInteraction(uri);
        }
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        if (context instanceof OnFragmentInteractionListener) {
            mListener = (OnFragmentInteractionListener) context;
        } else {
            throw new RuntimeException(context.toString()
                    + " must implement OnFragmentInteractionListener");
        }
    }

    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
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
