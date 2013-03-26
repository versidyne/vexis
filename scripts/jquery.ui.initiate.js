$(function(){
	
	// Autocomplete
	$.ajax({
		url: "/?page=suggest&query=%",
		dataType: "xml",
		success: function( xmlResponse ) {
			var data = $( "page", xmlResponse ).map(function() {
				return {
					value: $( "title", this ).text()
				};
			}).get();
			$( "#query" ).autocomplete({
				source: data,
				minLength: 0
			});
		}
	});
	
	// Tooltips
	/*$(document).tooltip({
		position: {
			my: "left center",
			at: "right+10 center",
			collision: "none"
		},
		tooltipClass: "right"
		open: function() {
			var className;
			var position;
			if ($(this).hasClass("top")) {
				className = "top";
				position = { my: "center bottom", at: "center top-10" };
			} else if ($(this).hasClass("bottom")) {
				className = "bottom";
				position = { my: "center top", at: "center bottom+10" };
			} else if ($(this).hasClass("left")) {
				className = "left";
				position = { my: "right center", at: "left-10 center" };
			} else if ($(this).hasClass("right")) {
				className = "right";
				position = { my: "left center", at: "right+10 center" };
			} else {
				className = "right";
				position = { my: "left center", at: "right+10 center" };
			}
			position.collision = "none";
			$(this).tooltip('option', 'position', position);
			$(this).tooltip('option', 'tooltipClass', className);
		}
	});*/
	
	// Help Link
	$("#help-navigation").click(function () {
		$('#info-navigation').dialog('open');
	});
	
	// Info Dialog Options
	var options = {
		autoOpen: false,
		width: 400,
		modal: true,
		show: {
			effect: "fold",
			duration: 1000
		},
		hide: {
			effect: "fold",
			duration: 1000
		},
		/*open: function (event, ui) {
			$('#secondary').attr('checked', 'true');
		},*/
		buttons: {
			"Ok": function() {
				$(this).dialog("close");
			}
		}
	};
	
	// Info Dialogs
	$([1, 2, 3, 4, 5, 6, 7, 8]).each(function() {
		var num = this;
		var dlg = $("#info-" + num)
			.load("/?page=help&topic=" + num)
			.dialog(options);
		$("#help-" + num).click(function() {
			dlg.dialog("open");
			return false;
		});
	});
	
	// General Dialog
	$('#dialog').dialog({
		autoOpen: true,
		width: 400,
		modal: true,
		show: {
			effect: "fold",
			duration: 1000
		},
		hide: {
			effect: "fold",
			duration: 1000
		},
		buttons: {
			"Ok": function() {
				$(this).dialog("close");
			}
		}
	});
	
	// Accordion
	$("#accordion").accordion({
		header: "h3",
		active: curtab,
		heightStyle: "content",
		collapsible: true,
		autoheight: false,
		clearStyle: true,
		alwaysOpen: false
		/*icons: {
			"header": "ui-icon-circle-triangle-e",
			"activeHeader": "ui-icon-circle-triangle-s"
		}*/
	}).find('.menu-link').click(function(ev){
		ev.preventDefault();
		ev.stopPropagation();
		//top.frames[this.target].location.href = this.href;
	});

	// Tabs
	$('#tabs').tabs();

	// Datepicker
	$('#datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		showAnim: "bounce"
	});

	// Slider
	$('#slidebar').slider({
		range: true,
		values: [17, 67]
	});

	// Progressbar
	$("#progressbar").progressbar({
		value: 20
	});

	//hover states on the static widgets
	$('#dialog_link, ul#icons li').hover(
		function() { $(this).addClass('ui-state-hover'); },
		function() { $(this).removeClass('ui-state-hover'); }
	);

	// drag and drop
	$(".draggable").draggable();
	$("#draggable").draggable();
	$("#droppable").droppable({
		drop: function( event, ui ) {
			$( this )
				.addClass( "ui-state-highlight" )
				.find( "p" )
				.html( "Dropped!" );
		}
	});
	
	// resizable
	$( "#resizable" ).resizable();
	
	// selectable
	$( "#selectable" ).selectable();
	
	// sortable feature
	//$( "#sortable" ).sortable();
	//$( "#sortable" ).disableSelection();
	
	// buttons
	$( '[id^="dropbutton"]' )
		.button()
		.click(function() {
			alert( "Running the last action" );
		})
		.next()
			.button({
				text: false,
				icons: {
					primary: "ui-icon-triangle-1-s"
				}
			})
			.click(function() {
				var menu = $( this ).parent().next().show().position({
					my: "left top",
					at: "left bottom",
					of: this
				});
				$( document ).one( "click", function() {
					menu.hide();
				});
				return false;
			})
			.parent()
				.buttonset()
				.next()
					.hide()
					.menu();
	
});

// sortable feature
$(document).ready(function() {
	$( "#sortable" ).sortable({
		update : function () {
			serial = $('#sortable').sortable('serialize');
			$.ajax({
				url: "/?page=editor",
				type: "post",
				data: serial,
				//success: function(data) { alert(data); },
				error: function(){ alert("An error occurred while attempting to save this data."); }
			});
		}
	});
	$( "#sortable-2" ).sortable({
		update : function () {
			serial = $('#sortable-2').sortable('serialize');
			$.ajax({
				url: "/?page=editor",
				type: "post",
				data: serial,
				error: function(){ alert("An error occurred while attempting to save this data."); }
			});
		}
	});
});
