<div style="<?php echo $RESET_CSS ?> height: 30px"></div>
<div id="sy_debug_resize_bar_wrapper" style="<?php echo $RESET_CSS ?> height: 4px; display: none;"></div>
<div id="sy_debug_console" style="<?php echo $RESET_CSS ?> height: 270px; display: none;"></div>

<div style="<?php echo $RESET_CSS ?> position: fixed; bottom: 0; left: 0; width: 100%; font-size: 11px; z-index: 10000;">
	<div id="sy_debug_resize_bar" style="<?php echo $RESET_CSS ?> height: 4px; cursor: n-resize; display: none; background-color: #ddd;"></div>
	<div style="overflow-x:auto; overflow-y:hidden">
		<div id="sy_debug_bar" style="<?php echo $RESET_CSS ?> border-top: 1px solid #999; height: 30px; background-color: #ddd; min-width: 550px;">
			<?php if ($PHP_INFO): ?>
			<a id="sy_debug_php_content_title" href="#" style="<?php echo $RESET_CSS ?> text-decoration: none; background-color: transparent; color: #555;" onclick="sy_debug.show_content('php'); return false;">
				<div style="display: inline-block; margin-left: 10px">
					<svg style="height: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 -1 100 50">
						<path d="m7.579 10.123 14.204 0c4.169 0.035 7.19 1.237 9.063 3.604 1.873 2.367 2.491 5.6 1.855 9.699-0.247 1.873-0.795 3.71-1.643 5.512-0.813 1.802-1.943 3.427-3.392 4.876-1.767 1.837-3.657 3.003-5.671 3.498-2.014 0.495-4.099 0.742-6.254 0.742l-6.36 0-2.014 10.07-7.367 0 7.579-38.001 0 0m6.201 6.042-3.18 15.9c0.212 0.035 0.424 0.053 0.636 0.053 0.247 0 0.495 0 0.742 0 3.392 0.035 6.219-0.3 8.48-1.007 2.261-0.742 3.781-3.321 4.558-7.738 0.636-3.71 0-5.848-1.908-6.413-1.873-0.565-4.222-0.83-7.049-0.795-0.424 0.035-0.83 0.053-1.219 0.053-0.353 0-0.724 0-1.113 0l0.053-0.053"/>
						<path d="m41.093 0 7.314 0-2.067 10.123 6.572 0c3.604 0.071 6.289 0.813 8.056 2.226 1.802 1.413 2.332 4.099 1.59 8.056l-3.551 17.649-7.42 0 3.392-16.854c0.353-1.767 0.247-3.021-0.318-3.763-0.565-0.742-1.784-1.113-3.657-1.113l-5.883-0.053-4.346 21.783-7.314 0 7.632-38.054 0 0"/>
						<path d="m70.412 10.123 14.204 0c4.169 0.035 7.19 1.237 9.063 3.604 1.873 2.367 2.491 5.6 1.855 9.699-0.247 1.873-0.795 3.71-1.643 5.512-0.813 1.802-1.943 3.427-3.392 4.876-1.767 1.837-3.657 3.003-5.671 3.498-2.014 0.495-4.099 0.742-6.254 0.742l-6.36 0-2.014 10.07-7.367 0 7.579-38.001 0 0m6.201 6.042-3.18 15.9c0.212 0.035 0.424 0.053 0.636 0.053 0.247 0 0.495 0 0.742 0 3.392 0.035 6.219-0.3 8.48-1.007 2.261-0.742 3.781-3.321 4.558-7.738 0.636-3.71 0-5.848-1.908-6.413-1.873-0.565-4.222-0.83-7.049-0.795-0.424 0.035-0.83 0.053-1.219 0.053-0.353 0-0.724 0-1.113 0l0.053-0.053"/>
					</svg>
				</div>
				PHP <?php echo phpversion() ?>
			</a>
			<?php endif ?>
			<a id="sy_debug_var_content_title" href="#" style="<?php echo $RESET_CSS ?> text-decoration: none; background-color: transparent; color: #555;" onclick="sy_debug.show_content('var'); return false;">
				<div style="display: inline-block; margin-left: 10px">
					<svg style="height: 14px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path></svg>
				</div>
				Vars
			</a>
			<?php if ($WEB_LOGGER): ?>
			<a id="sy_debug_log_content_title" href="#" style="<?php echo $RESET_CSS ?> text-decoration: none; background-color: transparent; color: #555;" onclick="sy_debug.show_content('log'); return false;">
				<div style="display: inline-block; margin-left: 10px">
					<svg style="height: 14px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>
				</div>
				Logs <span style="<?php echo $RESET_CSS ?> color:red"><?php echo $NB_ERROR ?></span>
			</a>
			<?php endif ?>
			<?php if ($FILE_LOGGER): ?>
			<a id="sy_debug_file_content_title" href="#" style="<?php echo $RESET_CSS ?> text-decoration: none; background-color: transparent; color: #555;" onclick="sy_debug.show_content('file'); return false;">
				<div style="display: inline-block; margin-left: 10px">
					<svg style="height: 14px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M288 248v28c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-28c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm-12 72H108c-6.6 0-12 5.4-12 12v28c0 6.6 5.4 12 12 12h168c6.6 0 12-5.4 12-12v-28c0-6.6-5.4-12-12-12zm108-188.1V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V48C0 21.5 21.5 0 48 0h204.1C264.8 0 277 5.1 286 14.1L369.9 98c9 8.9 14.1 21.2 14.1 33.9zm-128-80V128h76.1L256 51.9zM336 464V176H232c-13.3 0-24-10.7-24-24V48H48v416h288z"></path></svg>
				</div>
				Log File
			</a>
			<?php endif ?>
			<?php if ($QUERY_LOGGER): ?>
			<a id="sy_debug_query_content_title" href="#" style="<?php echo $RESET_CSS ?> text-decoration: none; background-color: transparent; color: #555;" onclick="sy_debug.show_content('query'); return false;">
				<div style="display: inline-block; margin-left: 10px">
					<svg style="height: 14px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M448 73.143v45.714C448 159.143 347.667 192 224 192S0 159.143 0 118.857V73.143C0 32.857 100.333 0 224 0s224 32.857 224 73.143zM448 176v102.857C448 319.143 347.667 352 224 352S0 319.143 0 278.857V176c48.125 33.143 136.208 48.572 224 48.572S399.874 209.143 448 176zm0 160v102.857C448 479.143 347.667 512 224 512S0 479.143 0 438.857V336c48.125 33.143 136.208 48.572 224 48.572S399.874 369.143 448 336z"></path></svg>
				</div>
				<?php echo $NB_QUERY ?>
			</a>
			<?php endif ?>
			<?php if ($TIME_RECORD): ?>
			<a id="sy_debug_time_content_title" href="#" style="<?php echo $RESET_CSS ?> text-decoration: none; background-color: transparent; color: #555;" onclick="sy_debug.show_content('time'); return false;">
				<div style="display: inline-block; margin-left: 10px">
					<svg style="height: 14px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"></path></svg>
				</div>
				<?php echo $MAX_TIME ?>
			</a>
			<?php endif ?>
			<div style="display: inline-block; margin-left: 10px; color: #555">
				<svg style="height: 14px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M332.8 320h38.4c6.4 0 12.8-6.4 12.8-12.8V172.8c0-6.4-6.4-12.8-12.8-12.8h-38.4c-6.4 0-12.8 6.4-12.8 12.8v134.4c0 6.4 6.4 12.8 12.8 12.8zm96 0h38.4c6.4 0 12.8-6.4 12.8-12.8V76.8c0-6.4-6.4-12.8-12.8-12.8h-38.4c-6.4 0-12.8 6.4-12.8 12.8v230.4c0 6.4 6.4 12.8 12.8 12.8zm-288 0h38.4c6.4 0 12.8-6.4 12.8-12.8v-70.4c0-6.4-6.4-12.8-12.8-12.8h-38.4c-6.4 0-12.8 6.4-12.8 12.8v70.4c0 6.4 6.4 12.8 12.8 12.8zm96 0h38.4c6.4 0 12.8-6.4 12.8-12.8V108.8c0-6.4-6.4-12.8-12.8-12.8h-38.4c-6.4 0-12.8 6.4-12.8 12.8v198.4c0 6.4 6.4 12.8 12.8 12.8zM496 384H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z"></path></svg>
			</div>
			<span style="<?php echo $RESET_CSS ?> line-height: 30px; color: #555;" title="Peak of memory allocated by PHP"><?php echo memory_get_peak_usage(true) / 1024 ?> KB</span>

			<button onclick="sy_debug.hide_bar()" title="Close" style="width: auto; margin: 0; margin-right: 7px; float: right; font-family: sans-serif; font-size: 20px; color: #777; line-height: 29px; text-shadow: 0 1px 0 #FFFFFF; opacity: 1; background: none repeat scroll 0 0 rgba(0, 0, 0, 0); border: 0 none; cursor: pointer; padding: 0;">&times;</button>
			<button id="sy_debug_close_button" onclick="sy_debug.hide_console()" title="Minimize" style="width: auto; display: none; margin: 0; margin-right: 7px; float: right; font-family: sans-serif; font-size: 20px; color: #777; line-height: 29px; text-shadow: 0 1px 0 #FFFFFF; opacity: 1; background: none repeat scroll 0 0 rgba(0, 0, 0, 0); border: 0 none; cursor: pointer; padding: 0;">&minus;</button>
		</div>
	</div>
	<div id="sy_debug_console_content" style="<?php echo $RESET_CSS ?> height: 270px; border-top: 1px solid #999; background-color: #FFF; display: none;">
		<?php if ($PHP_INFO): ?>
		<div id="sy_debug_php_content" style="<?php echo $RESET_CSS ?> height: 100%">
			<iframe id="sy_debug_console_content_iframe" src="<?php echo $_SERVER['PHP_SELF'] ?>?phpinfo&amp;sy_debug_log=off" style="width: 100%; height: 100%; border: 0;">
			<p>Your browser does not support iframes.</p>
			</iframe>
		</div>
		<?php endif ?>

		<div id="sy_debug_var_content" style="<?php echo $RESET_CSS ?> height: 100%; overflow: auto;">
			<?php echo $VARS_DIV ?>

			<h2 style="<?php echo $RESET_CSS ?> font-size: 14px; margin: 10px; line-height: 20px;">Included Files</h2>
			<table style="<?php echo $TABLE_RESET_CSS ?> width: 100%;">
				<tr style="<?php echo $TR_HEAD_CSS ?>">
					<th style="<?php echo $TH_CSS ?> min-width: 300px;">Filename</th>
				</tr>
				<?php echo $FILES ?>
			</table>
			<br />
		</div>

		<?php if ($WEB_LOGGER): ?>
		<div id="sy_debug_log_content" style="<?php echo $RESET_CSS ?> height: 100%; overflow: auto; position: relative;">
			<div onclick="sy_debug.get('log_filter_div').style.display = 'block';" style="<?php echo $RESET_CSS ?> position: absolute; top: 2px; left: 3px; cursor: pointer;">
				<svg style="height: 12px; color: white" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M336.174 80c-49.132 0-93.305-32-161.913-32-31.301 0-58.303 6.482-80.721 15.168a48.04 48.04 0 0 0 2.142-20.727C93.067 19.575 74.167 1.594 51.201.104 23.242-1.71 0 20.431 0 48c0 17.764 9.657 33.262 24 41.562V496c0 8.837 7.163 16 16 16h16c8.837 0 16-7.163 16-16v-83.443C109.869 395.28 143.259 384 199.826 384c49.132 0 93.305 32 161.913 32 58.479 0 101.972-22.617 128.548-39.981C503.846 367.161 512 352.051 512 335.855V95.937c0-34.459-35.264-57.768-66.904-44.117C409.193 67.309 371.641 80 336.174 80zM464 336c-21.783 15.412-60.824 32-102.261 32-59.945 0-102.002-32-161.913-32-43.361 0-96.379 9.403-127.826 24V128c21.784-15.412 60.824-32 102.261-32 59.945 0 102.002 32 161.913 32 43.271 0 96.32-17.366 127.826-32v240z"></path></svg>
			</div>
			<div id="sy_debug_log_filter_div" style="<?php echo $RESET_CSS ?> display: none; position: absolute; padding: 3px; background-color: #CCC; border-bottom: 1px solid #AAA; border-right: 1px solid #AAA;">
				<button onclick="sy_debug.get('log_filter_div').style.display = 'none';" title="Close" style="margin-left: 5px; float: right; font-size: 16px; font-weight: bold; color: #777; line-height: 16px; text-shadow: 0 1px 0 #FFFFFF; opacity: 1; background: none repeat scroll 0 0 rgba(0, 0, 0, 0); border: 0 none; cursor: pointer; padding: 0;">&times;</button>
				<div class="sy_debug_filter_checked" onclick="sy_debug.log_filter(this, 'green')" style="display: inline-block; cursor: pointer; float: none; border: 1px solid #375D81; background-color: #ABC8E2; padding: 2px; vertical-align: middle;"><?php echo $FLAG_NOTICE ?></div>
				<div class="sy_debug_filter_checked" onclick="sy_debug.log_filter(this, 'orange')" style="display: inline-block; cursor: pointer; float: none; margin-left: 10px; border: 1px solid #375D81; background-color: #ABC8E2; padding: 2px; vertical-align: middle;"><?php echo $FLAG_WARN ?></div>
				<div class="sy_debug_filter_checked" onclick="sy_debug.log_filter(this, 'red')" style="display: inline-block; cursor: pointer; float: none; margin-left: 10px; border: 1px solid #375D81; background-color: #ABC8E2; padding: 2px; vertical-align: middle;"><?php echo $FLAG_ERR ?></div>
			</div>
			<table style="<?php echo $TABLE_RESET_CSS ?> width: 100%;">
				<tr style="position: sticky; top: 0; <?php echo $TR_HEAD_CSS ?>">
					<th style="<?php echo $TH_CSS ?> min-width: 90px;">Level</th>
					<th style="<?php echo $TH_CSS ?>">Type</th>
					<th style="<?php echo $TH_CSS ?>">File</th>
					<th style="<?php echo $TH_CSS ?> width: 40px;">Line</th>
					<th style="<?php echo $TH_CSS ?>">Class</th>
					<th style="<?php echo $TH_CSS ?>">Function</th>
					<th style="<?php echo $TH_CSS ?> min-width: 300px;">Message</th>
				</tr>
				<?php echo $LOGS_DIV ?>
			</table>
		</div>
		<?php endif ?>

		<?php if ($FILE_LOGGER): ?>
		<div id="sy_debug_file_content" style="<?php echo $RESET_CSS ?> height: 100%; position: relative;">
			<div style="<?php echo $RESET_CSS ?> position: absolute; top: 0; left: 0; background-color: #fff; padding-top: 2px; padding-left: 3px;">
				<div onclick="document.getElementById('file_frame').src = '<?php echo $_SERVER['PHP_SELF'] ?>?<?php echo htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES, $CHARSET) ?>&amp;sy_debug_log_file&amp;sy_debug_log=off';" style="display: inline-block; cursor: pointer; color:green" title="Refresh">
					<svg style="height: 14px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M440.65 12.57l4 82.77A247.16 247.16 0 0 0 255.83 8C134.73 8 33.91 94.92 12.29 209.82A12 12 0 0 0 24.09 224h49.05a12 12 0 0 0 11.67-9.26 175.91 175.91 0 0 1 317-56.94l-101.46-4.86a12 12 0 0 0-12.57 12v47.41a12 12 0 0 0 12 12H500a12 12 0 0 0 12-12V12a12 12 0 0 0-12-12h-47.37a12 12 0 0 0-11.98 12.57zM255.83 432a175.61 175.61 0 0 1-146-77.8l101.8 4.87a12 12 0 0 0 12.57-12v-47.4a12 12 0 0 0-12-12H12a12 12 0 0 0-12 12V500a12 12 0 0 0 12 12h47.35a12 12 0 0 0 12-12.6l-4.15-82.57A247.17 247.17 0 0 0 255.83 504c121.11 0 221.93-86.92 243.55-201.82a12 12 0 0 0-11.8-14.18h-49.05a12 12 0 0 0-11.67 9.26A175.86 175.86 0 0 1 255.83 432z"></path></svg>
				</div>
				<div onclick="document.getElementById('file_frame').src = '<?php echo $_SERVER['PHP_SELF'] ?>?<?php echo htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES, $CHARSET) ?>&amp;sy_debug_log_file&amp;sy_debug_log_clear&amp;sy_debug_log=off';" style="display: inline-block; cursor: pointer; color:red" title="Clear">
					<svg style="height: 16px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
				</div>
			</div>
			<iframe id="file_frame" src="<?php echo $_SERVER['PHP_SELF'] ?>?sy_debug_log_file&amp;sy_debug_log=off" style="width: 100%; height: 100%; border: 0;">
			<p>Your browser does not support iframes.</p>
			</iframe>
		</div>
		<?php endif ?>

		<?php if ($QUERY_LOGGER): ?>
		<div id="sy_debug_query_content" style="<?php echo $RESET_CSS ?> height: 100%; overflow: auto; position: relative;">
			<table style="<?php echo $TABLE_RESET_CSS ?> width: 100%;">
				<tr style="position: sticky; top: 0; <?php echo $TR_HEAD_CSS ?>">
					<th style="<?php echo $TH_CSS ?>">#</th>
					<th style="<?php echo $TH_CSS ?>">File</th>
					<th style="<?php echo $TH_CSS ?> width: 40px;">Line</th>
					<th style="<?php echo $TH_CSS ?>">Class</th>
					<th style="<?php echo $TH_CSS ?>">Function</th>
					<th style="<?php echo $TH_CSS ?> min-width: 300px;">Message</th>
				</tr>
				<?php echo $QUERY_LOGS ?>
			</table>
		</div>
		<?php endif ?>

		<?php if ($TIME_RECORD): ?>
		<div id="sy_debug_time_content" style="<?php echo $RESET_CSS ?> height: 100%; overflow: auto;">
			<table style="<?php echo $TABLE_RESET_CSS ?> width: 100%;">
				<tr style="position: sticky; top: 0; <?php echo $TR_HEAD_CSS ?>">
					<th style="<?php echo $TH_CSS ?>">Time id</th>
					<th style="<?php echo $TH_CSS ?> width: 100px;">Time (ms)</th>
				</tr>
				<?php echo $TIMES ?>
			</table>
		</div>
		<?php endif ?>
	</div>
