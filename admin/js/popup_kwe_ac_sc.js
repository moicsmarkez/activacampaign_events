(function() {
	tinymce.PluginManager.add('popups_kwe_ac_button', function( editor, url ) {
		editor.addButton('popups_kwe_ac_button', {
			text: '',
			//icon: 'wp_code',
			image : url+'/ActiveCampaign-180x180.jpg',
			tooltip: 'Agregar caracteristicas de contactos desde el api de Active Campaign',

			onclick: function() {
				editor.windowManager.open( {
					title: 'Agregar Campo Active Campaign',
					width: 350,
					height: 100,
					body: [
						{
							type: 'listbox',
							name: 'listboxName',
							label: 'Campo:',
							'values': [{"text":"Full Name","value":"FULLNAME"},{"text":"Email","value":"EMAIL"}, {"text":"First Name","value":"FIRSTNAME"}]
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[AC_%' + e.data.listboxName + '% ]');
					}
				});
			}
		});
	});
})();