<?php

namespace Joesama\Entree\Http\Notifications;

/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class ResetPasswordMessage
{

	function __construct($token)
	{
		 $this->messages($token));
	}


    /**
     * Handle the event.
     *
     * @param Joesama\Entree\Database\Model\User $user
     * @return void
     */
    public function messages($token)
    {



        return $message;

    }


} // END class ResetPasswordMessage 
	

