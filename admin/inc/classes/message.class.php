<?php

class Message extends BasicElement{

	public $table_name = "messages";
	public $order_by = "id";

	// 0 - archived message, 1 - read message, 2 - unread message

	public function send( $type, $from_id, $to_id, $subject, $message, $screenshots, $date ){
		global $db;

		$result = $db->insert( $db->prefix.'messages', array(
			'type' => $type,
			'from_id' => $from_id,
			'to_id' => $to_id,
			'subject' => $subject,
			'message' => $message,
			'screenshots' => $screenshots,
			'status' => 1,
			'readen' => 0,
			'date' => $date
			) );

		return ( $result > 0 ) ? $result : false;

	}

	public function change_read( $id, $status ){
		global $db;

		$result = $db->update(
			$db->prefix . $this->table_name,
			array(
				'readen' => $status
			),
			array(
				'id' => $id
			)
		);

		return ( $result > 0 ) ? true : false;
	}

	public function mark_as_read( $id ){
		return $this->change_read( $id, 1 );
	}

	public function mark_as_unread( $id ){
		return $this->change_read( $id, 0 );
	}


	public function search( $page, $per_page, $status = 1, $to_id = 0, $readen = '', $type = '', $timeframe = "" ){
		global $db, $current_user;

		$from = ( $page - 1 ) * $per_page;
		$to = $page * $per_page;

		$where = " WHERE status = '$status'";

		if( $to_id > 0 ){
			if( $current_user->role_id == 1 ){
				$where .= " AND ( to_id = '$to_id' OR to_id = '0')";
			}else{
				$where .= " AND to_id = '$to_id'";
			}
			
		}

		if( $readen == 'read' ){
			$where .= " AND readen = '1'";
		}

		if( $readen == 'unread' ){
			$where .= " AND readen = '0'";
		}

		if( $type == 'forgoten-password' || $type == "support" ){
			$where .= " AND type = '$type'";
		}

		if( is_valid_timeframe( $timeframe ) ){
			$where .= get_timeframe_search_query( $timeframe );
		}

		return $db->query( "SELECT * FROM " . $db->prefix . $this->table_name." $where ORDER BY ".$this->order_by." DESC LIMIT $from, $to" );
	}

	public function total_search( $status = 1, $to_id = 0, $readen = '', $type = '', $timeframe = "" ){
		global $db, $current_user;

		$where = " WHERE status = '$status'";

		if( $to_id > 0 ){
			if( $current_user->role_id == 1 ){
				$where .= " AND ( to_id = '$to_id' OR to_id = '0')";
			}else{
				$where .= " AND to_id = '$to_id'";
			}
			
		}

		if( $readen == 'read' ){
			$where .= " AND readen = '1'";
		}

		if( $readen == 'unread' ){
			$where .= " AND readen = '0'";
		}

		if( $type == 'forgoten-password' || $type == "support" ){
			$where .= " AND type = '$type'";
		}

		if( is_valid_timeframe( $timeframe ) ){
			$where .= get_timeframe_search_query( $timeframe );
		}

		return $db->get_data( "SELECT COUNT(id) FROM " . $db->prefix . $this->table_name." $where" );
	}


}

?>