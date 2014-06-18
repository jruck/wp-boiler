(function() {
	tinymce.create('tinymce.plugins._titan_framework_shortcodes', {

		init : function(ed, url) {
		},

		createControl : function(n, cm) {
			if( n == '_titan_framework_shortcodes' ) {
				var mlb = cm.createListBox( '_titan_framework_shortcodes', {

					 title : _titan_framework_shortcodes_label,

					 onselect : function( shortcode ) {
                         var selected = tinyMCE.activeEditor.selection.getContent();

                         // If nothing is selected just insert the shortcode
                         if ( selected == '' ) {
                             tinyMCE.activeEditor.selection.setContent( shortcode );

                         // If something is selected, wrap it in our shortcode
                         } else {
                             var endTag = '[/' + /^\[([^\s\]]+)/.exec( shortcode )[1] + ']';
                             tinyMCE.activeEditor.selection.setContent( shortcode + selected + endTag );
                         }
                     }
                 });

				for (var i in _titan_framework_shortcodes ) {
                    mlb.add( i, _titan_framework_shortcodes[i] );
                }

				return mlb;
			}
			return null;
		}
	});
	tinymce.PluginManager.add( '_titan_framework_shortcodes', tinymce.plugins._titan_framework_shortcodes );
})();