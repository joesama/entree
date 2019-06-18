<?php 
namespace Joesama\Entree\Services\Ldap;

use Joesama\Entree\Database\Model\User;
use Orchestra\Contracts\Memory\Provider;
use Carbon\Carbon;

/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class LdapAuthenticate 
{

	public function __construct()
	{
		$this->ldap = new \Adldap\Adldap();
		$this->ldap->addProvider($this->config());
		$this->provider = $this->ldap->connect();
		$this->memory = app(Provider::class);
	}

	/**
	 * Authenticate Username & Password
	 *
	 * @author joharijumali@gmail.com
	 **/
	public function authenticate($username,$password)
	{

		try {

				if($this->provider->auth()->attempt($username,$password,true)):

					$ldapUser = $this->provider->search()->where('samaccountname', '=', $username)->first();

					if($ldapUser):

						$ldapUser = collect($ldapUser);

						$user = User::where('email',data_get($ldapUser,'mail.0'))->first();

						if(is_null($user)):

							$this->newUser(data_get($ldapUser,'displayname.0'),data_get($ldapUser,'mail.0'),$username,$password);
						else:

							$user->password = $password;
							$user->save();

						endif;

						if((data_get($ldapUser,'mail.0') == config('joesama/entree::entree.mail_account')) && config('joesama/entree::entree.mail_renew')):

							$this->updateEmailConfig($username,$password);

						endif;

						event('ldap-auth',[$user,$ldapUser]);

						return TRUE;
					else:
						return FALSE;
					endif;

				else:
					return FALSE;
				endif;

		} 
		catch (\Adldap\Auth\BindException $e) {
		    return redirect_with_message(
                handles('joesama/entree::login'),
                'ERROR:'.$e,
                'error');
		}

	}

	/**
	 * Define Configuration
	 *
	 **/
	protected function config()
	{
		return [
		      'account_suffix' => config('joesama/entree::entree.accoount.suffix'),
		      'domain_controllers' => [config('joesama/entree::entree.accoount.domains')],
		      'base_dn' => config('joesama/entree::entree.accoount.dn'),
		      'admin_username' => config('joesama/entree::entree.accoount.admn_user'),
		      'admin_password' => config('joesama/entree::entree.accoount.admn_pword'),
		];
	}

	/**
	 * Create new user if not exist
	 *
	 **/
	protected function newUser($fullname,$email,$username,$password)
	{
		// $newUser = collect([
		// 	'user' => collect([
		// 		 => $username,
		// 		'password' => $password,
		// 		'fullname' => $fullname,
		// 		'email' => $email,
		// 		'roles' => 4,
		// 	])
		// ]);

		$user = collect([]);

		$user->put('username',$username);
		$user->put('password',$password);
		$user->put('fullname',$fullname);
		$user->put('email',$email);
		$user->put('roles',4);

		$user = app(\Joesama\Entree\Database\Repository\UserRepo::class)->createUserData(compact('user'));

		$user->activate()->save();

	}


	/**
	 * Check LDAP user data 
	 *
	 **/
	public function checkuser($name)
	{
		$ldapUser = $this->provider->search()->where('samaccountname', '=', $name)->first();

		return collect($ldapUser)->toArray();

	}


	/**
	 * Update Email Config
	 *
	 **/
	protected function updateEmailConfig($username,$password)
	{
		$this->memory->put("email.username", $username);
		$this->memory->securePut("email.password", $password);
		$this->memory->put("joesama.email.last",Carbon::now());
	}

} // END class LdapAuthenticate 



