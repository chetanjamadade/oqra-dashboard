<?php
class Current_User{

	public $id;
	public $email;
	public $first_name;
	public $last_name;
	public $location;
	public $role_id;
	public $image;
    public $phone;
	public $can = array();

	function __construct()
    {
        global $user, $globalapp;


        $this->id = $user->current_user_id();

        $user_data = $user->get_user($this->id);
        if ($user_data != null) {
            $this->email = $user_data[0]->email;
            $this->first_name = $user_data[0]->first_name;
            $this->last_name = $user_data[0]->last_name;
            $this->role_id = $user_data[0]->role;
            $this->image = $user_data[0]->image;
            $this->location = $user_data[0]->location_id;
            $this->phone = $user_data[0]->phone;
        }
        $this->set_permitions();
	}

	

	function set_permitions(){
		if( $this->role_id == 1 ){
			// Superadmin

			$this->can["view-all-users"] 				= true;
			$this->can["view-all-locations"] 			= true;
			$this->can["view-all-physicians"] 			= true;
			$this->can["view-all-patients"] 			= true;

			$this->can["add-users"] 					= true;
			$this->can["add-locations"] 				= true;
			$this->can["add-physicians"] 				= true;
			$this->can["add-patients"] 					= true;
			

		}elseif( $this->role_id == 2 ){
			// Physician's admin

			$this->can["view-all-users"] 				= true;
			$this->can["view-all-locations"] 			= true;
			$this->can["view-all-physicians"] 			= true;
			$this->can["view-all-patients"] 			= true;

			$this->can["add-users"] 					= true;
			$this->can["add-locations"] 				= true;
			$this->can["add-physicians"] 				= true;
			$this->can["add-patients"] 					= true;

		}
	}

}
?>