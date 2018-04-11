package ensias.testapp.Model;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.Serializable;
import java.text.ParseException;
import java.util.ArrayList;

/** * Created by ASBAR Driss . */


public class User implements Serializable{
    private int id;
    private String firstName;
    private String lastName;
    private String email;
    private String password;
    ArrayList<Child> childrens;
    

    public User(User body) {
        this();
        this.firstName = body.firstName;
        this.lastName = body.lastName;
        this.email = body.email;
        this.password = body.password;
    }




    public User(String email, String password) {
        this.email = email;
        this.password = password;
    }

    public User(){
        this.firstName = " ";
        this.lastName = " ";
        this.email = " ";
    }

    public static User mapJson(JSONObject object) throws JSONException, ParseException {
        User user = new User();
       user.id = object.getInt("id");
       user.firstName = object.getString("firstName");
       user.lastName  = object.getString("lastName");
       user.email  = object.getString("email");
       user.password  = object.getString("password");

        if(object.has("childrens")){
            JSONArray notificationsArray = object.getJSONArray("childrens");
            for (int i=0;i<notificationsArray.length();i++){
                JSONObject notificationObject = (JSONObject) notificationsArray.get(i);
                Child child = Child.mapJson(notificationObject);
               user.childrens.add(child);
            }
        }
        return user;
    }
    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }



    public String getEmail() {
        return email;
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


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }



    @Override
    public boolean equals(Object obj) {
        return this.getId() == ((User)obj).getId();
    }

    @Override
    public String toString() {
        return "{'id':"+getId()+
                ",'firstName':'"+getFirstName()+"'"+
                ",'lastName':'"+getLastName()+"'"+
                ",'email':'" +getEmail()+"'"+
                "}";
    }
}
