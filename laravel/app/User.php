<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class User
 * @package App
 *
 * @property string    $name
 * @property string    $email
 * @property string    $password
 * @property \DateTime $created
 * @property \DateTime $updated
 */
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract{

   use Authenticatable, Authorizable, CanResetPassword;

   /**
   * The database table used by the model.
   *
   * @var string
   */
   protected $table = 'users';

   public $timestamps = false;

   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
      'name',
      'surname1',
      'surname2',
      'birthday',
      'email',
      'password',
      'gender',
      'phone',
      'active_status',
      'id_security_question',
      'security_question_answer',
      'created',
      'updated',
      'id_role',
      'main_method_payment'
   ];

   # @param($id_role) integer (1:admin, 2:superadmin, 3:client, 4:encargado de boveda, 5:courier)
   # @param(main_method_payment) tinyInteger (0:Default, 1:Openpay, 2:Paypal)

   /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
   protected $hidden = ['password', 'remember_token'];

}
