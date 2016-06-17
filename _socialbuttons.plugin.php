<?php
/**
 * This file implements the Social Buttons plugin for {@link http://b2evolution.net/}.
 *
 * @copyright (c)2010 by Emin Özlem - {@link http://eodepo.com/}.
 *
 * @license GNU General Public License 2 (GPL) - http://www.opensource.org/licenses/gpl-license.php
 *
 * @package plugins
 *
 * @author Emin Özlem
 *
 * @version $Id:  $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
Social Buttons Plugin *
 *'Allows you to add social buttons quickly';
 *
 */
class socialbuttons_plugin extends Plugin
{
	var $author = 'Emin Özlem';
	var $code = 'socialbuttons';
	var $apply_rendering = 'stealth';
	var $group = 'eodepo';
	var $help_url = 'http://www.eodepo.com';
	var $name = 'Social Buttons';
	var $long_desc = 'Allows you to add social buttons quickly and easily configurable';
	var $short_desc = 'Social Buttons';
	var $number_of_installs = 1;
	var $priority = 60;
	var $version = '1.0';
	var $extra_info = 'test?';

	function PluginInit( & $params )
	{
		$this->name = $this->T_('Social Buttons');
		$this->short_desc = $this->T_('Add Social buttons.');
		$this->long_desc = $this->T_('Allows you to add social buttons quickly and easily configurable');
	}

