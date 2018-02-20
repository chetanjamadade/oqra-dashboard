<?php
class BasicElement{

	public $table_name;
	public $order_by = "id";
	public $association_class = "location_configuration";

	public function change_status( $id, $status ){
		global $db;

		$result = $db->update(
			$db->prefix . $this->table_name,
			array(
				'status' => $status
			),
			array(
				'id' => $id
			)
		);
        if ($result>0 && $db->prefix . $this->table_name == 'client'){
            $result1 = $db ->update(
                "user",
                array(
                    'status'=>$status
                ),
                array(
                    'client_id' =>$id
                )
            );
        }

		return ( $result > 0 ) ? true : false;
	}

	public function update_data( $id, $column, $value ){
		global $db;

		$result = $db->update(
			$db->prefix . $this->table_name,
			array(
				$column => $value
			),
			array(
				'id' => $id
			)
		);

		return ( $result > 0 ) ? true : false;
	}

	public function delete( $id ){
		global $db;

		$result = $db->delete(
			$db->prefix . $this->table_name,
			array(
				'id' => $id
			)
		);

		return ( $result > 0 ) ? true : false;
	}

	public function get_all_active(){
		global $db;
		return $db->query( "SELECT * FROM " . $db->prefix . $this->table_name. " WHERE status = '1' ORDER BY ".$this->order_by." DESC" );
	}

	public function exists( $id ){
		global $db;
		$count = $db->get_data( "SELECT COUNT(id) FROM " . $db->prefix . $this->table_name. " WHERE id = '$id'" );
		$a = "SELECT COUNT(id) FROM " . $db->prefix . $this->table_name. " WHERE id = '$id'";
		return ( $count == 1 ) ? true : false;
	}

	public function get_one( $id ){
		global $db;
		$join = " join ". $this->association_class. " lc on location.id = lc.location_id";
		$sql_query = "SELECT *,lc.id as lc_id FROM " . $db->prefix . $this->table_name. $join . " WHERE location.id = '$id' LIMIT 1";
		$item = $db->query( $sql_query );
		if( is_array($item) && count($item) == 1 ){
			return $item[0];
		}else{
			return false;
		}
	}

	public function get_all(){
		global $db;
		return $db->query( "SELECT * FROM " . $db->prefix . $this->table_name );
	}

	public function get_by_ids( $ids ){
		global $db;
		if( $ids == "" ){
			$ids = '0';
		}
		$a = "SELECT * FROM " . $db->prefix . $this->table_name . " WHERE id IN($ids)";
		return $db->query( "SELECT * FROM " . $db->prefix . $this->table_name . " WHERE id IN($ids)" );
	}

	public function total_by_ids( $ids ){
		global $db;
		if( $ids == "" ){
			$ids = '0';
		}
		return $db->get_data( "SELECT COUNT(id) FROM " . $db->prefix . $this->table_name . " WHERE id IN($ids)" );
	}

	public function get_value( $id, $property ){
		global $db;
		if( $id > 0 ){
		    $sqlQuery = "SELECT $property FROM " . $db->prefix . $this->table_name. " WHERE id = '$id' LIMIT 1";
			return $db->get_data( $sqlQuery );
		}else{
			return "";
		}
	}

}

?>