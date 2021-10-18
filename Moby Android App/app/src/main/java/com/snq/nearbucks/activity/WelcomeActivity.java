package com.snq.nearbucks.activity;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.content.ContextCompat;
import android.util.Log;

import com.codemybrainsout.onboarder.AhoyOnboarderActivity;
import com.codemybrainsout.onboarder.AhoyOnboarderCard;
import com.snq.nearbucks.R;

import java.util.ArrayList;
import java.util.List;

public class WelcomeActivity extends AhoyOnboarderActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //setContentView(R.layout.activity_welcome);
        AhoyOnboarderCard ahoyOnboarderCard1 = new AhoyOnboarderCard("Moby", "The Money App!\nLocate. Engage. Earn Cash", R.drawable.moby1);
        AhoyOnboarderCard ahoyOnboarderCard4 = new AhoyOnboarderCard("Make Real Money", "Create your E-Wallet with Paytm to keep your money.", R.drawable.money);
        AhoyOnboarderCard ahoyOnboarderCard2 = new AhoyOnboarderCard("Engage With Brands", "Earn instant cash into your E-Wallet.", R.drawable.store);
        AhoyOnboarderCard ahoyOnboarderCard3 = new AhoyOnboarderCard("Brand Quiz", "Answer a few questions to earn real cash.", R.drawable.chat);

        ahoyOnboarderCard1.setBackgroundColor(R.color.white);
        ahoyOnboarderCard4.setBackgroundColor(R.color.white);
        ahoyOnboarderCard2.setBackgroundColor(R.color.white);
        ahoyOnboarderCard3.setBackgroundColor(R.color.white);
        //ahoyOnboarderCard1.setTitleTextSize(20);
        //ahoyOnboarderCard1.setDescriptionTextSize(20);

        List<AhoyOnboarderCard> pages = new ArrayList<>();

        pages.add(ahoyOnboarderCard1);
        pages.add(ahoyOnboarderCard2);
        pages.add(ahoyOnboarderCard3);
        pages.add(ahoyOnboarderCard4);

        for (AhoyOnboarderCard page : pages) {
            page.setTitleColor(R.color.black);
            page.setDescriptionColor(R.color.gray7);
            page.setTitleTextSize(20);
            page.setDescriptionTextSize(18);
        }


        setFinishButtonTitle("Get Started!");
        showNavigationControls(true);
        List<Integer> colorList = new ArrayList<>();
        colorList.add(R.color.primary);
        colorList.add(R.color.solid_two);
        colorList.add(R.color.solid_three);
        colorList.add(R.color.solid_one);
        setColorBackground(colorList);

        //set the button style you created
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.JELLY_BEAN) {
            setFinishButtonDrawableStyle(ContextCompat.getDrawable(this, R.drawable.rounded_button));
        }

        Typeface face = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Light.ttf");
        setFont(face);

        setOnboardPages(pages);
    }

    @Override
    public void onFinishButtonPressed() {
        startActivityForResult(new Intent(this,GetMobileNoActivity.class),1);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        switch (requestCode) {
            // Check for the integer request code originally supplied to startResolutionForResult().
            case 1:
                switch (resultCode) {
                    case Activity.RESULT_OK:
                        Log.i(WelcomeActivity.class.getName(), "user mobile no verified");
                        startActivity(new Intent(this,LoginActivity.class));
                        finish();
                        break;
                }
                break;
        }
    }
}
