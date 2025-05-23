<?php

function ft_import_get_page_by_title( $page_title, $output = OBJECT, $post_type = 'page' ) {
	global $wpdb;
	if ( is_array( $post_type ) ) {
		$post_type           = esc_sql( $post_type );
		$post_type_in_string = "'" . implode( "','", $post_type ) . "'";
		$sql                 = $wpdb->prepare(
			"SELECT ID
			FROM $wpdb->posts
			WHERE post_title = %s
			AND post_type IN ($post_type_in_string)", // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$page_title
		); // WordPress.DB.PreparedSQL.InterpolatedNotPrepared	
	} else {
		$sql = $wpdb->prepare(
			"SELECT ID
			FROM $wpdb->posts
			WHERE post_title = %s
			AND post_type = %s",
			$page_title,
			$post_type
		);
	}

	$page = $wpdb->get_var( $sql ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.NotPrepared

	if ( $page ) {
		return get_post( $page, $output );
	}

	return null;
}