	function GetDefaultSettings( & $params )
	{
		$DefSet = array(

			'fblb_ba' => array(
				'label' => T_('Before / After content ?'),
				'note' => 'Would you like to display Sharing buttons before / after the content ?',
				'defaultvalue' => 'before',
				'options' => array( 'before' => $this->T_('before'), 'after' => $this->T_('after'), ),
				'type' => 'select',
			),
			'fblb_use' => array(
				'label' => 'Display Facebook Like ?',
				'defaultvalue' => '1',
				'type' => 'checkbox',
			),
			'gplus_use' => array(
				'label' => 'Display Google +1 plus one ?',
				'defaultvalue' => '1',
				'type' => 'checkbox',
			),
			'twbutton_use' => array(
				'label' => 'Display Tweet Button ?',
				'defaultvalue' => '1',
				'type' => 'checkbox',
			),
			'cached_realtime' => array(
				'label' => T_('Cached / Real time'),
				'note' => 'Would you like to display the button counts cached / real time (Cached = better performance, delayed results).Default is realtime.',
				'defaultvalue' => 'realtime',
				'options' => array( 'cached' => $this->T_('Cached'), 'realtime' => $this->T_('Real Time'),  ),
				'type' => 'select',
			),
			'force_box_float' => array(
				'label' => 'Force Floated Boxes',
				'defaultvalue' => '0',
				'type' => 'checkbox',
				'note' => 'Forces the buttons to be displayed side by side by floating with a fixed width of 65px.',

			),
			'fblike_options_begin' => array(
				'layout' => 'begin_fieldset',
				'label' => $this->T_('Facebook Like Button Options <a href="http://developers.facebook.com/docs/reference/plugins/like/">FB Like Button Documentation</a>'),
			),
			'fblb_layout' => array(
				'label' => T_('Layout Style'),
				'id' => $this->classname.'_fblb_layout',
				'note' => 'determines the size and amount of social context next to the button.default is box_count.<a href="http://developers.facebook.com/docs/reference/plugins/like/">FB Like Button Documentation</a>',
				'defaultvalue' => 'box_count',
				'options' => array( 'standard' => $this->T_('standard'), 'button_count' => $this->T_('button_count'), 'box_count' => $this->T_('box_count'), ),
				'onchange' => 'document.getElementById("'.$this->classname.'_fblb_showfaces").disabled = ( this.value != "standard" );',
				'type' => 'select',
			),
			'fblb_width' => array(
				'label' => 'Width',
				'defaultvalue' => '450',
				'note' => 'the width of the plugin in pixels valid range: 1-999, default is : 450. <a href="http://developers.facebook.com/docs/reference/plugins/like/">FB Like Button Documentation</a>',
				'valid_range' => array( 'min'=>1, 'max'=>9999 ),
			),

			'fblb_height' => array(
				'label' => 'Height',
				'defaultvalue' => '85',
				'note' => 'the height of the plugin in pixels.Recommended values; standart: 35, button_count: 23, box_count:90  valid range: 1-99, default is : 85',
				'valid_range' => array( 'min'=>1, 'max'=>99 ),
			),

			'fblb_showfaces' => array(
				'id' => $this->classname.'_fblb_showfaces',
				'label' => T_('Show Faces?'),
				'note' => T_('Show profile pictures below the button.Only effective if "standard" layout is selected.Disabled by default'),
				'disabled' => true,
				'defaultvalue' => 'false',
				'options' => array( 'true' => $this->T_('Yes'), 'false' => $this->T_('No'), ),
				'type' => 'select',
			),
			'fblb_verb' => array(
				'label' => T_('Verb to display'),
				'note' => 'The verb to display in the button. Currently only "like" and "recommend" are supported.Default is like.',
				'defaultvalue' => 'like',
				'options' => array( 'like' => $this->T_('like'), 'recommend' => $this->T_('recommend'), ),
				'type' => 'select',
			),
			'fblb_color_scheme' => array(
				'label' => T_('Color Scheme'),
				'note' => 'The Color Scheme of the plugin.',
				'defaultvalue' => 'like',
				'options' => array( 'light' => $this->T_('light'), 'dark' => $this->T_('dark'), ),
				'type' => 'select',
			),
			'fblb_font' => array(
				'label' => T_('Font'),
				'note' => 'the font of the plugin.Default is arial.',
				'defaultvalue' => 'arial',
				'options' => array( 'arial' => $this->T_('Arial'), 'lucida+grande' => $this->T_('Lucida Grande'), 'segoe+ui' => $this->T_('Segoe UI'), 'tahoma' => $this->T_('Tahoma'), 'trebuchet+ms' => $this->T_('Trebuchet Ms'), 'verdana' => $this->T_('Verdana'), ),
				'type' => 'select',
			),

			'fblb_ac' => array(
				'label' => T_('Css Class'),
				'note' => 'Css class to customize the button -position possibly-',
				'defaultvalue' => 'fbiframediv sharebuttton',
			),
			'fblike_options_end' => array(
				'layout' => 'end_fieldset',
			),
			'gplus_one_options_begin' => array(
				'layout' => 'begin_fieldset',
				'label' => $this->T_('Google +1 -Plus One- Options <a href="http://www.google.com/webmasters/+1/button/">+1 button Documentation</a>'),
			),
			'gplus_size' => array(
				'label' => T_('+1 Button Size'),
				'note' => 'Button size, default is tall.',
				'defaultvalue' => 'tall',
				'options' => array( 'small' => $this->T_('Small'), 'medium' => $this->T_('Medium'), 'standard' => $this->T_('Standard'), 'tall' => $this->T_('Tall'), ),
				'type' => 'select',
			),
			'gplus_lang' => array(
				'label' => T_('+1 Button Language'),
				'note' => 'default is English-US.',
				'defaultvalue' => 'enUS',
				'options' => array( 'ar' => $this->T_('Arabic'), 'en-GB' => $this->T_('English (UK)'), 'enUS' => $this->T_('English (US)'), 'fr' => $this->T_('French'), 'de' => $this->T_('German'), 'ru' => $this->T_('Russian'), 'es' => $this->T_('Spanish'), 'tr' => $this->T_('Turkish'), ),
				'type' => 'select',
			),
			'gplus_count' => array(
				'label' => 'Include count ?',
				'defaultvalue' => '1',
				'type' => 'checkbox',
			),
			'gplus_what' => array(
				'label' => '+1 What ?',
				'id' => $this->classname.'_gplus_what',
				'onchange' => 'document.getElementById("'.$this->classname.'_gplus_url_custom").disabled = ( this.value == "currpage" );',
				'defaultvalue' => 'default',
				'type' => 'select',
				'options' => array( 'default' => 'The Post/Page', 'custom' => 'Custom URL' ),
				'note' => '+1 the post/page or use an enforced url to +1.',
			),
			'gplus_parse' => array(
				'label' => 'Parse ?',
				'defaultvalue' => 'default',
				'type' => 'select',
				'options' => array( 'default' => 'Default (On Load)', 'explicit' => 'Explicit' ),
				'note' => 'Do NOT change this if you dont know what you are doing.',
			),
			'gplus_url_custom' => array(
				'label' => 'URL to like',
				'id' => $this->classname.'_gplus_url_custom',
				//'size' => '105',
				//		'disabled' => true, // this can be useful if you detect that something cannot be changed. You probably want to add a 'note' then, too.
				'note' => 'Change the +1 What to custom to activate.',
			),
			'gplus_ac' => array(
				'label' => T_('Css Class'),
				'note' => 'Css class to customize the button -position possibly-',
				'defaultvalue' => 'gplusdiv sharebuttton',
			),


			'gplus_one_options_end' => array(
				'layout' => 'end_fieldset',
			),
			'twbutton_options_begin' => array(
				'layout' => 'begin_fieldset',
				'label' => $this->T_('Tweet Button Options <a href="http://www.twitter.com/about/resources/tweetbutton">Tweet button Documentation</a>'),
			),
			'twbutton_size' => array(
				'label' => T_('Tweet Button type'),
				'note' => 'Button type, default is Vertical count.',
				'defaultvalue' => 'vertical',
				'options' => array( 'vertical' => $this->T_('vertical count'), 'horizontal' => $this->T_('horizontal count'), 'none' => $this->T_('No Count'), ),
				'type' => 'select',
			),
			'twbutton_text' => array(
				'label' => 'Tweet text',
				'defaultvalue' => 'default',
				'type' => 'select',
				'options' => array( 'default' => 'Title of the post/page', 'custom' => 'Custom Text' ),
				'note' => 'This is the text that people will include in their Tweet when they share from your website:.',
			),
			'twbutton_custom_text' => array(
				'label' => 'Custom text',
				'note' => 'Custom text',
			),
			'twbutton_url' => array(
				'label' => 'Tweet text',
				'defaultvalue' => 'default',
				'type' => 'select',
				'options' => array( 'default' => 'Url of the post/page', 'custom' => 'Custom URL' ),
				'note' => 'The URL of the post/page or forced url.',
			),
			'twbutton_custom_url' => array(
				'label' => 'Custom URL',
				'note' => 'Enter forced url',
			),
			'twbutton_recommend1' => array(
				'label' => 'Recommend People to follow (1)',
				'note' => ' This user will be @ mentioned in the suggested Tweet.Recommend up to two Twitter accounts for users to follow after they share content from your website. These accounts could include your own, or that of a contributor or a partner.',

			),
			'twbutton_recommend2' => array(
				'label' => 'Secondary Related Account.Recommend People to follow (2)',
				'note' => 'Recommend up to two Twitter accounts for users to follow after they share content from your website. These accounts could include your own, or that of a contributor or a partner.',

			),
			'twbutton_recommend2_desc' => array(
				'label' => 'Recommend People to follow (2)',
				'note' => 'Secondary recommended people description',

			),
			'twbutton_lang' => array(
				'label' => T_('Tweet Button Language'),
				'note' => 'default is English.',
				'defaultvalue' => 'en',
				'options' => array( 'en' => $this->T_('English'), 'fr' => $this->T_('French'), 'de' => $this->T_('German'), 'ru' => $this->T_('Russian'), 'es' => $this->T_('Spanish'), 'tr' => $this->T_('Turkish'), ),
				'type' => 'select',
			),
			'twbutton_ac' => array(
				'label' => T_('Css Class'),
				'note' => 'Css class to customize the button -position possibly-',
				'defaultvalue' => 'twbutton sharebuttton',
			),
			'twbutton_options_end' => array(
				'layout' => 'end_fieldset',
			),
		);


		if( $params['for_editing'] )
		{ // we're asked for the settings for editing:
			if( $this->Settings->get('fblb_layout') == 'standard' )
			{
				$r['fblb_showfaces']['disabled'] = false;
			}
			if( $this->Settings->get('gplus_what') == 'custom' )
			{
				$r['gplus_url_custom']['disabled'] = false;
			}
		}

		return $DefSet;

	}

