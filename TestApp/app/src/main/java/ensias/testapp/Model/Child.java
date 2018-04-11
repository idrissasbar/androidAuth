/*
 * Copyright (c) 2018. 
 */

package ensias.testapp.Model;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.Serializable;
import java.text.ParseException;
import java.util.ArrayList;

public class Child implements Serializable{
    
    private int id;
    private String name;
    String birthdate;
   

    public Child(Child body) {
        this();
        this.name = body.name;
        this.id = body.id;
        this.birthdate=body.birthdate;
    }


    public Child(){
        name = " ";
    }

    public static Child mapJson(JSONObject object) throws JSONException, ParseException {
        Child child = new Child();
        child.id = object.getInt("id");
        child.name = object.getString("name");
        child.birthdate  = object.getString("birthdate");
        
        return child;
    }
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }



    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getBirthdate() {
        return birthdate;
    }

    public void setBirthdate(String birthdate) {
        this.birthdate = birthdate;
    }



    @Override
    public boolean equals(Object obj) {
        return this.getId() == ((Child)obj).getId();
    }

    @Override
    public String toString() {
        return "{'id':"+getId()+
                ",'name':'"+getName()+"'"+
                ",'birthdate':'" +getBirthdate()+"'"+
                "}";
    }
}
