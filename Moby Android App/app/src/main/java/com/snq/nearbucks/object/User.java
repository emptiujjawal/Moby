package com.snq.nearbucks.object;

import com.orm.SugarRecord;
import com.orm.dsl.Unique;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

/**
 * Created by rahul on 4/1/17.
 */
public class User extends SugarRecord {

    @Unique
    private long uid;
    private String userContact;
    private String email;
    private String password;
    private String loggedInUsing;
    private String name;
    private String profileImage;
    private String profileCoverPic;
    private int age;
    private String dob;
    private String gender;
    private String address;
    private String location;
    private String city;
    private String state;
    private int pincode;
    private DropDownObject salary;
    private List<DropDownObject> salaryDropDownObjects;
    private DropDownObject profession;
    private List<DropDownObject> professionDropDownObjects;
    private DropDownObject clubMembership;
    private List<DropDownObject> clubMembershipDropDownObjects;
    private DropDownObject defenseService;
    private List<DropDownObject> defenseServiceDropDownObjects;
    private DropDownObject watchBrand;
    private List<DropDownObject> watchBrandDropDownObjects;
    private DropDownObject carBrand;
    private List<DropDownObject> carBrandDropDownObjects;
    private DropDownObject residenceType;
    private List<DropDownObject> residenceTypeDropDownObjects;
    private DropDownObject transportType;
    private List<DropDownObject> transportTypeDropDownObjects;
    private DropDownObject milesCard;
    private List<DropDownObject> milesCardDropDownObjects;
    private DropDownObject creditCard;
    private List<DropDownObject> creditCardDropDownObjects;
    private int walletAmount;
    private String fbLink;
    private String twitterLink;
    private String gplusLink;
    private int checkIns;
    private int quizAnswered;

    public User(){}

    public DropDownObject getSalary() {
        return salary;
    }

    public void setSalary(DropDownObject salary) {
        this.salary = salary;
    }

    public DropDownObject getProfession() {
        return profession;
    }

    public List<DropDownObject> getSalaryDropDownObjects() {
        return salaryDropDownObjects;
    }

    public void setSalaryDropDownObjects(List<DropDownObject> salaryDropDownObjects) {
        this.salaryDropDownObjects = salaryDropDownObjects;
    }

    public List<DropDownObject> getProfessionDropDownObjects() {
        return professionDropDownObjects;
    }

    public void setProfessionDropDownObjects(List<DropDownObject> professionDropDownObjects) {
        this.professionDropDownObjects = professionDropDownObjects;
    }

    public List<DropDownObject> getClubMembershipDropDownObjects() {
        return clubMembershipDropDownObjects;
    }

    public void setClubMembershipDropDownObjects(List<DropDownObject> clubMembershipDropDownObjects) {
        this.clubMembershipDropDownObjects = clubMembershipDropDownObjects;
    }

    public List<DropDownObject> getDefenseServiceDropDownObjects() {
        return defenseServiceDropDownObjects;
    }

    public void setDefenseServiceDropDownObjects(List<DropDownObject> defenseServiceDropDownObjects) {
        this.defenseServiceDropDownObjects = defenseServiceDropDownObjects;
    }

    public List<DropDownObject> getWatchBrandDropDownObjects() {
        return watchBrandDropDownObjects;
    }

    public void setWatchBrandDropDownObjects(List<DropDownObject> watchBrandDropDownObjects) {
        this.watchBrandDropDownObjects = watchBrandDropDownObjects;
    }

    public List<DropDownObject> getCarBrandDropDownObjects() {
        return carBrandDropDownObjects;
    }

    public void setCarBrandDropDownObjects(List<DropDownObject> carBrandDropDownObjects) {
        this.carBrandDropDownObjects = carBrandDropDownObjects;
    }

    public List<DropDownObject> getResidenceTypeDropDownObjects() {
        return residenceTypeDropDownObjects;
    }

    public void setResidenceTypeDropDownObjects(List<DropDownObject> residenceTypeDropDownObjects) {
        this.residenceTypeDropDownObjects = residenceTypeDropDownObjects;
    }

    public List<DropDownObject> getTransportTypeDropDownObjects() {
        return transportTypeDropDownObjects;
    }

    public void setTransportTypeDropDownObjects(List<DropDownObject> transportTypeDropDownObjects) {
        this.transportTypeDropDownObjects = transportTypeDropDownObjects;
    }

    public List<DropDownObject> getMilesCardDropDownObjects() {
        return milesCardDropDownObjects;
    }

    public void setMilesCardDropDownObjects(List<DropDownObject> milesCardDropDownObjects) {
        this.milesCardDropDownObjects = milesCardDropDownObjects;
    }

    public List<DropDownObject> getCreditCardDropDownObjects() {
        return creditCardDropDownObjects;
    }

    public void setCreditCardDropDownObjects(List<DropDownObject> creditCardDropDownObjects) {
        this.creditCardDropDownObjects = creditCardDropDownObjects;
    }

    public void setProfession(DropDownObject profession) {
        this.profession = profession;
    }

    public DropDownObject getClubMembership() {
        return clubMembership;
    }