	function BeforeEnable()
	{
		return true ;
	}

	function DisplayItemAsHtml( & $params )
	{
		if ($this->Settings->get( 'cached_realtime' ) == 'realtime' ) {

			global $baseurl;
			$fblb_layout = $this->Settings->get( 'fblb_layout' );
			$fblb_width = $this->Settings->get( 'fblb_width' );
			$fblb_showfaces = $this->Settings->get( 'fblb_showfaces' );
			$fblb_verb = $this->Settings->get( 'fblb_verb' );
			$fblb_color_scheme = $this->Settings->get( 'fblb_color_scheme' );
			$fblb_font = $this->Settings->get( 'fblb_font' );
			$fblb_height = $this->Settings->get( 'fblb_height' );
			$fblb_ba = $this->Settings->get( 'fblb_ba' );
			$fblb_ac = $this->Settings->get( 'fblb_ac' );
			$fblb_use = $this->Settings->get( 'fblb_use' );
			$PID = $params['Item']->ID;

			$gplus_size = $this->Settings->get( 'gplus_size' );
			$gplus_count = $this->Settings->get( 'gplus_count' );
			$gplus_what = $this->Settings->get( 'gplus_what' );
			$gplus_parse = $this->Settings->get( 'gplus_parse' );
			$gplus_url_custom = $this->Settings->get( 'gplus_url_custom' );
			$gplus_ac = $this->Settings->get( 'gplus_ac' );
			$gplus_use = $this->Settings->get( 'gplus_use' );


			$twbutton_custom_text = $this->Settings->get( 'twbutton_custom_text' );
			$twbutton_ac = $this->Settings->get( 'twbutton_ac' );
			$twbutton_custom_text = $this->Settings->get( 'twbutton_custom_text' );
			$twbutton_text = $this->Settings->get( 'twbutton_text' );
			$twbutton_url = $this->Settings->get( 'twbutton_url' );
			$twbutton_custom_url = $this->Settings->get( 'twbutton_custom_url' );
			$twbutton_size = $this->Settings->get( 'twbutton_size' );
			$twbutton_recommend1 = $this->Settings->get( 'twbutton_recommend1' );
			$twbutton_recommend2 = $this->Settings->get( 'twbutton_recommend2' );
			$twbutton_recommend2_desc = $this->Settings->get( 'twbutton_recommend2_desc' );
			$twbutton_lang = $this->Settings->get( 'twbutton_lang' );

			$PID = $params['Item']->ID;

			if($this->Settings->get( 'fblb_use' )) {
				$fblbutton = '<div class="'.$fblb_ac.'"><iframe src="http://www.facebook.com/plugins/like.php?app_id=194259500619894&amp;href='.$baseurl.'index.php?p='.$PID.'&amp;send=false';
				if($fblb_layout != 'standard')
				{
					$fblbutton .= '&amp;layout='.$fblb_layout;

				}
				$fblbutton .= '&amp;width='.$fblb_width.'&amp;show_faces='.$fblb_showfaces.'&amp;action='.$fblb_verb.'&amp;colorscheme='.$fblb_color_scheme.'&amp;font='.$fblb_font.'&amp;height='.$fblb_height.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$fblb_width.'px; height:'.$fblb_height.'px;" allowTransparency="true"></iframe></div>';
			}
			else { $fblbutton = ''; }


			if($this->Settings->get( 'gplus_use' )) {
				$gplusbutton = '<div class="'.$gplus_ac.'"><g:plusone';
				if($gplus_size != 'standard' )
				{
					$gplusbutton .= ' size="'.$gplus_size.'"';
				}

				if($gplus_what == 'default' )
				{
					$gplusbutton .= ' href="'.$baseurl.'index.php?p='.$PID.'"';
				}
				if($gplus_what == 'custom' && ! empty($gplus_url_custom) )
				{
					$gplusbutton .= ' href="'.$gplus_url_custom.'"';
				}
				if( $this->Settings->get( 'gplus_count' ) == 0 )		{
					$gplusbutton .= ' count="false"';
				}

				$gplusbutton .= '></g:plusone></div>';

			}
			else { $gplusbutton = ''; }

			if($this->Settings->get( 'twbutton_use' )) {

				$twbutton = '<div class="'.$twbutton_ac.'"><a href="http://twitter.com/share" class="twitter-share-button"';

				if($twbutton_url == 'default' )
				{
					$twbutton .= ' data-url="'.$baseurl.'index.php?p='.$PID.'"';
				}
				if($twbutton_url == 'custom' && ! empty($twbutton_custom_url) )
				{
					$twbutton .= ' data-url="'.$twbutton_custom_url.'"';
				}

				if($twbutton_text == 'custom' && ! empty($twbutton_custom_text) )
				{
					$twbutton .= ' data-text="'.$twbutton_custom_text.'"';
				}
				$twbutton .= ' data-count="'.$twbutton_size.'"';
				if(! empty($twbutton_recommend1) )
				{
					$twbutton .= ' data-via="'.$twbutton_recommend1.'"';
				}
				if(! empty($twbutton_recommend2 ) )
				{
					$twbutton .= ' data-related="'.$twbutton_recommend2.'';
					if (! empty($twbutton_recommend2_desc )) {
						$twbutton .= ':'.$twbutton_recommend2_desc.'"';}
					else {$twbutton .= '"';}

				}
				if($twbutton_lang != 'en')
				{
					$twbutton .= ' data-lang="'.$twbutton_lang.'"';
				}

				$twbutton .= '>Tweet</a></div>';

			}
			else { $twbutton = ''; }

			$contentt = & $params['data'];
			if($fblb_ba == 'before') { $contentt = '<div class="socialbutttons">'.$fblbutton.$twbutton.$gplusbutton.'</div>'.$contentt;	}
			if($fblb_ba == 'after') { $contentt = $contentt.'<div class="socialbutttons">'.$fblbutton.$twbutton.$gplusbutton.'</div>';	}
		} //mde
	}//end func

