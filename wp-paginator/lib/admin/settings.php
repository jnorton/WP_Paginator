<?php

$settings = $this->getSettings();

?>
<style type="text/css">
	#wrap { width: 700px; }
	#wrap code { margin: 0; padding: 0; }
	#pagination_admin_form #pagination_admin_table { width: 700px; }
	#pagination_admin_form #pagination_admin_table td { display: block; margin: 5px 10px; padding: 20px; border: 1px solid #ddd; background-color: #f8f8f8; }
	#pagination_admin_form #pagination_admin_table small td { display: table-cell; vertical-align: top; }
	#pagination_admin_form #pagination_admin_table h3 { margin: 0; }
	#redirect-url { width: 500px; }
	.wp-paginator-css { width: 100%; height: 300px; }
	.message { padding: 0 10px; border: 1px solid #1b1b1b; background: #ccc; }
	.success { border-color: #445026; background: #c4e0b4; }
	.error { border-color: #a62d38; background: #f0d6d6; }
	
</style>
<div id="wrap" class="wrap">
	<div class="icon32" id="icon-options-general"><br/></div>
	<h2><?php _e('WP Paginator Settings'); ?></h2>

	<form id="pagination_admin_form" method="post" action="">
	

	
	
		<div id="poststuff" class="form-table">
		
					<div class="postbox">
						<h3><span><?php _e('General Settings'); ?></span></h3>
					

					
					<div class="inside">
					
											<h4><label for="pagination_return_style"><?php _e('Pagination Return Style'); ?></label></h4>
						<p>
							<select name="pagination_return_style">
								<option value="array" <?php if ($settings['pagination_return_style']=="array") { echo 'selected="selected"'; } ?>>Array</option>
								<option value="list" <?php if ($settings['pagination_return_style']=="list") { echo 'selected="selected"'; } ?>>List</option>
								<option value="plain" <?php if ($settings['pagination_return_style']=="plain") { echo 'selected="selected"'; } ?>>Plain</option>
							</select>
						</p>
						
					
											<h4><label for="pagination_display_separator"><?php _e('Pagination Display Separator'); ?></label></h4>
						<p>
							<select name="pagination_display_separator">
								<option value="true" <?php if ($settings['pagination_display_separator']=="true") { echo 'selected="selected"'; } ?>>True</option>
								<option value="false" <?php if ($settings['pagination_display_separator']=="false") { echo 'selected="selected"'; } ?>>False</option>
							</select>
						</p>
						
						
						<h4><label for="pagination_separator"><?php _e('Pagination Separator'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_separator" value="<?php if ($settings['pagination_separator']) { echo $settings['pagination_separator']; } ?>">
						</p>
					
					
						<h4><label for="pagination_alignment"><?php _e('Pagination Alignment Style'); ?></label></h4>
						<p>
							<select name="pagination_alignment">
								<option value="left" <?php if ($settings['pagination_alignment']=="left") { echo 'selected="selected"'; } ?>>Left</option>
								<option value="right" <?php if ($settings['pagination_alignment']=="right") { echo 'selected="selected"'; } ?>>Right</option>
								<option value="centered" <?php if ($settings['pagination_alignment']=="centered") { echo 'selected="selected"'; } ?>>Centered</option>
							</select>
						</p>
					
					
					
						<h4><label for="pagination_link_pad"><?php _e('Pagination Link Padding'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_link_pad" value="<?php if ($settings['pagination_link_pad']) { echo $settings['pagination_link_pad']; } ?>">
						</p>
						<p class="small">Link padding is used to control how numbers of displayed to the user. E.g. if link padding is 3 and there are 20 pages of results then 1 2 3 will be displayed.</p>
						</div>
						</div>
			
						<div class="postbox">
						<h3><span><?php _e('Post Listings - Categories, Tags'); ?></span></h3>
			<div class="inside">
						<h4><label for="pagination_posts_next_text"><?php _e('Pagination Posts Next Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_posts_next_text" value="<?php if ($settings['pagination_posts_next_text']) { echo $settings['pagination_posts_next_text']; } ?>">
						</p>
						<p class="small">Enter a link style for next page pagination links on post listings e.g. next &rarr;</p>
					
					
					
						<h4><label for="pagination_posts_previous_text"><?php _e('Pagination Posts Previous Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_posts_previous_text" value="<?php if ($settings['pagination_posts_previous_text']) { echo $settings['pagination_posts_previous_text']; } ?>">
						</p>
						<p class="small">Enter a link style for previous page pagination links on post listings e.g. &larr; previous</p>
					
					

						</div>
						</div>
						
						<div class="postbox">
						<h3><span><?php _e('Single Post'); ?></span></h3>
			<div class="inside">
									<h4><label for="pagination_multipage_position"><?php _e('Multipage Pagination Position'); ?></label></h4>
					<p>
							<select name="pagination_multipage_position">
							
								<option value="left" <?php if ($settings['pagination_multipage_position']=='left') { echo 'selected="selected"'; } ?>>Left</option>
								<option value="centered" <?php if ($settings['pagination_multipage_position']=='centered') { echo 'selected="selected"'; } ?>>Centered</option>
								<option value="right" <?php if ($settings['pagination_multipage_position']=='right') { echo 'selected="selected"'; } ?>>Right</option>
								
							</select>
						</p>
						<p class="small">Set the alignment css class name for multipage posts.</p>
						
															<h4><label for="pagination_multipage_next_prev_display"><?php _e('Multipage Pagination Display Next / Previous Links'); ?></label></h4>
					<p>
							<select name="pagination_multipage_next_prev_display">
							
								<option value="true" <?php if ($settings['pagination_multipage_next_prev_display']=='true') { echo 'selected="selected"'; } ?>>True</option>
								<option value="false" <?php if ($settings['pagination_multipage_next_prev_display']=='false') { echo 'selected="selected"'; } ?>>False</option>

							</select>
						</p>
						<p class="small">Enable next / previous links for multipage posts.</p>
			
						<h4><label for="pagination_multipage_next_text"><?php _e('Multipage Pagination Next Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_multipage_next_text" value="<?php if ($settings['pagination_multipage_next_text']) { echo $settings['pagination_multipage_next_text']; } ?>">
						</p>
						<p class="small">Enter a link style for multipage pagination next page links on single post pages e.g. next &rarr;</p>
					
					
					
						<h4><label for="pagination_multipage_previous_text"><?php _e('Multipage Pagination Previous Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_multipage_previous_text" value="<?php if ($settings['pagination_multipage_previous_text']) { echo $settings['pagination_multipage_previous_text']; } ?>">
						</p>
						<p class="small">Enter a link style for multipage pagination previous page links on single post pages e.g. &larr; previous</p>
						
						
						<h4><label for="pagination_ajacent_posts_text_type"><?php _e('Ajacent Posts Text Type'); ?></label></h4>
					<p>
							<select name="pagination_ajacent_posts_text_type">
							
								<option value="posttitle" <?php if ($settings['pagination_ajacent_posts_text_type']=='posttitle') { echo 'selected="selected"'; } ?>>Post Title</option>
								<option value="text" <?php if ($settings['pagination_ajacent_posts_text_type']=='text') { echo 'selected="selected"'; } ?>>Text</option>
							</select>
						</p>
						
						<h4><label for="pagination_ajacent_posts_previous_text"><?php _e('Prepend Text to Ajacent  Post Link'); ?></label></h4>
											<p>
							<input type="text" class="regular-text ltr" name="pagination_ajacent_posts_previous_text" value="<?php if ($settings['pagination_ajacent_posts_previous_text']) { echo $settings['pagination_ajacent_posts_previous_text']; } ?>">
						</p>
						
							<h4><label for="pagination_ajacent_posts_next_text"><?php _e('Append Text to Ajacent  Post Link'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_ajacent_posts_next_text" value="<?php if ($settings['pagination_ajacent_posts_next_text']) { echo $settings['pagination_ajacent_posts_next_text']; } ?>">
						</p>
						
						<h4><label for="pagination_ajacent_next_posts_text"><?php _e('Ajacent Post Next Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_ajacent_next_posts_text" value="<?php if ($settings['pagination_ajacent_next_posts_text']) { echo $settings['pagination_ajacent_next_posts_text']; } ?>">
						</p>
						<p class="small">Enter a link style for next ajacent links on single post pages e.g. next &rarr;</p>
					
						<h4><label for="pagination_ajacent_previous_posts_text"><?php _e('Ajacent Post Previous Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_ajacent_previous_posts_text" value="<?php if ($settings['pagination_ajacent_previous_posts_text']) { echo $settings['pagination_ajacent_previous_posts_text']; } ?>">
						</p>
						<p class="small">Enter a link style for next ajacent links on single post pages e.g. &larr; previous</p>
					
						</div>
						</div>


					<div class="postbox">
						<h3><span><?php _e('Search Results'); ?></span></h3>
			<div class="inside">
						<h4><label for="pagination_search_next_text"><?php _e('Pagination Search Next Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_search_next_text" value="<?php if ($settings['pagination_search_next_text']) { echo $settings['pagination_search_next_text']; } ?>">
						</p>
						<p class="small">Enter a link style for next page pagination links on search results e.g. next &rarr;</p>
					
					
					
						<h4><label for="pagination_search_previous_text"><?php _e('Pagination Search Previous Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_search_previous_text" value="<?php if ($settings['pagination_search_previous_text']) { echo $settings['pagination_search_previous_text']; } ?>">
						</p>
						<p class="small">Enter a link style for previous page pagination links on search results e.g. &larr; previous</p>
					
					

						</div>
						</div>

						
											<div class="postbox">
						<h3><span><?php _e('Date-based Archives'); ?></span></h3>
					<div class="inside">
					
																<h4><label for="pagination_archive_datetime"><?php _e('Archive Link Text Type'); ?></label></h4>
					<p>
							<select name="pagination_archive_datetime">
							
								<option value="datetime" <?php if ($settings['pagination_archive_datetime']=='datetime') { echo 'selected="selected"'; } ?>>Date / Time</option>
								<option value="text" <?php if ($settings['pagination_archive_datetime']=='text') { echo 'selected="selected"'; } ?>>Text</option>
							</select>
						</p>
																						<h4><label for="pagination_archives_year_date_format"><?php _e('Year Date Format'); ?></label></h4>
											<p>
							<input type="text" class="regular-text ltr" name="pagination_archives_year_date_format" value="<?php if ($settings['pagination_archives_year_date_format']) { echo $settings['pagination_archives_year_date_format']; } ?>">
						</p>
																												<h4><label for="pagination_archives_month_date_format"><?php _e('Month Date Format'); ?></label></h4>
											<p>
							<input type="text" class="regular-text ltr" name="pagination_archives_month_date_format" value="<?php if ($settings['pagination_archives_month_date_format']) { echo $settings['pagination_archives_month_date_format']; } ?>">
						</p>
																												<h4><label for="pagination_archives_day_date_format"><?php _e('Day Date Format'); ?></label></h4>
											<p>
							<input type="text" class="regular-text ltr" name="pagination_archives_day_date_format" value="<?php if ($settings['pagination_archives_day_date_format']) { echo $settings['pagination_archives_day_date_format']; } ?>">
						</p>
						
						<h4><label for="pagination_archives_date_previous_text"><?php _e('Prepend Text to Previous Date Link'); ?></label></h4>
											<p>
							<input type="text" class="regular-text ltr" name="pagination_archives_date_previous_text" value="<?php if ($settings['pagination_archives_date_previous_text']) { echo $settings['pagination_archives_date_previous_text']; } ?>">
						</p>
						
							<h4><label for="pagination_archives_date_next_text"><?php _e('Append Text to Next Date Link'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_archives_date_next_text" value="<?php if ($settings['pagination_archives_date_next_text']) { echo $settings['pagination_archives_date_next_text']; } ?>">
						</p>
						
						<p class="small">Archive links will be rendered using date/time if you choose this setting and the text generated will rendered using the PHP date() format specified in the 'Date Format' field. If you choose to display archive links as text then the 'Pagination Archives Next Text' and 'Pagination Archives Previous Text' will be used.</p>
					
											<h4><label for="pagination_archives_next_text"><?php _e('Pagination Archives Next Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_archives_next_text" value="<?php if ($settings['pagination_archives_next_text']) { echo $settings['pagination_archives_next_text']; } ?>">
						</p>
						<p class="small">Enter a link style for next page pagination links on archive listings e.g. next &rarr;</p>
					
						<h4><label for="pagination_archives_previous_text"><?php _e('Pagination Archives Previous Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_archives_previous_text" value="<?php if ($settings['pagination_archives_previous_text']) { echo $settings['pagination_archives_previous_text']; } ?>">
						</p>
						<p class="small">Enter a link style for previous page pagination links on archive listings e.g. &larr; previous</p>
						
						</div>
						</div>
				
						<div class="postbox">
						<h3><span><?php _e('Comments'); ?></span></h3>
						
						<div class="inside">
						<h4><label for="pagination_comments_next_text"><?php _e('Pagination Comments Next Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_comments_next_text" value="<?php if ($settings['pagination_comments_next_text']) { echo $settings['pagination_comments_next_text']; } ?>">
						</p>
						<p class="small">Enter a link style for next page pagination links on comment listings e.g. next &rarr;</p>
				
						<h4><label for="pagination_comments_previous_text"><?php _e('Pagination Comments Previous Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_comments_previous_text" value="<?php if ($settings['pagination_comments_previous_text']) { echo $settings['pagination_comments_previous_text']; } ?>">
						</p>
						<p class="small">Enter a link style for previous page pagination links on comment listings e.g. &larr; previous</p>
					
					
						<h4><label for="reverse_comments"><?php _e('Reverse Comments'); ?></label></h4>
						<p>
							<select name="reverse_comments">
							
								<option value="true" <?php if ($settings['reverse_comments']=='true') { echo 'selected="selected"'; } ?>>True</option>
								<option value="false" <?php if ($settings['reverse_comments']=='false') { echo 'selected="selected"'; } ?>>False</option>
							</select>
						</p>
						<p class="small">This is an advanced setting that will reverse the display order of comments. WARNING: Enabling this option will alter the core WordPress option 'default_comments_page' and set it to the value 'oldest', the WordPress option is labelled 'first and can be set at: /wp-admin/options-discussion.php</p><p class="small">This option will also add a filter to reverse the order of comments so that newest comments are displayed first.</p>
						
												<h4><label for="pagination_comments_reversed_next_text"><?php _e('Reversed: Pagination Comments Next Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_comments_reversed_next_text" value="<?php if ($settings['pagination_comments_reversed_next_text']) { echo $settings['pagination_comments_reversed_next_text']; } ?>">
						</p>
						<p class="small">Enter a link style for previous page pagination links on comment listings e.g. &larr; Older comments</p>

					
												<h4><label for="pagination_comments_reversed_previous_text"><?php _e('Reversed: Pagination Comments Previous Text'); ?></label></h4>
						<p>
							<input type="text" class="regular-text ltr" name="pagination_comments_reversed_previous_text" value="<?php if ($settings['pagination_comments_reversed_previous_text']) { echo $settings['pagination_comments_reversed_previous_text']; } ?>">
						</p>
						<p class="small">Enter a link style for previous page pagination links on comment listings e.g. Newer comments &rarr;</p>
						</div>
						</div>
																		
			
		<p class="submit">
			<?php wp_nonce_field('save-paginator-settings'); ?>
			<input type="submit" name="save-paginator-settings" id="save-paginator-settings" value="<?php _e('Save Settings'); ?>" />
		</p>
	</form>
</div>