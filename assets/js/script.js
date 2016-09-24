var rp_lb_themes = [
	'white',
    //'lightgray',
    //'gray',
    'black',
    'padded',
    'drop',
    'line',
    'github',
    'transparent',
    'youtube',
    'habr',
    'heartcross',
    'plusminus',
    'google',
    'greenred',
    'large',
    'elegant',
    'disk',
    'squarespace',
    'slideshare',
    'baidu',
    'uwhite',
    //'ublack',
    'uorange',
    'ublue',
    //'ugreen',
    'direct',
    'homeshop'
];

jQuery(document).ready(function(jQuery) {
	var a = jQuery(".plugins .active[data-slug='rating-plus'] .deactivate a:first");
	if (!a) {
		a = jQuery(".plugins #rating-plus.active .deactivate a:first");
	}

	if (!a || "undefined" == typeof(a.dialog)) {
		return;
	}
	a.attr('onclick', 'rpDeactivateDialog(event, "'+a.attr('href')+'")');
});

function rpDeactivateDialog(event, href)
{
	if (event) {
    	event.preventDefault();
	}
	var dlg_container = jQuery("#rp_deactivate_dlg");
	if (!dlg_container.size()) {
		var dlg_html = 
			'<div id="rp_deactivate_dlg">'+
				'<center>'+
					'Didn\'t get what you want? '+
					'Try <a href="https://likebtn.com/en/wordpress-like-button-plugin?utm_source=ratingplus&utm_campaign=ratingplus&utm_medium=link" target="_blank">Like Button Voting & Rating</a> plugin.<br/><br/>'+
					'<a href="'+rp_lb_install_url+'" target="_blank" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only button-primary rp-button-install" role="button" style="text-shadow:none"><span class="ui-button-text">Install <strong>Like Button Voting & Rating</strong> plugin</span></a>'+
				'</center>'+
				'<h3 class="nav-tab-wrapper" id="rp-nav-tab">'+
	                '<a class="nav-tab rp-nav-tab-themes nav-tab-active" href="javascript:rpSwitchTab(\'themes\');void(0);">Themes</a>'+
	                '<a class="nav-tab rp-nav-tab-stats" href="javascript:rpSwitchTab(\'stats\');void(0);">Stats</a>'+
	                '<a class="nav-tab rp-nav-tab-reports" href="javascript:rpSwitchTab(\'reports\');void(0);">Reports</a>'+
	                '<a class="nav-tab rp-nav-tab-snippets" href="javascript:rpSwitchTab(\'snippets\');void(0);">Google Rich Snippets</a>'+
	            '</h3>'+
	            '<div class="postbox rp-tabbable" id="rp-tabbable-themes" style="min-height: 300px;">'+
	                '<div class="inside">';
	                	'<center>';
        for (theme in rp_lb_themes) {
        	dlg_html += '<span class="likebtn-wrapper"data-identifier="rp_theme_'+rp_lb_themes[theme]+'" data-theme="'+rp_lb_themes[theme]+'"></span>&nbsp;&nbsp;';
        }
        
        dlg_html +=
	                	'</center>'+
	                '</div>'+
	            '</div>'+
	            '<div class="postbox rp-tabbable hidden" id="rp-tabbable-stats">'+
	            	'<div class="inside">'+
	            		'<img src="//likebtn.com/i/wordpress/stats.png" style="width: 100%"/>'+
	            	'</div>'+
	            '</div>'+
	            '<div class="postbox rp-tabbable hidden" id="rp-tabbable-reports">'+
	            	'<div class="inside">'+
	            		'<img src="//likebtn.com/i/wordpress/wordpress-rating-reports.jpg" style="width: 100%"/>'+
	            	'</div>'+
	            '</div>'+
	            '<div class="postbox rp-tabbable hidden" id="rp-tabbable-snippets">'+
	            	'<div class="inside">'+
	            		'<img src="//likebtn.com/i/features/google-rich-snippets.jpg" style="width: 100%"/>'+
	            	'</div>'+
	            '</div>'+
				'<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix" style="border-top: 0">'+
					'<div class="ui-dialog-buttonset">'+
						'<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only button-primary rp-button-deactivate" role="button"><span class="ui-button-text">Deactivate Rating Plus Plugin</span></button>&nbsp;'+
						'<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only button-secondary rp-button-close" role="button"><span class="ui-button-text">Cancel</span></button>'+
					'</div>'+
				'</div>'+
			'</div>';

		dlg_container = jQuery(dlg_html).appendTo(jQuery("body"));
	}

	dlg_container.dialog({
		resizable: false,
		autoOpen: false,
		modal: true,
		width: 430,
		//height: jQuery(window).height()-45,
		title: 'Deactivate Plugin',
		draggable: false,
		show: 'fade',
		dialogClass: 'rp_dialog',
		close: function( event, ui ) {
			
		},
		open: function() {
			jQuery('.ui-widget-overlay, #rp_deactivate_dlg .rp-button-close').bind('click', function() {
				dlg_container.dialog('close');
			});
			jQuery('#rp_deactivate_dlg .rp-button-deactivate').bind('click', function() {
				dlg_container.dialog('close')
				window.location.href = href;
			});
			if (typeof(LikeBtn) !== "undefined") {
				LikeBtn.init();
			}
		},
		position: { 
			my: "center", 
			at: "center" 
		}
	});

	// Load buttons
	(function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");
	
	dlg_container.dialog('open');
}

function rpSwitchTab(tab) {

    jQuery('.rp-tabbable').addClass('hidden');
    jQuery('#rp-tabbable-'+tab).removeClass('hidden');

    jQuery("#rp-nav-tab .nav-tab").removeClass('nav-tab-active');
    jQuery("#rp-nav-tab .nav-tab.rp-nav-tab-"+tab).addClass('nav-tab-active');
}