	function RenderItemAsHtml( & $params )
	{
		if ($this->Settings->get( 'cached_realtime' ) == 'cached' ) {

			global $baseurl;
			$fblb_layout = $this->Settings->get( 'fblb_layout' );
			$fblb_width = $this->Settings->get( 'fblb_width' );
			$fblb_showfaces = $this->Settings->get( 'fblb_showfaces' );
			$fblb_verb = $this->Settings->get( 'fblb_verb' );
			$fblb_color_scheme = $this->Settings->get( 'fblb_color_scheme' );
			$fblb_font = $this->Settings->get( 'fblb_font' );
			$fblb_height = $this->Settings->get( 'fblb_height' );
			$fblb_ba = $this->Settings->get( 'fblb_ba' );
			$fblb_ac = $this->Settings->get( 'fblb_ac' );
			$fblb_use = $this->Settings->get( 'fblb_use' );
			$PID = $params['Item']->ID;

			$gplus_size = $this->Settings->get( 'gplus_size' );
			$gplus_count = $this->Settings->get( 'gplus_count' );
			$gplus_what = $this->Settings->get( 'gplus_what' );
			$gplus_parse = $this->Settings->get( 'gplus_parse' );
			$gplus_url_custom = $this->Settings->get( 'gplus_url_custom' );
			$gplus_ac = $this->Settings->get( 'gplus_ac' );
			$gplus_use = $this->Settings->get( 'gplus_use' );


			$twbutton_custom_text = $this->Settings->get( 'twbutton_custom_text' );
			$twbutton_ac = $this->Settings->get( 'twbutton_ac' );
			$twbutton_custom_text = $this->Settings->get( 'twbutton_custom_text' );
			$twbutton_text = $this->Settings->get( 'twbutton_text' );
			$twbutton_url = $this->Settings->get( 'twbutton_url' );
			$twbutton_custom_url = $this->Settings->get( 'twbutton_custom_url' );
			$twbutton_size = $this->Settings->get( 'twbutton_size' );
			$twbutton_recommend1 = $this->Settings->get( 'twbutton_recommend1' );
			$twbutton_recommend2 = $this->Settings->get( 'twbutton_recommend2' );
			$twbutton_recommend2_desc = $this->Settings->get( 'twbutton_recommend2_desc' );
			$twbutton_lang = $this->Settings->get( 'twbutton_lang' );

			$PID = $params['Item']->ID;

			if($this->Settings->get( 'fblb_use' )) {
				$fblbutton = '<div class="'.$fblb_ac.'"><iframe src="http://www.facebook.com/plugins/like.php?app_id=194259500619894&amp;href='.$baseurl.'index.php?p='.$PID.'&amp;send=false';
				if($fblb_layout != 'standard')
				{
					$fblbutton .= '&amp;layout='.$fblb_layout;

				}
				$fblbutton .= '&amp;width='.$fblb_width.'&amp;show_faces='.$fblb_showfaces.'&amp;action='.$fblb_verb.'&amp;colorscheme='.$fblb_color_scheme.'&amp;font='.$fblb_font.'&amp;height='.$fblb_height.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$fblb_width.'px; height:'.$fblb_height.'px;" allowTransparency="true"></iframe></div>';
			}
			else { $fblbutton = ''; }

			if($this->Settings->get( 'gplus_use' )) {
				$gplusbutton = '<div class="'.$gplus_ac.'"><g:plusone';
				if($gplus_size != 'standard' )
				{
					$gplusbutton .= ' size="'.$gplus_size.'"';
				}

				if($gplus_what == 'default' )
				{
					$gplusbutton .= ' href="'.$baseurl.'index.php?p='.$PID.'"';
				}
				if($gplus_what == 'custom' && ! empty($gplus_url_custom) )
				{
					$gplusbutton .= ' href="'.$gplus_url_custom.'"';
				}
				if( $this->Settings->get( 'gplus_count' ) == 0 )		{
					$gplusbutton .= ' count="false"';
				}

				$gplusbutton .= '></g:plusone></div>';

			}
			else { $gplusbutton = ''; }

			if($this->Settings->get( 'twbutton_use' )) {

				$twbutton = '<div class="'.$twbutton_ac.'"><a href="http://twitter.com/share" class="twitter-share-button"';

				if($twbutton_url == 'default' )
				{
					$twbutton .= ' data-url="'.$baseurl.'index.php?p='.$PID.'"';
				}
				if($twbutton_url == 'custom' && ! empty($twbutton_custom_url) )
				{
					$twbutton .= ' data-url="'.$twbutton_custom_url.'"';
				}

				if($twbutton_text == 'custom' && ! empty($twbutton_custom_text) )
				{
					$twbutton .= ' data-text="'.$twbutton_custom_text.'"';
				}
				$twbutton .= ' data-count="'.$twbutton_size.'"';
				if(! empty($twbutton_recommend1) )
				{
					$twbutton .= ' data-via="'.$twbutton_recommend1.'"';
				}
				if(! empty($twbutton_recommend2 ) )
				{
					$twbutton .= ' data-related="'.$twbutton_recommend2.'';
					if (! empty($twbutton_recommend2_desc )) {
						$twbutton .= ':'.$twbutton_recommend2_desc.'"';}
					else {$twbutton .= '"';}

				}
				if($twbutton_lang != 'en')
				{
					$twbutton .= ' data-lang="'.$twbutton_lang.'"';
				}

				$twbutton .= '>Tweet</a></div>';

			}
			else { $twbutton = ''; }

			$contentt = & $params['data'];
			if($fblb_ba == 'before') { $contentt = '<div class="socialbutttons">'.$fblbutton.$twbutton.$gplusbutton.'</div>'.$contentt;	}
			if($fblb_ba == 'after') { $contentt = $contentt.'<div class="socialbutttons">'.$fblbutton.$twbutton.$gplusbutton.'</div>';	}

		} //mde
	}//end func

