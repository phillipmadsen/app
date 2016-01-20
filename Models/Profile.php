<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Profile extends Model
{

    public $table = "profiles";

    public $timestamps = true;

    protected $guarded = ['id'];


    public $fillable = [
        "display_name",
        "slug",
        "username",
        "position",
        "supervisor",
        "employment_title",
        "employment_role",
        "employment_status",
        "phone",
        "phone_type",
        "website",
        "company",
        "gender",
        "about_me",
        "note",
        "skypeid",
        "twittername",
        "linkedinurl",
        "googleplusurl",
        "facebookurl",
        "user_api_key",
        "user_api_secret",
        "user_activation_key",
        "activation_code_id",
        "activation_code",
        "confirmation_code",
        "confirmed",
        "activated",
        "published",
        "last_login",
        "date_of_birth",
        "dob_month",
        "dob_day",
        "dob_year",
        "profile_activated_on",
        "activated_on",
        "published_on",
        "user_id"
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
     "username" => "string",

        "display_name" => "string",
        "slug" => "string",
        "position" => "string",
        "supervisor" => "string",
        "employment_title" => "string",
        "employment_role" => "string",
        "employment_status" => "string",
        "phone" => "string",
        "phone_type" => "string",
        "website" => "string",
        "company" => "string",
        "gender" => "string",
        "about_me" => "string",
        "note" => "string",
        "skypeid" => "string",
        "twittername" => "string",
        "linkedinurl" => "string",
        "googleplusurl" => "string",
        "facebookurl" => "string",
        "user_api_key" => "string",
        "user_api_secret" => "string",
        "user_activation_key" => "string",
        "activation_code_id" => "string",
        "activation_code" => "string",
        "confirmation_code" => "string",
        "confirmed" => "boolean",
        "activated" => "boolean",
        "published" => "boolean",
        "dob_month" => "string",
        "dob_day" => "string",
        "dob_year" => "string",
        "user_id" => "integer"
    ];

    public static $rules = [

    ];

/**
 * Relationship with the User model.
 *
 * @author    Phillip Madsen
 * @return    Illuminate\Database\Eloquent\Relations\BelongsTo
 */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
