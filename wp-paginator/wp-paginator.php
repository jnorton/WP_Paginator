<?php
/*
Plugin Name: WP Paginator
Author: Justin Norton
Author URI: http://www.jnorton.co.uk
Plugin URI: http://www.jnorton.co.uk
Description: This plugin provides a simple way of displaying pagination for archives, comments and posts.
Version: 1.1.1
*/


if (!class_exists('WP_Paginator')) {

	class WP_Paginator
	{

		var $settings;
		var $is_next;
		var $is_previous;
		var $link_pad;

		function WP_Paginator()
		{
			register_activation_hook(__FILE__, array(&$this, 'saveDefaultSettings'));
			$settings = $this->getSettings();
			$this->settings = $settings;

			if ($settings['reverse_comments'] == 'true') {
				add_filter('comments_array', array(&$this, 'wp_paginator_change_order'));
				update_option('default_comments_page', 'oldest'); // String
			} else {
				remove_filter('comments_array', array(&$this, 'wp_paginator_change_order'));
			}

			add_action('admin_init', array(&$this, 'checkForSettingsSave'));
			add_action('admin_menu', array(&$this, 'addAdministrativeElements'));

			//custom actions
			add_action( 'wp_paginator_links', array(&$this, 'wp_paginator_links'), 10, 2);
		}


		//admin
		function addAdministrativeElements()
		{
			add_options_page(__('WP Paginator'), __('WP Paginator'), 'manage_options', 'wp-paginator', array(&$this, 'displaySettingsPage'));
		}


		function displaySettingsPage()
		{
			include 'lib/admin/settings.php';
		}


		function checkForSettingsSave()
		{

			if (isset($_POST['save-paginator-settings']) && current_user_can('manage_options') && check_admin_referer('save-paginator-settings')) {

				$settings = $this->getSettings();

				foreach ($_POST as $key => $data) {
					$settings[$key] = $_POST[$key];
				}

				$this->saveSettings($settings);
				wp_redirect(admin_url('options-general.php?page=wp-paginator&updated=1'));
			}
		}


		function saveDefaultSettings()
		{
			$settings = $this->getSettings();
			if ( empty($settings)) {
				$settings = array();
				//general
				$settings['pagination_return_style'] = "plain";
				$settings['pagination_display_separator'] = "true";
				$settings['pagination_separator'] = "&nbsp;&#124;&nbsp;";
				$settings['pagination_alignment'] = "centered";
				$settings['pagination_link_pad'] = "5";

				//post listings
				$settings['pagination_posts_next_text'] = "Older articles &rarr;";
				$settings['pagination_posts_previous_text'] = "&larr; Newer articles";

				//single

				$settings['pagination_multipage_next_prev_display'] =  "true";
				$settings['pagination_multipage_position'] =  "centered";
				$settings['pagination_multipage_next_text'] = "Next page &rarr;";
				$settings['pagination_multipage_previous_text'] = "&larr; Previous page";
				$settings['pagination_ajacent_posts_text_type'] = "text";
				$settings['pagination_ajacent_posts_previous_text'] = "&larr; ";
				$settings['pagination_ajacent_posts_next_text'] = " &rarr;";
				$settings['pagination_ajacent_next_posts_text'] = "Next article &rarr;";
				$settings['pagination_ajacent_previous_posts_text'] = "&larr; Previous article";

				//search
				$settings['pagination_search_next_text'] = "Next &rarr;";
				$settings['pagination_search_previous_text'] = "&larr; Previous";

				//archives
				$settings['pagination_archive_datetime'] = "text";
				$settings['pagination_archives_year_date_format'] = "Y";
				$settings['pagination_archives_month_date_format'] = "F Y";
				$settings['pagination_archives_day_date_format'] = "jS F Y";
				$settings['pagination_archives_date_next_text'] = " &rarr;";
				$settings['pagination_archives_date_previous_text'] = "&larr; ";
				$settings['pagination_archives_next_text'] = "Newer articles &rarr;";
				$settings['pagination_archives_previous_text'] = "&larr; Older articles";

				//comments
				$settings['pagination_comments_next_text'] = "Newer comments &rarr;";
				$settings['pagination_comments_previous_text'] = "&larr; Older comments";
				$settings['reverse_comments'] = 'false';
				$settings['pagination_comments_reversed_next_text'] = "Older comments &rarr;";
				$settings['pagination_comments_reversed_previous_text'] = "&larr; Newer comments";
				$this->saveSettings($settings);
			}
		}


		function getSettings()
		{
			if ($this->settings === null) {
				$defaults = array();
				$this->settings = get_option('WP Paginator Settings', array());
			}

			return $this->settings;
		}


		function saveSettings($settings)
		{
			if (!is_array($settings)) {
				return;
			}
			$this->settings = $settings;
			update_option('WP Paginator Settings', $this->settings);
		}


		function isBoolean($value)
		{
			if ($value && strtolower($value) !== "false") {
				return true;
			} else {
				return false;
			}
		}


		function wp_paginator_change_order($comms)
		{
			return array_reverse($comms);
		}


		function wp_paginator_links($mode = null, $the_query = null)
		{

			//check for custom query
			if ($the_query) {
				$wp_query = $the_query;
				global $numpages, $post;
			} else {
				global $wp_query, $numpages, $post;
			}

			//extract settings to variables
			$settings = $this->settings;
			extract($settings);

			if ($mode == "nextprev") {
				$links = $this->wp_paginator_paginate_links($args, $mode, $the_query);
			}

			if ($mode == "search") {

				if ($wp_query->max_num_pages <= 1) {
					return;
				}
				$big = 999999999; // need an unlikely integer
				$args = array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'mid_size' => $pagination_link_pad,
					'prev_next'    => true,
					'prev_text'    => __($pagination_posts_previous_text),
					'next_text'    => __($pagination_posts_next_text),
					'type' => 'array',
				);
				$links = $this->wp_paginator_paginate_links($args, $mode);
			}


			if ($mode == "single") {

				$pagination_alignment = $pagination_multipage_position;

				if ($numpages <= 1) {
					return;
				}

				$args = array(
					"nextpagelink" => "next",
					"echo" => false
				);
				$args = array(
					//'base' => user_trailingslashit( trailingslashit(get_permalink( $post->ID ).'%#%')),
					'base' =>  get_permalink( $post->ID ).'%_%',
					'current' => max( 1, get_query_var('page') ),
					'total' => $numpages,
					'mid_size' => $pagination_link_pad,
					'prev_next'    => $this->isBoolean($pagination_multipage_next_prev_display),
					'prev_text'    => __($pagination_multipage_previous_text),
					'next_text'    => __($pagination_multipage_next_text),
					'type' => 'array',
					'format' => '%#%',
				);
				$links = $this->wp_paginator_paginate_links($args, $mode);

			}

			if ($mode == "posts") {

				if ($wp_query->max_num_pages < 1) {
					return;
				}

				$url = parse_url(html_entity_decode(get_pagenum_link( 1 )));


				//$base = user_trailingslashit( trailingslashit( remove_query_arg( array_keys($query_array), html_entity_decode(get_pagenum_link( 1 )) ) ) . 'page/%#%/', 'paged' );
				if(isset($url['query']) && $url['query']){
					parse_str($url['query'], $query_array);
					$base =  user_trailingslashit(remove_query_arg( array_keys($query_array), html_entity_decode(get_pagenum_link( 1 )) ) . 'page/%#%/');
				} else {
					$base = get_pagenum_link(1) . '%_%';
				}

				if(isset($url["query"])){
					$add_fragment = "?".$url["query"];
				} else {
					$add_fragment = '';
				}

				$args = array(
					'base' => $base,
					//'base' => get_pagenum_link(1) . '%_%',
					//'format' => '?paged=%#%',
					'format' => 'page/%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'mid_size' => $pagination_link_pad,
					'prev_next'    => true,
					'prev_text'    => __($pagination_posts_previous_text),
					'next_text'    => __($pagination_posts_next_text),
					'type' => 'array',
					'add_fragment' => $add_fragment
				);
				$links = $this->wp_paginator_paginate_links($args, $mode);

			}

			if ($mode == "comments") {

				if ($settings['reverse_comments'] == 'true') {
					$pagination_comments_next_text = $pagination_comments_reversed_next_text;
					$pagination_comments_previous_text = $pagination_comments_reversed_previous_text;
				}

				$args = array(
					'mid_size' => $pagination_link_pad,
					'prev_next'    => true,
					'prev_text'    => __($pagination_comments_previous_text),
					'next_text'    => __($pagination_comments_next_text),
					'echo' => false,
					'type' => 'array',
				);
				$links = $this->wp_paginator_paginate_links($args, $mode);

			}

			if ($mode == "archives") {

				if ( is_day() ) {
					$links = $this->wp_paginator_archive_pagination("day", $wp_query);
				} elseif ( is_month() ) {
					$links = $this->wp_paginator_archive_pagination("month", $wp_query);
				} elseif ( is_year() ) {
					$links = $this->wp_paginator_archive_pagination("year", $wp_query);
				} else {
					$links = $this->wp_paginator_archive_pagination("month", $wp_query);
				}

			}

			wp_reset_query();

			if ($links) {

				if ( $settings['pagination_return_style']!="array") {
					echo '<nav id="'.$mode.'-pagination" class="clearfix pagination '.$pagination_alignment.'">';
					if ($pagination_alignment == "centered") {
						echo '<div class="pagination-centered">';
						echo $links;
						echo '</div>';
					} elseif ($pagination_alignment == "left") {
						echo '<div class="pull-left">';
						echo $links;
						echo '</div>';
					} elseif ($pagination_alignment == "right") {
						echo '<div class="pull-right">';
						echo $links;
						echo '</div>';
					}
					echo '</nav>';
				} else {
					return $links;

				}
			}
		}


		function wp_paginator_paginate_links( $args = '', $mode = null, $the_query = null)
		{

			//check for custom query
			if ($the_query) {
				$wp_query = $the_query;
				global $numpages, $post;
			} else {
				global $wp_query, $numpages, $post;
			}

			//extract settings to variables
			$settings = $this->settings;
			extract($settings);

			$page_links = array();

			if ($mode == "posts" || $mode == "single" || $mode == "search") {

				$links = paginate_links($args);
				if ($pagination_display_separator=="true") {
					$total = count($links);
					for ($i=0;$i<$total;$i++) {
						$page_links[] = $links[$i];
						if ($i <= $total-2 && !preg_match("/dots/i", $links[$i])) {
							$page_links[] = '<span class="sep">'.$pagination_separator.'</span>';
						}
					}
				} else {
					$page_links = $links;
				}

			}

			if ($mode == "nextprev") {
				$prev_post = get_previous_post();
				$next_post = get_next_post();

				if ($pagination_ajacent_posts_text_type == "posttitle") {
					$prev_text = $pagination_ajacent_posts_previous_text.$prev_post->post_title;
					$next_text = $next_post->post_title.$pagination_ajacent_posts_next_text;
				} else {
					$prev_text = $pagination_ajacent_previous_posts_text;
					$next_text = $pagination_ajacent_next_posts_text;
				}

				$prev_post_link = '<a class="ajacent prev" href="'.get_permalink($prev_post->ID).'">'.$prev_text.'</a>';
				$next_post_link = '<a class="ajacent next" href="'.get_permalink($next_post->ID).'">'.$next_text.'</a>';

				if ($prev_post) {
					$page_links[] = $prev_post_link;
				}
				if ($prev_post && $next_post && $pagination_display_separator=="true") {
					$page_links[] = '<span class="sep">'.$pagination_separator.'</span>';
				}
				if ($next_post) {
					$page_links[] = $next_post_link;
				}

			}

			if ($mode == "comments") {
				$links = paginate_comments_links($args);

				if ($pagination_display_separator=="true") {
					$total = count($links);
					for ($i=0;$i<$total;$i++) {
						$page_links[] = $links[$i];
						if ($i <= $total-2 && !preg_match("/dots/i", $links[$i])) {
							$page_links[] = '<span class="sep">'.$pagination_separator.'</span>';
						}
					}
				} else {
					$page_links = $links;
				}

			}

			if (!$page_links) {
				return;
			}

			return $this->return_pagination($page_links);

		}


		function wp_paginator_archive_pagination($type = null, $the_query = null)
		{

			//check for custom query
			if ($the_query) {
				$wp_query = $the_query;
				global $post;
			} else {
				global $wp_query, $post;
			}

			//set up function variables
			$prev = '';
			$next = '';

			//extract settings to variables
			$settings = $this->settings;
			extract($settings);

			$archive_type = $type;

			//YEARLY ACRHIVES
			if ($archive_type == "year") {

				$current_year = get_query_var('year');
				$previous_year = date('Y', strtotime(get_the_date( 'Y' )." -1 year"));
				$next_year = date('Y', strtotime(get_the_date( 'Y' )." +1 year"));

				$args = array(
					'posts_per_page' => 1,
					'year' => $previous_year,
					'ignore_sticky_posts' => 1
				);
				$archive_test_older_query = new WP_Query( $args );
				if ( $archive_test_older_query->have_posts() ) {

					if ($pagination_archive_datetime == "datetime") {
						$prev_text = $pagination_archives_date_previous_text.date($pagination_archives_year_date_format, mktime(0, 0, 0, 1, 1, $previous_year));
					} else {
						$prev_text = $pagination_archives_previous_text;
					}

					$prev = '<a href="'.get_year_link($previous_year).'">'.$prev_text.'</a>';

				}

				$args = array(
					'posts_per_page' => 1,
					'year' => $next_year,
					'ignore_sticky_posts' => 1
				);
				$archive_test_newer_query = new WP_Query( $args );
				if ( $archive_test_newer_query->have_posts() ) {

					if ($pagination_archive_datetime == "datetime") {
						$next_text = date($pagination_archives_year_date_format, mktime(0, 0, 0, 1, 1, $next_year)).$pagination_archives_date_next_text;
					} else {
						$next_text = $pagination_archives_next_text;
					}

					$next = '<a href="'.get_year_link($next_year).'">'.$next_text.'</a>';
				}

			}

			//MONTHLY ACRHIVES
			if ($archive_type == "month") {

				$args = array(
					'posts_per_page' => 1,
					'year' => date('Y', strtotime(get_the_date( 'Y' )." -1 month")),
					'monthnum' =>  date('m', strtotime(get_the_date( 'Y-m' )." -1 month")),
					'ignore_sticky_posts' => 1
				);
				$the_query = new WP_Query( $args );

				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$previous_year = date("Y", strtotime(get_the_date('Y-m-d')));
					$previous_month = date("n", strtotime(get_the_date('Y-m-d')));

					if ($pagination_archive_datetime == "datetime") {
						$prev_text = $pagination_archives_date_previous_text.date($pagination_archives_month_date_format, mktime(0, 0, 0, $previous_month, 1, $previous_year));
					} else {
						$prev_text = $pagination_archives_previous_text;
					}

					$prev = '<a href="'.get_month_link($previous_year, $previous_month).'">'.$prev_text.'</a>';
					endwhile;
				}

				wp_reset_query();

				$args = array(
					'posts_per_page' => 1,
					'order'=>'ASC',
					'year' => date('Y', strtotime(get_the_date( 'Y' )." +1 month")),
					'monthnum' =>  date('m', strtotime(get_the_date( 'Y-m' )." +1 month")),
					'ignore_sticky_posts' => 1
				);
				$the_query = new WP_Query( $args );

				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$next_year = date("Y", strtotime(get_the_date('Y-m-d')));
					$next_month = date("n", strtotime(get_the_date('Y-m-d')));

					if ($pagination_archive_datetime == "datetime") {
						$next_text = date($pagination_archives_month_date_format, mktime(0, 0, 0, $next_month, 1, $next_year)).$pagination_archives_date_next_text;
					} else {
						$next_text = $pagination_archives_next_text;
					}

					$next = '<a href="'.get_month_link($next_year, $next_month).'">'.$next_text.'</a>';
					endwhile;
				}

			}

			//DAILY ACRHIVES
			if ($archive_type == "day") {

				function filter_past( $where = '' )
				{
					$past_date = date('Y-m-d', strtotime(get_the_date( 'Y-m-d' )." -1 day"));
					// posts in the last x days
					$where .= " AND post_date < '".$past_date."'";
					return $where;
				}


				add_filter( 'posts_where', 'filter_past' );
				$args = array(
					'posts_per_page' => 1,
					'ignore_sticky_posts' => 1
				);
				$test_query = new WP_Query( $args );
				remove_filter( 'posts_where', 'filter_past' );

				if ( $test_query->have_posts() ) {

					while ( $test_query->have_posts() ) : $test_query->the_post();
					$previous_year = date("Y", strtotime(get_the_date('Y-m-d')));
					$previous_month = date("n", strtotime(get_the_date('Y-m-d')));
					$previous_day = date("d", strtotime(get_the_date('Y-m-d')));

					if ($pagination_archive_datetime == "datetime") {
						$prev_text = $pagination_archives_date_previous_text.date($pagination_archives_day_date_format, mktime(0, 0, 0, $previous_month, $previous_day, $previous_year));
					} else {
						$prev_text = $pagination_archives_previous_text;
					}

					$prev = '<a href="'.get_day_link($previous_year, $previous_month, $previous_day).'">'.$prev_text.'</a>';
					endwhile;
				}

				wp_reset_query();

				//create future date 1st of next month
				function filter_future( $where = '' )
				{
					$future_date = date('Y-m-d', strtotime(get_the_date( 'Y-m-d' )." +1 day"));
					// posts in the last x days
					$where .= " AND post_date >= '" . $future_date . "'";
					return $where;
				}


				add_filter( 'posts_where', 'filter_future' );
				$args = array(
					'posts_per_page' => 1,
					'order'=>'ASC',
					'ignore_sticky_posts' => 1
				);
				$the_query = new WP_Query( $args );
				remove_filter( 'posts_where', 'filter_future' );

				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$next_year = date("Y", strtotime(get_the_date('Y-m-d')));
					$next_month = date("n", strtotime(get_the_date('Y-m-d')));
					$next_day = date("d", strtotime(get_the_date('Y-m-d')));

					if ($pagination_archive_datetime == "datetime") {
						$next_text = date($pagination_archives_day_date_format, mktime(0, 0, 0, $next_month, $next_day, $next_year)).$pagination_archives_date_next_text;
					} else {
						$next_text = $pagination_archives_next_text;
					}
					$next = '<a href="'.get_day_link($next_year, $next_month, $next_day).'">'.$next_text.'</a>';
					endwhile;
				}

			}

			if (!$prev && !$next) {
				return;
			}

			if ($prev) {
				$page_links[] = $prev;
			}
			if ( $prev && $next && $pagination_display_separator=="true") {
				$page_links[] = '<span class="sep">'.$pagination_separator.'</span>';
			}
			if ($next) {
				$page_links[] = $next;
			}

			return $this->return_pagination($page_links);

		}


		function return_pagination($page_links)
		{

			$settings = $this->settings;
			extract($settings);


			switch ( $pagination_return_style ) :
			case 'array' :
				return $page_links;
			break;
		case 'list' :
			$r = '';
			$r .= "<ul class='pagination'>\n\t<li>";
			$r .= join("</li>\n\t<li>", $page_links);
			$r .= "</li>\n</ul>\n";
			break;
		default :
			$r = join("\n", $page_links);
			break;
			endswitch;
			return $r;

		}


	}


	$WP_Paginator = new WP_Paginator();

}

?>