	function SkinEndHtmlBody( & $params )
	{
		if($this->Settings->get( 'gplus_use' )) {

			$gplus_lang = $this->Settings->get( 'gplus_lang' );
			echo '<script type="text/javascript" src="https://apis.google.com/js/plusone.js">';
			if($gplus_lang != 'enUS') {
				echo  '{lang: '.$gplus_lang.'}';}
			echo '</script>';
		}

		if($this->Settings->get( 'twbutton_use' )) {
			echo '<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
		}
	}

	function SkinBeginHtmlHead( & $params )
	{
		if($this->Settings->get( 'force_box_float' )) {

			$button_css = '<style type="text/css">
	<!-- .sharebuttton {width: 65px; overflow:hidden; float: left;} -->
			</style>';
			add_headline( $button_css );
		}
	}

	function get_widget_param_definitions( $params )
	{
		$r = array(
			'fb_like_what' => array(
				'label' => 'Like What ?',
				'id' => $this->classname.'_fb_like_what',
				'onchange' => 'document.getElementById("'.$this->classname.'_fb_url_to_like").disabled = ( this.value == "currpage" );',
				'defaultvalue' => 'currpage',
				'type' => 'select',
				'options' => array( 'currpage' => 'Current Page', 'custom' => 'Custom URL' ),
				'note' => 'Like whichever the page the visitor is on, or use an enforced url to like.',
			),
			'fb_url_to_like' => array(
				'label' => 'URL to like',
				'id' => $this->classname.'_fb_url_to_like',
				//'size' => '105',
				//		'disabled' => true, // this can be useful if you detect that something cannot be changed. You probably want to add a 'note' then, too.
				'note' => 'Change the Like What to custom to activate.',
			),
			'fblbw_layout' => array(
				'label' => T_('Layout Style'),
				'note' => 'determines the size and amount of social context next to the button.default is standart.',
				'defaultvalue' => 'standart',
				'options' => array( 'standard' => $this->T_('standard'), 'button_count' => $this->T_('button_count'), 'box_count' => $this->T_('box_count'), ),
				'type' => 'select',
			),
			'fblbw_width' => array(
				'label' => 'Width',
				'defaultvalue' => '450',
				'note' => 'the width of the plugin in pixels valid range: 1-999, default is : 450',
				'valid_range' => array( 'min'=>1, 'max'=>9999 ),
			),
			'fblbw_height' => array(
				'label' => 'Height',
				'defaultvalue' => '35',
				'note' => 'the height of the plugin in pixels.Recommended values; standart: 35, button_count: 23, box_count:90  valid range: 1-99, default is : 35',
				'valid_range' => array( 'min'=>1, 'max'=>99 ),
			),
			'fblbw_showfaces' => array(
				'label' => T_('Show Faces?'),
				'note' => T_('Show profile pictures below the button.Enabled by default'),
				'defaultvalue' => 'true',
				'options' => array( 'true' => $this->T_('Yes'), 'false' => $this->T_('No'), ),
				'type' => 'select',
			),
			'fblbw_verb' => array(
				'label' => T_('Verb to display'),
				'note' => 'The verb to display in the button. Currently only "like" and "recommend" are supported.Default is like.',
				'defaultvalue' => 'like',
				'options' => array( 'like' => $this->T_('like'), 'recommend' => $this->T_('recommend'), ),
				'type' => 'select',
			),
			'fblbw_color_scheme' => array(
				'label' => T_('Color Scheme'),
				'note' => 'The Color Scheme of the plugin.',
				'defaultvalue' => 'like',
				'options' => array( 'light' => $this->T_('light'), 'dark' => $this->T_('dark'), ),
				'type' => 'select',
			),
			'fblbw_font' => array(
				'label' => T_('Font'),
				'note' => 'the font of the plugin.Default is arial.',
				'defaultvalue' => 'arial',
				'options' => array( 'arial' => $this->T_('Arial'), 'lucida+grande' => $this->T_('Lucida Grande'), 'segoe+ui' => $this->T_('Segoe UI'), 'tahoma' => $this->T_('Tahoma'), 'trebuchet+ms' => $this->T_('Trebuchet Ms'), 'verdana' => $this->T_('Verdana'), ),
				'type' => 'select',
			),
			'fblbw_ba' => array(
				'label' => T_('Before / After content ?'),
				'note' => 'Would you like to display the like button before / after the content ?',
				'defaultvalue' => 'before',
				'options' => array( 'before' => $this->T_('before'), 'after' => $this->T_('after'), ),
				'type' => 'select',
			),
			'fblbw_ac' => array(
				'label' => T_('Css Class'),
				'note' => 'Css class to customize the button -position possibly-',
				'defaultvalue' => 'fbwiframediv',
			),

		);

		if( $this->Settings->get('fb_like_what') == 'custom' )
		{
			$r['fb_url_to_like']['disabled'] = false;
		}
		return $r;
	}

