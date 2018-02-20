<?php

class Professional extends BasicElement{

    public $table_name = "professional";
    public $order_by = "name";
    public $total = 0;
    public $selected_client_id = 0;

    function add( $name,$adress, $email, $phone, $image, $location, $current_user )
    {
        global $db;

        $result = $db->insert($db->prefix . $this->table_name, array(
            'name' => $name,
            'adress' => $adress,
            'email' => $email,
            'phone' => $phone,
            'image' => $image,
            'location_id' => $location,
            'status' => 1,
            'user_id' => $current_user
        ));
        return ( $result > 0 ) ? $result : false;
    }

    public function update( $id, $name,$adress, $email, $phone, $image,$location, $current_user ){
        global $db;

        $update_array = array(
            'name' => $name,
            'adress' => $adress,
            'email' => $email,
            'phone' => $phone,
            'location_id' => $location,
        );

        if( $image == 'remove' ){
            $update_array["image"] = '';
        }elseif( $image && strlen($image) > 3 ){
            $update_array["image"] = $image;
        }

        $result = $db->update(
            $db->prefix . $this->table_name,
            $update_array,
            array(
                'id' => $id
            )
        );

        return ($result > 0  || $result === 0) ? true : false;
    }

    public function search( $page, $per_page, $status,$name = "", $user_id = "", $timeframe = "" ){
        global $db, $user;

        $from = ( $page - 1 ) * $per_page;
        $to = $page * $per_page;

        $where = " where p.status = $status and p.user_id = $user_id";
        $join = " p join location l on l.id = p.location_id ";

        $sqlQuery = "SELECT p.*, l.location_name FROM " . $db->prefix . $this->table_name . $join . $where . " ORDER BY name DESC LIMIT $from, $to";
        return $db->query( $sqlQuery );
    }

    public function total_search($status ,$name = "", $user_id = "", $timeframe = "" ){
        global $db, $user;

        $where = " where p.status = $status and p.user_id=$user_id" ;
        $join = " p join location l on l.id = p.location_id ";


        $sqlQuery = "SELECT COUNT(p.id) FROM " . $db->prefix . $this->table_name .$join . $where;
        return $db->get_data( $sqlQuery );
    }

    public function get_by_id( $ids ){
        global $db;
        $join = "  ";

        if( $ids == "" ){
            $ids = '0';
        }
        $sqlQuery = "SELECT *  FROM " . $db->prefix . $this->table_name ." p " . $join. " WHERE p.id IN($ids)";
        return $db->query( $sqlQuery  );
    }
}
?>