    public void setClubMembership(DropDownObject clubMembership) {
        this.clubMembership = clubMembership;
    }

    public DropDownObject getDefenseService() {
        return defenseService;
    }

    public void setDefenseService(DropDownObject defenseService) {
        this.defenseService = defenseService;
    }

    public DropDownObject getWatchBrand() {
        return watchBrand;
    }

    public void setWatchBrand(DropDownObject watchBrand) {
        this.watchBrand = watchBrand;
    }

    public DropDownObject getCarBrand() {
        return carBrand;
    }

    public void setCarBrand(DropDownObject carBrand) {
        this.carBrand = carBrand;
    }

    public DropDownObject getResidenceType() {
        return residenceType;
    }

    public void setResidenceType(DropDownObject residenceType) {
        this.residenceType = residenceType;
    }

    public DropDownObject getTransportType() {
        return transportType;
    }

    public void setTransportType(DropDownObject transportType) {
        this.transportType = transportType;
    }

    public DropDownObject getMilesCard() {
        return milesCard;
    }

    public void setMilesCard(DropDownObject milesCard) {
        this.milesCard = milesCard;
    }

    public DropDownObject getCreditCard() {
        return creditCard;
    }

    public void setCreditCard(DropDownObject creditCard) {
        this.creditCard = creditCard;
    }

    public long getUid() {
        return uid;
    }

    public void setUid(long uid) {
        this.uid = uid;
    }

    public String getUserContact() {
        return userContact;
    }

    public void setUserContact(String userContact) {
        this.userContact = userContact;
    }

    public String getDob() {
        return dob;
    }

    public void setDob(String dob) {
        this.dob = dob;
    }

    public String getEmail() {
        return email.isEmpty()?"":email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getLoggedInUsing() {
        return loggedInUsing;
    }

    public void setLoggedInUsing(String loggedInUsing) {
        this.loggedInUsing = loggedInUsing;
    }

    public String getName() {
        return name.isEmpty()?"":name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getProfileImage() {
        return profileImage;
    }

    public void setProfileImage(String profileImage) {
        this.profileImage = profileImage;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }

    public String getGender() {
        return gender.isEmpty()?"":gender;
    }

    public void setGender(String gender) {
        this.gender = gender;
    }

    public String getAddress() {
        return address.isEmpty()?"":address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getLocation() {
        return location;
    }

    public void setLocation(String location) {
        this.location = location;
    }

    public String getCity() {
        return city.isEmpty()?"":city;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public String getState() {
        return state.isEmpty()?"":state;
    }

    public void setState(String state) {
        this.state = state;
    }

    public int getPincode() {
        return pincode;
    }

    public void setPincode(int pincode) {
        this.pincode = pincode;
    }

    public static User fromJSON(JSONObject user_detail) throws JSONException {
        User user = new User();
        user.setName(user_detail.getString("user_name"));
        user.setGender(user_detail.getString("gender"));
        user.setDob(user_detail.getString("user_dob"));
        user.setAge(user_detail.getInt("user_age"));
        user.setProfileImage(user_detail.has("user_profile_image")?user_detail.getString("user_profile_image"):user_detail.getString("user_photo"));
        user.setProfileCoverPic(user_detail.has("moby_ad")?user_detail.getString("moby_ad"):"");
        return user;
    }

//    public String getSalary() {
//        return salary.isEmpty()?"":salary;
//    }
//
//    public void setSalary(String salary) {
//        this.salary = salary;
//    }

//    public String getProfession() {
//        return profession.isEmpty()?"":profession;
//    }
//
//    public void setProfession(String profession) {
//        this.profession = profession;
//    }


    public String getProfileCoverPic() {
        return profileCoverPic;
    }

    public void setProfileCoverPic(String profileCoverPic) {
        this.profileCoverPic = profileCoverPic;
    }

    public int getWalletAmount() {
        return walletAmount;
    }

    public void setWalletAmount(int walletAmount) {
        this.walletAmount = walletAmount;
    }

    public String getFbLink() {
        return fbLink;
    }

    public void setFbLink(String fbLink) {
        this.fbLink = fbLink;
    }

    public String getTwitterLink() {
        return twitterLink;
    }

    public void setTwitterLink(String twitterLink) {
        this.twitterLink = twitterLink;
    }

    public String getGplusLink() {
        return gplusLink;
    }

    public void setGplusLink(String gplusLink) {
        this.gplusLink = gplusLink;
    }

    public int getCheckIns() {
        return checkIns;
    }

    public void setCheckIns(int checkIns) {
        this.checkIns = checkIns;
    }

    public int getQuizAnswered() {
        return quizAnswered;
    }

    public void setQuizAnswered(int quizAnswered) {
        this.quizAnswered = quizAnswered;
    }

    public String getCompleteAddress() {
        String add  = getAddress();
        if(!add.isEmpty()){
            add+=", ";
        }
        String city = getCity();
        if(!city.isEmpty()){
            add+=city+", ";
        }
        String state = getState();
        if(!state.isEmpty()){
            add+=state+", ";
        }
        int pincode = getPincode();
        if(pincode!=0){
            add+=pincode;
        }

        return add;
    }
}
