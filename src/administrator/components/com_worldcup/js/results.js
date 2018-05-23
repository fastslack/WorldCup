jQuery(document).ready(function ($){

	var strings = {"COM_WORLDCUP_JS_FILL_RESULTS":"Please fill the results"
		, "COM_WORLDCUP_JS_RESULTS_SAVED":"Result saved!"
		, "COM_WORLDCUP_JS_RESULTS_DELETED":"Result deleted!"

	};

	if (typeof Joomla == 'undefined') {
		Joomla = {};
		Joomla.JText = strings;
	}
	else {
		Joomla.JText.load(strings);
	}

  $$('.edit').addEvent( 'click', function(event) {

		var id = this.title;
    var local = document.getElementById('l'+id);
    var visit = document.getElementById('v'+id);
    var t1 = document.getElementById('t1-'+id);
    var t2 = document.getElementById('t2-'+id);

    local.disabled = 0;
    visit.disabled = 0;
  });

  $$('.save').addEvent( 'click', function(event) {

		var id = this.title;

    var local = document.getElementById('l'+id);
    var visit = document.getElementById('v'+id);
    var t1 = document.getElementById('t1-'+id);
    var t2 = document.getElementById('t2-'+id);

    if (local.disabled == 1 || visit.disabled == 1) {
      return false;
    }

    if (local.value == "" || visit.value == "") {
			alert(Joomla.JText._('COM_WORLDCUP_JS_FILL_RESULTS'));
      return false;
    }

		var url = 'index.php?option=com_worldcup&task=ajax.saveResult&format=raw&id='+id+'&l='+local.value+'&v='+visit.value+'&t1='+t1.value+'&t2='+t2.value;

		$.ajax({ 	type: "GET",	 url: url,
			complete: function(response) {

        local.disabled = 1;
        visit.disabled = 1;
        alert(Joomla.JText._('COM_WORLDCUP_JS_RESULTS_SAVED'));

			}
		}); // end ajax

  });

  $$('.delete').addEvent( 'click', function(event) {

		var mid = parseInt(this.title);

    var local = document.getElementById('l'+mid);
    var visit = document.getElementById('v'+mid);

    if (local.disabled == 0 || visit.disabled == 0 ) {
      return false;
    }

		var url = 'index.php?option=com_worldcup&task=ajax.deleteResult&format=raw&mid='+mid+'&l='+local.value+'&v='+visit.value;

		$.ajax({ 	type: "GET",	 url: url,
			complete: function(response) {

        local.disabled = 0;
        visit.disabled = 0;
        alert(Joomla.JText._('COM_WORLDCUP_JS_RESULTS_DELETED'));

			}
		}); // end ajax

  });

});