	/* like widget */
	function SkinTag( & $params )
	{
		global $basedomain;
		$fblbw_layout = $params['fblbw_layout'];
		$fblbw_width = $params['fblbw_width'];
		$fblbw_showfaces = $params['fblbw_showfaces'];
		$fblbw_verb = $params['fblbw_verb'];
		$fblbw_color_scheme = $params['fblbw_color_scheme'];
		$fblbw_font = $params['fblbw_font'];
		$fblbw_height = $params['fblbw_height'];
		$fblbw_ba = $params['fblbw_ba'];
		$fblbw_ac = $params['fblbw_ac'];
		$fblbw_likeurl = $params['fb_url_to_like'];
		$fblbw_like_what = $params['fb_like_what'];
		global $ReqURI;
		echo $params['block_start']."\n";
		echo $params['block_title_start'];

		$fblbwutton = '<div class="'.$fblbw_ac.'"><iframe src="http://www.facebook.com/plugins/like.php?app_id=194259500619894&amp;href=';
		if($fblbw_like_what == 'custom' && ! empty($fblbw_likeurl) )
		{
			$fblbwutton .= $fblbw_likeurl;
		}
		else
		{
			$fblbwutton .= 'http://'.$basedomain.$ReqURI;
		}
		$fblbwutton .= '&amp;send=false';
		if($fblbw_layout != 'standard')
		{
			$fblbwutton .= '&amp;layout='.$fblbw_layout;

		}
		$fblbwutton .= '&amp;width='.$fblbw_width.'&amp;show_faces='.$fblbw_showfaces.'&amp;action='.$fblbw_verb.'&amp;colorscheme='.$fblbw_color_scheme.'&amp;font='.$fblbw_font.'&amp;height='.$fblbw_height.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$fblbw_width.'px; height:'.$fblbw_height.'px;" allowTransparency="true"></iframe></div>';

		echo $fblbwutton;
		echo $params['block_end']."\n";

		return ( true ) ;
	}

	/**
	 * Do the same as for HTML.
	 *
	 * @see RenderItemAsHtml()
	 */
	function RenderItemAsXml( & $params )
	{
		$this->RenderItemAsHtml( $params );
	}

	/**
	 * @version 1.0: initial release
	 * @16.06.2011
	 * @author Emin Özlem
	 */
}

?>