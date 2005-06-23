<?php
	/**************************************************************************\
	* eGroupWare                                                               *
	* http://www.egroupware.org                                                *
	* --------------------------------------------                             *
	*  This program is free software; you can redistribute it and/or modify it *
	*  under the terms of the GNU General Public License as published by the   *
	*  Free Software Foundation; either version 2 of the License, or (at your  *
	*  option) any later version.                                              *
	\**************************************************************************/
	
	
	/*
	* parse_navbar
	*
	* Make the navbar or make the launchmenu when x-desktop is not yet loaded
	*
	* @param force default false
	*/
	
	function parse_navbar($force = False)
	{
	
		$GLOBALS['idots2_tpl'] = createobject('phpgwapi.Template',PHPGW_TEMPLATE_DIR);
		$GLOBALS['idots2_tpl']->set_file(
			array(
				'navbar' => 'navbar.tpl'
			)
		);
		
		$GLOBALS['idots2_tpl']->set_block('navbar','xdesktop_header','xdesktop_header');
		$GLOBALS['idots2_tpl']->set_block('navbar','background','background');
		$GLOBALS['idots2_tpl']->set_block('navbar','background_stretched','background_stretched');
		$GLOBALS['idots2_tpl']->set_block('navbar','background_none','background_none'); 
		$GLOBALS['idots2_tpl']->set_block('navbar','logo','logo');
		
		$GLOBALS['idots2_tpl']->set_block('navbar','navbar_header_begin','navbar_header_begin');
		$GLOBALS['idots2_tpl']->set_block('navbar','launch_app','launch_app');
		$GLOBALS['idots2_tpl']->set_block('navbar','logout','logout');
		$GLOBALS['idots2_tpl']->set_block('navbar','navbar_header_end','navbar_header_end');
		
		$GLOBALS['idots2_tpl']->set_block('navbar','show_clock','show_clock');
		$GLOBALS['idots2_tpl']->set_block('navbar','no_clock','no_clock');
		
		$GLOBALS['idots2_tpl']->set_block('navbar','navbar_header','navbar_header');
		$GLOBALS['idots2_tpl']->set_block('navbar','extra_blocks_header','extra_block_header');
		$GLOBALS['idots2_tpl']->set_block('navbar','extra_block_row','extra_block_row');
		$GLOBALS['idots2_tpl']->set_block('navbar','extra_block_row_raw','extra_block_row_raw');
		$GLOBALS['idots2_tpl']->set_block('navbar','extra_block_row_no_link','extra_block_row_no_link');
		$GLOBALS['idots2_tpl']->set_block('navbar','extra_block_spacer','extra_block_spacer');
		$GLOBALS['idots2_tpl']->set_block('navbar','extra_blocks_footer','extra_blocks_footer');
		
		$GLOBALS['idots2_tpl']->set_block('navbar','begin_toolbar','begin_toolbar');
		$GLOBALS['idots2_tpl']->set_block('navbar','end_toolbar','end_toolbar');
		$GLOBALS['idots2_tpl']->set_block('navbar','toolbar_item','toolbar_item');
		$GLOBALS['idots2_tpl']->set_block('navbar','toolbar_seperator','toolbar_seperator');
	
	
		$GLOBALS['idots2_tpl']->set_block('navbar','appbox','appbox');
		$GLOBALS['idots2_tpl']->set_block('navbar','end_appbox','end_appbox');
		$GLOBALS['idots2_tpl']->set_block('navbar','navbar_footer','navbar_footer');
		
		
		$template_dir = $GLOBALS['phpgw_info']['server']['webserver_url'] . "/phpgwapi/templates/" . $GLOBALS['phpgw_info']['server']['template_set'];
		
		$var['template_dir'] = $template_dir;
		
		if($GLOBALS['phpgw_info']['flags']['currentapp']=='eGroupWare') {
			// If this is the initial page load x-desktop 
			
			// Should we display a clock or not
			if(empty($GLOBALS['phpgw_info']['user']['preferences']['common']['clock_show']) || $GLOBALS['phpgw_info']['user']['preferences']['common']['clock_show'] == 'yes')
			{
				$var['clock_show'] = "yes";
				
				// How should the clock be displayed
				if(empty($GLOBALS['phpgw_info']['user']['preferences']['common']['clock_min']))
				{
						$var['clock']='second';
				}
				else
				{
					$var['clock']=$GLOBALS['phpgw_info']['user']['preferences']['common']['clock_min'];
				}	
				
				
			}
			else
			{
				$var['clock_show'] = $GLOBALS['phpgw_info']['user']['preferences']['common']['clock_show'];
			}
			
				
			// Location of the x-desktop skin										
			$iconpath = $template_dir."/js/x-desktop/xDT/skins/IDOTS2";
			$var['iconpath'] = $iconpath;
			
			
			$var['serverpath'] = $GLOBALS['phpgw_info']['server']['webserver_url'];
				
			
			// If there is an update display it 
			if(isset($_GET['hasupdates']) && $_GET['hasupdates'] == "yes") {
				$var['default_app'] = 'home';
				$var['default_title'] = addslashes(lang('Home'));
			} 
			else {
				
				if(isset($GLOBALS['phpgw_info']['user']['preferences']['common']['default_app']))
				{
					// Display the default application
					$var['default_app'] = $GLOBALS['phpgw_info']['user']['preferences']['common']['default_app'];
					$var['default_title'] = addslashes($GLOBALS['phpgw_info']['user']['apps'][$var['default_app']]['title']);
				}
			}
							
			$var["dIcons"] = "";
			$var["urlpref"] = $GLOBALS['phpgw_info']['navbar']['preferences']['url'];
			$first = true;
			$first2 = true;
			if($GLOBALS['phpgw_info']['user']['preferences']['phpgwapi'])
			{
				foreach($GLOBALS['phpgw_info']['user']['preferences']['phpgwapi'] as $shortcut => $shortcut_data)
				{
					if(strpos($shortcut, "size_") === false) {	
						if($first)
						{
							$var["appTitles"] = $GLOBALS['phpgw_info']['user']['apps'][$shortcut_data['title']]['title'];
						
							$var["appImgs"] = $shortcut_data['icon'];
							$var["appUrls"] = $shortcut_data['link'];
							$var["appTop"] = $shortcut_data['top'];
							$var["appLeft"] = $shortcut_data['left'];
							$var["appType"] = $shortcut_data['type'];
							$var["appName"] = $shortcut_data['title'];
							$first= false;
						}
						else
						{
							
							$var["appTitles"] .=','. $GLOBALS['phpgw_info']['user']['apps'][$shortcut_data['title']]['title'];
							$var["appImgs"] .=','. $shortcut_data['icon'];
							$var["appUrls"] .=','. $shortcut_data['link'];
							$var["appTop"] .=','. $shortcut_data['top'];
							$var["appLeft"] .=','. $shortcut_data['left'];
							$var["appType"] .=','. $shortcut_data['type'];
							$var["appName"] .=','. $shortcut_data['title'];
	
						}
					}
					else {
						if($first2)
						{
							$var["sizeTitles"] = $GLOBALS['phpgw_info']['user']['apps'][$shortcut_data['name']]['title'];
							$var["sizeWidth"] = $shortcut_data['width'];
							$var["sizeHeight"] = $shortcut_data['height'];
							$first2= false;
						}
						else
						{
							$var["sizeTitles"] .=','. $GLOBALS['phpgw_info']['user']['apps'][$shortcut_data['name']]['title'];
							$var["sizeWidth"] .=','. $shortcut_data['width'];
							$var["sizeHeight"] .=','. $shortcut_data['height'];
	
						}
					
					}
			 	}
			}
			 
			$var["back_shortcut"] = $GLOBALS['phpgw_info']['user']['preferences']['common']['back_icons'];

			if(!empty($GLOBALS['phpgw_info']['user']['preferences']['common']['bgcolor_icons']))
			{
			   $var["color_shortcut"] = $GLOBALS['phpgw_info']['user']['preferences']['common']['bgcolor_icons'];
			}
			else
			{
				$var["color_shortcut"] = '#FFF';
			}
			
			if(!empty($GLOBALS['phpgw_info']['user']['preferences']['common']['textcolor_icons']))
			{
			   $var["color_text_sc"] = $GLOBALS['phpgw_info']['user']['preferences']['common']['textcolor_icons'];
			}
			else
			{
				$var["color_text_sc"] = '#000';
			}

			
			$var["appTitles"] = addslashes($var["appTitles"]);
			$var["strXmlUrl"] = "phpgwapi/templates/" . $GLOBALS['phpgw_info']['server']['template_set'];

			if(empty($GLOBALS['phpgw_info']['user']['preferences']['common']['scrWidth']))
			{
				$var["scrWidth"] = "600"; 
			}
			else
			{
				$var["scrWidth"] = $GLOBALS['phpgw_info']['user']['preferences']['common']['scrWidth'];  
			}
	
			if(empty($GLOBALS['phpgw_info']['user']['preferences']['common']['scrHeight']))
			{
				$var["scrHeight"] = "400";
			}
			else
			{
				$var["scrHeight"] = $GLOBALS['phpgw_info']['user']['preferences']['common']['scrHeight'];
			}
			$var['titleAdd'] = lang('Add Shortcut');
			$var['titleRem'] = lang('Remove Shortcut');
			$var['titlePref'] = $GLOBALS['phpgw_info']['navbar']['preferences']['title'];
			$var['titleAbout'] = lang('About');
			$var['programs'] = lang('Programs');
			$var['calendarTitle'] = $GLOBALS['phpgw_info']['navbar']['calendar']['title'];
//			print_r($GLOBALS['phpgw_info']['navbar']);
			$GLOBALS['idots2_tpl']->set_var($var);
			$GLOBALS['idots2_tpl']->pfp('out','xdesktop_header');
	
			
			if (empty($GLOBALS['phpgw_info']['user']['preferences']['common']['files']))
			{
				$var["backgroundimage"] = $template_dir.'/images/backgrounds/achtergrond.png';
			}
			else
			{
				$var["backgroundimage"] = $template_dir.'/images/backgrounds/' . $GLOBALS['phpgw_info']['user']['preferences']['common']['files'];
			}
			
			if (empty($GLOBALS['phpgw_info']['user']['preferences']['common']['bckStyle']))
			{
				$var["backgroundstyle"] = "stretched";
			}
			else
			{
				$var["backgroundstyle"] = $GLOBALS['phpgw_info']['user']['preferences']['common']['bckStyle'];
			}
			
			if(empty($GLOBALS['phpgw_info']['user']['preferences']['common']['bgcolor']))
			{
				$var["backgroundcolor"] = '#FFFFFF';
			}
			else
			{
				$var["backgroundcolor"] = $GLOBALS['phpgw_info']['user']['preferences']['common']['bgcolor'];
			}
			
			$GLOBALS['idots2_tpl']->set_var($var);
			
			if( $GLOBALS['phpgw_info']['user']['preferences']['common']['files'] ==  'none')
			{
			    $GLOBALS['idots2_tpl']->pfp('out','background_none');
			}
			else
			{
				if($var["backgroundstyle"] == "stretched") 
				{
					$GLOBALS['idots2_tpl']->pfp('out','background_stretched');
				}
				else 
				{
					$GLOBALS['idots2_tpl']->pfp('out','background');
				}
			}
			if (empty($GLOBALS['phpgw_info']['user']['preferences']['common']['showLogo']) || $GLOBALS['phpgw_info']['user']['preferences']['common']['showLogo'] == 'yes')
			{
				$GLOBALS['idots2_tpl']->pfp('out','logo');
			}
			
			if(empty($GLOBALS['phpgw_info']['user']['preferences']['common']['clock_show']) || $GLOBALS['phpgw_info']['user']['preferences']['common']['clock_show'] == 'yes')
			{
				$GLOBALS['idots2_tpl']->pfp('out','show_clock');
			}
			else
			{
				$GLOBALS['idots2_tpl']->pfp('out','no_clock');
			}
			
			
			$var['img_root'] = $$template_dir.'/images';
			$var['table_bg_color'] = $GLOBALS['phpgw_info']['theme']['navbar_bg'];
			

	
			$GLOBALS['idots2_tpl']->pfp('out','navbar_header_begin');
	
			//print_r($GLOBALS['phpgw_info']['navbar']);
			foreach($GLOBALS['phpgw_info']['navbar'] as $app => $app_data)
			{
				if($app != 'about') 
				{
					$var['title'] = $app_data['title'];
					$var['icon'] = $app_data['icon'];
					$var['url'] = $app_data['url'];
					$GLOBALS['idots2_tpl']->set_var($var);
					if($app != 'logout')
					{
						$GLOBALS['idots2_tpl']->pfp('out','launch_app');
					}
					else 
					{
						$GLOBALS['idots2_tpl']->pfp('out','logout');
					}
				}
			}
				
			
			$GLOBALS['idots2_tpl']->pfp('out','navbar_header_end');
	
			/******************************************************\
			* The menu's                                           *
			\******************************************************/
		}
		else {
			// Show the menu
			$menu_title = lang('Help');
			$file = array(
				array(
					'text'    => lang('About %1',$GLOBALS['phpgw_info']['apps'][$GLOBALS['phpgw_info']['flags']['currentapp']]['title']),
					'no_lang' => True,
					'link'    => $GLOBALS['phpgw_info']['navbar']['about']['url']
				)
			);
	
			$var['menu_link'] = '';
			$var['sideboxcolstart'] = '';
			$var['remove_padding'] = '';
			
			$GLOBALS['idots2_tpl']->set_var($var);
			$GLOBALS['idots2_tpl']->pparse('out','appbox');
	
			
			
			$var['sideboxcolend'] = '';
			
			$GLOBALS['idots2_tpl']->set_var($var);
			$menu_new = $GLOBALS['phpgw']->hooks->single('menu',$GLOBALS['phpgw_info']['flags']['currentapp']);
			if(is_array($menu_new)) 
			{
				foreach($menu_new as $menu_title =>$menu)
				{
					display_sidebox('',$menu_title,$menu);
				}
			}
			else
			{
				$GLOBALS['phpgw']->hooks->single('sidebox_menu',$GLOBALS['phpgw_info']['flags']['currentapp']);
				display_sidebox('',$menu_title,$file);
			}
			
			$GLOBALS['idots2_tpl']->pparse('out','end_appbox');
			
			//Is there a toolbar hooked in this application
			$toolbar = $GLOBALS['phpgw']->hooks->single('toolbar',$GLOBALS['phpgw_info']['flags']['currentapp']);
			if(is_array($toolbar) && count($toolbar) > 0) {
				display_toolbar($toolbar);
			}
			
			$GLOBALS['idots2_tpl']->pparse('out','navbar_footer');
	
			
			
			// If the application has a header include, we now include it
			if(!@$GLOBALS['phpgw_info']['flags']['noappheader'] && @isset($_GET['menuaction']))
			{
				list($app,$class,$method) = explode('.',$_GET['menuaction']);
				if(is_array($GLOBALS[$class]->public_functions) && $GLOBALS[$class]->public_functions['header'])
				{
					$GLOBALS[$class]->header();
				}
			}
			
			
		}
		return;
	}
	
	
	/*
	* display_toolbar
	* 
	* The toolbar
	* 
	*/
	function display_toolbar($toolbar) {
		$GLOBALS['idots2_tpl']->pparse('out','begin_toolbar');
		$app = $GLOBALS['phpgw_info']['flags']['currentapp'];
		foreach($toolbar as $item) {
			if(is_array($item)) {
				$item['image'] = $GLOBALS['phpgw']->common->image($app,$item['image']); 
				$GLOBALS['idots2_tpl']->set_var($item);
				$GLOBALS['idots2_tpl']->pfp('out','toolbar_item');
			}
			else {
				$GLOBALS['idots2_tpl']->pparse('out','toolbar_seperator');
			}
		}
		$GLOBALS['idots2_tpl']->pparse('out','end_toolbar');	
	}
	
	function display_sidebox($appname,$menu_title,$file)
	{
		if(!$appname || ($appname==$GLOBALS['phpgw_info']['flags']['currentapp'] && $file))
		{
			$var['lang_title']=$menu_title;//$appname.' '.lang('Menu');
			$GLOBALS['idots2_tpl']->set_var($var);
			$GLOBALS['idots2_tpl']->pfp('out','extra_blocks_header');
	
			foreach($file as $text => $url)
			{
				sidebox_menu_item($url,$text);
			}
	
			$GLOBALS['idots2_tpl']->pparse('out','extra_blocks_footer');
		}
	}
	function sidebox_menu_item($item_link='',$item_text='')
	{
		if($item_text === '_NewLine_' || $item_link === '_NewLine_')
		{
			$GLOBALS['idots2_tpl']->pparse('out','extra_block_spacer');
		}
		else
		{
			$var['icon_or_star']='<img src="'.$GLOBALS['phpgw_info']['server']['webserver_url'] . '/phpgwapi/templates/idots/images'.'/orange-ball.png" width="9" height="9" alt="ball"/>';
			$var['target'] = '';
			if(is_array($item_link))
			{
				if(isset($item_link['icon']))
				{
					$app = isset($item_link['app']) ? $item_link['app'] : $GLOBALS['phpgw_info']['flags']['currentapp'];
					$var['icon_or_star'] = $item_link['icon'] ? '<img style="margin:0px 2px 0px 2px" src="'.$GLOBALS['phpgw']->common->image($app,$item_link['icon']).'"/>' : False;
				}
				$var['lang_item'] = isset($item_link['no_lang']) && $item_link['no_lang'] ? $item_link['text'] : lang($item_link['text']);
				$var['item_link'] = $item_link['link'];
				if ($item_link['target'])
				{
					$var['target'] = ' target="' . $item_link['target'] . '"';
				}
			}
			else
			{
				$var['lang_item'] = lang($item_text);
				$var['item_link'] = $item_link;
			}
			$GLOBALS['idots2_tpl']->set_var($var);
	
			$block = 'extra_block_row';
			if ($var['item_link'] === False)
			{
				$block .= $var['icon_or_star'] === False ? '_raw' : '_no_link';
			}
			$GLOBALS['idots2_tpl']->pparse('out',$block);
		}
	}
	
	function parse_navbar_end()
	{
		$GLOBALS['idots2_tpl'] = createobject('phpgwapi.Template',PHPGW_TEMPLATE_DIR);
	
		$GLOBALS['idots2_tpl']->set_file(
			array(
				'footer' => 'footer.tpl'
			)
		);
		$var = Array(
			'img_root'       => $GLOBALS['phpgw_info']['server']['webserver_url'] . '/phpgwapi/templates/idots/images',
			'table_bg_color' => $GLOBALS['phpgw_info']['theme']['navbar_bg'],
			'version'        => $GLOBALS['phpgw_info']['server']['versions']['phpgwapi']
		);
		$GLOBALS['phpgw']->hooks->process('navbar_end');
	
		if($GLOBALS['phpgw_info']['user']['preferences']['common']['show_generation_time'])
		{
			$mtime = microtime(); 
			$mtime = explode(' ',$mtime); 
			$mtime = $mtime[1] + $mtime[0]; 
			$tend = $mtime; 
			$totaltime = ($tend - $GLOBALS['page_start_time']); 
	
			$var['page_generation_time'] = '<div id="divGenTime"><br/><span>'.lang('Page was generated in %1 seconds',$totaltime).'</span></div>';
		}
	
		$var['powered_by'] = lang('Powered by phpGroupWare version %1',$GLOBALS['phpgw_info']['server']['versions']['phpgwapi']);
		$var['activate_tooltips'] = '<script src="'.$GLOBALS['phpgw_info']['server']['webserver_url'].'/phpgwapi/js/wz_tooltip/wz_tooltip.js" type="text/javascript"></script>';
		$GLOBALS['idots2_tpl']->set_var($var);
		$GLOBALS['idots2_tpl']->pfp('out','footer');
	}
