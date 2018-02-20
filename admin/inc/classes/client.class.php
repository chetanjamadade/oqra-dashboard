<?php

class Client extends BasicElement{

    public $table_name = "client";
    public $order_by = "name";
    public $total = 0;
    public $selected_client_id = 0;

    function add( $name, $email, $url, $image, $terms, $not_found_message, $exists_message, $question, $first_name, $last_name, $password, $user_email, $user_phone, $current_user )
    {
        global $db;
        // if ($image === "") $image= "2017/04/client-1492346602.jpg";
        $result = $db->insert($db->prefix . $this->table_name, array(
            'name' => $name,
            'email' => $email,
            'url' => $url,
            'logo' => $image,
            'status' => '1',
            'user_id' => $current_user
        ));
        if ($result > 0) {
            $client_id = $db->insert_id;
            $result_conf = false;
                $result_conf = $db->insert('client_configuration', array(
                    'terms' => $terms,
                    'not_found_message' => $not_found_message,
                    'exists_message' => $exists_message,
                    'question' => $question,
                    'client_id' => $client_id,
                    'user_id' => $current_user
                ));
            $result_user = false;
            $result_user = $db->insert('user', array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $user_email,
                'phone' => $user_phone,
                'client_id' => $client_id,
                'password' => $password,
                'role' => '2',
                'status' => '1',
                'user_id' => $current_user
            ));
            if($result_conf == false || $result_user == false){
                return false;
            }else{
                return 1;
            }
        }
        else
        {
            return false;
        }
    }

    public function update( $id, $name, $email, $url, $image, $client_conf_id, $terms,$not_found_messages, $exists_message,$question, $user_id, $first_name,$last_name,$password,$user_email,$user_phone ){
        global $db;

        $update_array = array(
            'name' => $name,
            'email' => $email,
            'url' => $url,
            'status' => '1'
        );

        if( $image == 'remove' ){
            $update_array["logo"] = '';
        }elseif( $image && strlen($image) > 3 ){
            $update_array["logo"] = $image;
        }

        $result = $db->update(
            $db->prefix . $this->table_name,
            $update_array,
            array(
                'id' => $id
            )
        );

        if($result > 0 || $result === 0){
            $update_conf = array(
                'terms' => $terms,
                'not_found_message' => $not_found_messages,
                'exists_message' => $exists_message,
                'question' => $question
            );
            $result_conf = $db->update(
                $db->prefix . "client_configuration",
                $update_conf,
                array(
                    'id' => $client_conf_id
                )
            );

            if($result_conf > 0 || $result_conf === 0 ){
                $update_user = array(
                    'email' => $user_email,
                    'phone' => $user_phone,
                    'password' => $password,
                    'first_name' => $first_name,
                    'last_name' => $last_name
                );
                $result_user = $db->update(
                    $db->prefix . "user",
                    $update_user,
                    array(
                        'id' => $user_id
                    )
                );
            }
        }
        return (($result > 0  || $result_user === 0) && ($result_user > 0 || $result_user === 0) && ( $result_conf > 0 || $result_conf === 0 )) ? true : false;
    }


    public function get_all_active(){
        global $db;
        $sqlQuery = "SELECT * FROM " . $db->prefix . $this->table_name . " WHERE status = '1' ORDER BY name DESC";
        return $db->query( $sqlQuery );
    }

    public function get_location( $id ){
        global $db;
        $l = $db->query( "SELECT * FROM " . $db->prefix . "locations WHERE id='$id' LIMIT 1" );
        return ( is_array($l) && count($l) == 1 ) ? $l[0] : false;
    }

    public function search( $page, $per_page, $status = 1, $name = "", $user_id = "", $timeframe = "" ){
        global $db, $user;

        $from = ( $page - 1 ) * $per_page;
        $to = $page * $per_page;

        $where = " WHERE status = '$status'";
        $join = "";

        if( strlen(trim($name)) > 0 ){
            $where .= " AND location_name LIKE '%$name%'";
        }

        if( $user_id > 0 ){
            $where .= " AND id = '".$user->get_locations_by_user( $user_id )."'";
        }

        if( is_valid_timeframe( $timeframe ) ){
            $where .=  get_timeframe_search_query( $timeframe );
        }

        $sqlQuery = "SELECT * FROM " . $db->prefix . $this->table_name . $join . $where . " ORDER BY name DESC LIMIT $from, $to";
        return $db->query( $sqlQuery );
    }

    public function total_search( $status = 1, $name = "", $user_id = "", $timeframe = "" ){
        global $db, $user;

        $where = " WHERE status = '$status'";
        $join = "";

        if( strlen(trim($name)) > 0 ){

            $where .= " AND location_name LIKE '%$name%'";
        }

        if( $user_id > 0 ){
            $where .= " AND id = '".$user->get_locations_by_user( $user_id )."'";
        }

        if( is_valid_timeframe( $timeframe ) ){
            $where .=  get_timeframe_search_query( $timeframe );
        }
        $sqlQuery = "SELECT COUNT(id) FROM " . $db->prefix . $this->table_name .$join . $where;
        return $db->get_data( $sqlQuery );
    }


    public function get_users( $id, $as_string = true ){
        global $db, $user;
        $r_arr = array();

        $r = $db->query( "SELECT id FROM " . $db->prefix . $user->table_name . " WHERE location = '$id'  AND status = '1'" );
        if( is_array($r) ){
            foreach ( $r as $item ) {
                $r_arr[] = $item->id;
            }
        }
        return ( $as_string ) ? implode(',', $r_arr) : $r_arr;
    }

    public function get_by_id( $ids ){
        global $db;
        $join = " join client_configuration cc on c.id = cc.client_id ";

        if( $ids == "" ){
            $ids = '0';
        }
        $sqlQuery = "SELECT * FROM " . $db->prefix . $this->table_name ." c " . $join. " WHERE c.id IN($ids)";
        return $db->query( $sqlQuery  );
    }

    public function get_client_by_user_id( $ids ){
        global $db;
        $join = " join client_configuration cc on c.id = cc.client_id ";

        if( $ids == "" ){
            $ids = '0';
        }
        $sqlQuery = "SELECT * FROM " . $db->prefix . $this->table_name ." c " . $join. " WHERE c.id IN($ids)";
        return $db->query( $sqlQuery  );
    }

    public function get_by_id_with_user( $ids ){
        global $db;
        $join = " join client_configuration cc on c.id = cc.client_id join user u on u.client_id = c.id ";

        if( $ids == "" ){
            $ids = '0';
        }
        $sqlQuery = "SELECT c.*,cc.*, u.id as user_id, u.email as user_email, u.first_name as user_first_name, u.last_name as user_last_name, u.phone as user_phone, u.password as user_password  FROM " . $db->prefix . $this->table_name ." c " . $join. " WHERE c.id IN($ids)";
        return $db->query( $sqlQuery  );
    }

    public function get_ratings_for_client( $ids ){
        global $db;

        $sqlQuery = "SELECT 'Extremly Sattisfied' AS ex ,COUNT(*) AS COUNT FROM rating WHERE rating = 5 and client_id = $ids UNION ALL SELECT 'Very Sattisfied'  , COUNT(*) AS COUNT FROM rating WHERE rating = 4 and client_id = $ids UNION ALL SELECT 'Sattisfied' ,COUNT(*) AS COUNT FROM rating WHERE rating = 3 and client_id = $ids UNION ALL SELECT 'Disatisfied' , COUNT(*) AS COUNT FROM rating WHERE rating = 2 and client_id = $ids UNION ALL SELECT 'Very Disasfied' ,COUNT(*) AS COUNT FROM rating WHERE rating = 1 and client_id = $ids ";
        return $db->query( $sqlQuery  );
    }

    public function get_top_sattisfied( $ids ){
        global $db;

        $sqlQuery = "SELECT CASE WHEN r.rating =  5 THEN 'Extremly Satisfied' WHEN r.rating =  4 THEN 'Very Satisfied' WHEN r.rating = 3  THEN 'Sattisfied' WHEN r.rating = 2  THEN 'Disatisfied' ELSE 'Very disatisfied' END AS rating, CASE WHEN r.rating =  5 THEN 'ext-satisfied' WHEN r.rating =  4 THEN 'very-satisfied' WHEN r.rating = 3  THEN 'satisfied' WHEN r.rating = 2  THEN 'disatisfied' ELSE 'very-disatisfied' END AS icon, g.`first_name_guest`, g.`last_name_guest`, g.`phone_guest` , l.`location_name` FROM rating r, guest g, client c, review v, location l WHERE r.`client_id` = c.`id` AND l.`id` = r.`location_id` AND g.`client_id` = c.`id` AND  v.`client_id` = c.`id` AND v.`guest_id` = g.`id` AND v.`rating_id` = r.`id` AND c.id= $ids ORDER BY r.rating DESC, v.entry_date DESC LIMIT 5";
        return $db->query( $sqlQuery  );
    }

    public function get_top_disatisfied( $ids ){
        global $db;

        $sqlQuery = "SELECT CASE WHEN r.rating =  5 THEN 'Extremly Satisfied' WHEN r.rating =  4 THEN 'Very Satisfied' WHEN r.rating = 3  THEN 'Sattisfied' WHEN r.rating = 2  THEN 'Disatisfied' ELSE 'Very disatisfied' END AS rating, CASE WHEN r.rating =  5 THEN 'ext-satisfied' WHEN r.rating =  4 THEN 'very-satisfied' WHEN r.rating = 3  THEN 'satisfied' WHEN r.rating = 2  THEN 'disatisfied' ELSE 'very-disatisfied' END AS icon, g.`first_name_guest`, g.`last_name_guest`, g.`phone_guest` , l.`location_name` FROM rating r, guest g, client c, review v, location l WHERE r.`client_id` = c.`id` AND l.`id` = r.`location_id` AND g.`client_id` = c.`id` AND  v.`client_id` = c.`id` AND v.`guest_id` = g.`id` AND v.`rating_id` = r.`id` AND c.id= $ids ORDER BY r.rating asc, v.entry_date DESC LIMIT 5";

        return $db->query( $sqlQuery  );
    }

    public function get_nor( $ids ){
        global $db;

        $sqlQuery = "SELECT COUNT(*) as nor FROM review r WHERE r.`client_id` =$ids AND r.`entry_date` BETWEEN (CURRENT_DATE() - INTERVAL 1 MONTH) AND CURRENT_DATE();";
        return $db->query( $sqlQuery  );
    }
}

?>