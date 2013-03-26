// This will add more data at the bottom of a page
$(document).ready(function(){
	
	var lastid;
	
	// add data to page
	function add_data() {
		if(lastid == $(".data_box:last").attr("id")) return false;
		var ID = $(".data_box:last").attr("id");
		lastid = ID;
		$('div#last_loader').html('<center><img src="/styles/images/loader/loading-circle-6f80f87bf9071740308b21923836b0af.gif"></center>');
		$.post("/?page=news&raw=true&limit=10&offset="+ID,function(data){
			if (data != "") { $(".data_box:last").after(data); }
			$('div#last_loader').empty();
		});
	};
	
	// window scroll function
	$(window).scroll(function(){
		if ($(window).scrollTop() == $(document).height() - $(window).height()){
			add_data();
		}
	}); 
	
});
