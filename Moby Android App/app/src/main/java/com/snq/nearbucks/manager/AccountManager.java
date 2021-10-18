package com.snq.nearbucks.manager;

import com.snq.nearbucks.object.User;

/**
 * Created by rahul on 04-07-2016.
 */
public class AccountManager {

    private User user;
    private static AccountManager instance;
    public static AccountManager getInstance(){
        if(instance==null){
            instance = new AccountManager();
        }
        return instance;
    }

    private AccountManager() {
    }

    public User getUser(){
        return user;
    }
    public boolean isValidUser(){
        return (user!=null && user.getUserContact()!=null && !user.getUserContact().isEmpty() && user.getEmail()!=null && !user.getEmail().isEmpty());
    }

    public void createUser(String phoneNumber, String email, String password, String name, String gender, String dob,int age) {
        if(user==null)
            user = new User();
        user.setUserContact(phoneNumber);
        user.setEmail(email);
        user.setPassword(password);
        user.setName(name);
        user.setGender(gender);
        user.setDob(dob);
        user.setAge(age);
    }

    public void setUser(User user) {
        this.user = user;
    }

    public void logout() {
        this.user = null;
    }
}
