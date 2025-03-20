
jQuery(document).ready(function(){
								
	var initObj		= new initAdmin();
	
	initObj.init();
});

var projectID = "";

var initAdmin		= function()
{
	var main		= this;

	main.popup 		= null;
	main.mode 		= "house";

	main.init		= function()
	{
		main.initEvent();
		main.popup 	= new classPopup();
	};

	main.initCSS	= function()
	{

	};

	main.initEvent 	= function()
	{
		$("#data_list").on("click", "li", function()
		{
			if($(this).hasClass('active'))
			{
				$(this).removeClass('active');
			}
			else
			{
				$(this).addClass('active');
			}
		});

		$("#btn_add").click(function()
		{
			main.popup.show("overlay_file");
		});

		$("#btn_del").click(function()
		{
			var id_list = "";
			var mode 	= "";

			if(!confirm("Are you sure remove this images?"))
				return;

			if(main.mode == "house")
				mode = "remove_house";
			else
				mode = "remove_stone";

			$("#data_list").find(".active").each(function()
			{
				id_list += $(this).attr("info") + ",";
				$(this).remove();
			});

			$.ajax(
			{
				type 	: "POST",
				url 	: "php/ajax.php", 
				data 	: ({mode : mode, id_list : id_list}),
				cache 	: false,
				success : function (result) 
				{
					
				}
			});
		});
	}
}