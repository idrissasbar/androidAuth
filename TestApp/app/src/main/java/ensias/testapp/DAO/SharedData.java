package ensias.testapp.DAO;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;

import com.google.gson.Gson;

import java.io.Serializable;

import ensias.testapp.Model.User;
import ensias.testapp.R;

public class SharedData {
    public static void saveUserInSharedPref(String User,Context context){
        SharedPreferences pref = context.getSharedPreferences(context.getResources().getString(R.string.userKey), Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = pref.edit();
        editor.putString(context.getString(R.string.userKey), User);
        editor.commit();
    }
    public static void removeUserInSharedPref(Context context){
        SharedPreferences pref = context.getSharedPreferences(context.getResources().getString(R.string.userKey), Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = pref.edit();
        editor.remove(context.getResources().getString(R.string.userKey));
        editor.commit();
    }

    public static User getUserFromSharedPref(Context context){
        SharedPreferences pref = context.getSharedPreferences(context.getResources().getString(R.string.userKey), Context.MODE_PRIVATE);
        String key = context.getResources().getString(R.string.userKey);
        if(pref.contains(key)){
            User User = new User();
            User = new Gson().fromJson(pref.getString(context.getResources().getString(R.string.userKey),"undefined"), User.class);
            return  new Gson().fromJson(pref.getString(context.getResources().getString(R.string.userKey),"undefined"), User.class);
        }
        return null;
    }

    public static Serializable getUserFromExtra(Activity activity){
        if(activity.getIntent().hasExtra("User")){
            if(activity.getIntent().getExtras().getSerializable("User") != null){
                return activity.getIntent().getExtras().getSerializable("User");
            }else return  null;
        }
        return null;
    }
    public static User getUser(Activity activity){
        User User = new User();
        User = (User) SharedData.getUserFromExtra(activity);
        if(User == null)
            User = getUserFromSharedPref(activity);
        return User;
    }
}