</div>
<script type="text/javascript">
	var sy_debug = {

		_prefix: 'sy_debug_',

		_suffix: '_<?php echo \crc32('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])) ?>',

		_localCache: {},

		get: function(id) {
			if (this._localCache[this._prefix + id] === undefined) {
				this._localCache[this._prefix + id] = document.getElementById(this._prefix + id);
			}
			return this._localCache[this._prefix + id];
		},

		start_resize: function(e) {
			document.addEventListener('mousemove', sy_debug.resize);
			document.addEventListener('mouseup', sy_debug.end_resize);
			document.getElementById('#sy_debug_console_content_iframe').style.pointerEvents = 'none';
		},

		resize: function(e) {
			var posy = 0;
			if (!e) {
				var e = window.event;
			}
			posy = e.clientY;
			if (posy <= 0) {
				return;
			}
			var  h = document.documentElement.clientHeight;
			var new_height = h - posy - 34;
			sy_debug.get('console_content').style.height = new_height + 'px';
			sy_debug.get('console').style.height         = new_height + 'px';
		},

		end_resize: function(e) {
			document.removeEventListener('mousemove', sy_debug.resize);
			document.removeEventListener('mouseup', sy_debug.end_resize);
			document.getElementById('#sy_debug_console_content_iframe').style.pointerEvents = 'auto';
			sy_debug.set_last_height(sy_debug.get('console').style.height);
		},

		log_filter: function(element, color) {
			var checked = (element.className === 'sy_debug_filter_checked');
			var div     = this.get('log_content');
			var rows    = div.getElementsByTagName('tr');
			var display = checked ? 'none' : 'table-row';
			if (checked) {
				element.style.backgroundColor = '#CCC';
				element.style.borderColor     = '#DDD';
				element.className             = 'sy_debug_filter_unchecked';
			} else {
				element.style.backgroundColor = '#ABC8E2';
				element.style.borderColor     = '#375D81';
				element.className             = 'sy_debug_filter_checked';
			}
			for (var i = 0, length = rows.length; i < length; ++i) {
				if (rows[i].className === 'sy_debug_log_row_' + color) {
					rows[i].style.display = display;
				}
			}
		},

		show_console: function() {
			this.get('resize_bar').style.display         = 'block';
			this.get('resize_bar_wrapper').style.display = 'block';
			this.get('console_content').style.display    = 'block';
			this.get('console').style.display            = 'block';
			this.get('close_button').style.display       = 'block';
		},

		hide_bar: function() {
			this.hide_console();
			this.get('bar').style.display         = 'none';
		},

		hide_console: function() {
			this.hide_all_content();
			this.get('resize_bar').style.display         = 'none';
			this.get('resize_bar_wrapper').style.display = 'none';
			this.get('console_content').style.display    = 'none';
			this.get('console').style.display            = 'none';
			this.get('close_button').style.display       = 'none';
			this.clear_state();
		},

		hide_all_content: function() {
			<?php if ($PHP_INFO): ?>
			this.get('php_content_title').style.color = '#555';
			this.get('php_content').style.display     = 'none';
			<?php endif ?>
			<?php if ($WEB_LOGGER): ?>
			this.get('log_content_title').style.color = '#555';
			this.get('log_content').style.display     = 'none';
			<?php endif ?>
			<?php if ($FILE_LOGGER): ?>
			this.get('file_content_title').style.color = '#555';
			this.get('file_content').style.display     = 'none';
			<?php endif ?>
			<?php if ($QUERY_LOGGER): ?>
			this.get('query_content_title').style.color = '#555';
			this.get('query_content').style.display     = 'none';
			<?php endif ?>
			<?php if ($TIME_RECORD): ?>
			this.get('time_content_title').style.color = '#555';
			this.get('time_content').style.display     = 'none';
			<?php endif ?>
			this.get('var_content_title').style.color = '#555';
			this.get('var_content').style.display     = 'none';
		},

		show_content: function(type) {
			if (type !== null) {
				this.hide_all_content();
				this.get(type + '_content').style.display     = 'block';
				this.get(type + '_content_title').style.color = 'black';
				this.show_console();
				this.set_last_content(type);
			}
		},

		check_local_storage: function() {
			try {
				return 'localStorage' in window && window['localStorage'] !== null;
			}
			catch (e) {
				return false;
			}
		},

		clear_state: function() {
			if (this.check_local_storage()) {
				localStorage.removeItem(this._prefix + 'last_content' + this._suffix);
			}
		},

		restore_last_state: function() {
			this.show_content(this.get_last_content());
			this.get('console_content').style.height = this.get_last_height();
			this.get('console').style.height         = this.get_last_height();
		},

		set_last_content: function(type) {
			if (this.check_local_storage()) {
				localStorage.setItem(this._prefix + 'last_content' + this._suffix, type);
			}
		},

		get_last_content: function() {
			if (this.check_local_storage()) {
				return localStorage.getItem(this._prefix + 'last_content' + this._suffix);
			}
		},

		set_last_height: function(height) {
			if (this.check_local_storage()) {
				localStorage.setItem(this._prefix + 'last_height' + this._suffix, height);
			}
		},

		get_last_height: function() {
			if (this.check_local_storage()) {
				return localStorage.getItem(this._prefix + 'last_height' + this._suffix);
			}
		}
	};

	(function() {
		if (sy_debug.check_local_storage() && localStorage.getItem(sy_debug._prefix + 'last_height' + sy_debug._suffix) === null) {
			sy_debug.set_last_height(sy_debug.get('console').style.height);
		}

		sy_debug.restore_last_state();

		sy_debug.get('resize_bar').onmousedown = sy_debug.start_resize;
	})();
</script>
