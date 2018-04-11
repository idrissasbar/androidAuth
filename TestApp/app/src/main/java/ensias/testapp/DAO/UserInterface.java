package ensias.testapp.DAO;



import ensias.testapp.Model.AccessToken;
import ensias.testapp.Model.User;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Path;
import retrofit2.http.Query;

public interface UserInterface {
    @GET("users/{id}?include=childrens")
    Call<User> getUserAllInfo(@Path("id") int user);

    @GET("auth_user")
    Call<User> getAuthUser(@Query("include") String include);

    @GET("users/{id}")
    Call<User> getUserWithIncludes(@Path("id") int user, @Query("include") String include);

    @FormUrlEncoded
    @POST("login")
    Call<AccessToken> Login(@Field("username") String email, @Field("password") String password);

    @FormUrlEncoded
    @POST("refresh")
    Call<AccessToken> refresh(@Field("refresh_token") String refreshToken);

    @POST("logout")
    Call<ResponseBody> logout();
}
