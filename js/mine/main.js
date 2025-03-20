
jQuery(document).ready(function(){
								
	var initObj		= new initEnv();
	
	initObj.init();
});

var projectID  		= "";
var select_group 	= undefined;

var initEnv			= function()
{
	var main		= this;

	main.obj_3d 	= null;
	main.options 	= 
	{
		window 		: {obj : "Normal_Casement.obj", mtl : "Normal_Casement.mtl", mode : "Normal_Casement"},
		grill 		: {obj : "", mtl : ""},
		size  		: {width  : 100, height : 100, length : 100},
		pos     	: {x  : 0, y  : 0, z  : 0},
		glass  		: "",
		material 	: ""
	}

	main.init		= function()
	{
		main.initEvent();
		main.init3D();
		main.initSlider();
	};

	main.initEvent 	= function()
	{
		$("#progress-bar li").click(function()
		{
			return;
			var index = $(this).index() * 1;
			
			main.showPage(index);
		});

		$("page li").click(function()
		{
			$(this).parent().find(".sel").removeClass("sel");
			$(this).addClass("sel");
		});

		$("#btn_next").click(function()
		{
			var curr_index 	= $("#progress-bar .done").index();
			var sel_page  	= $("#content .active");
			var sel_elem 	= sel_page.find(".sel");

			switch(sel_page.attr("id"))
			{
				case "page_style" :
					main.options.window.mode = sel_elem.attr("mode"); 
					main.options.window.obj  = sel_elem.attr("mode") + ".obj";
					main.options.window.mtl  = sel_elem.attr("mode") + ".mtl";
				break;
				case "page_size" :
					main.options.size.width  = $("#num_width").val();
					main.options.size.height = $("#num_height").val();
					main.options.size.length = $("#num_length").val();
				break;
				case "page_grill" :

					switch(sel_elem.attr("data"))
					{
						case "colonial" :
							if(main.options.window.mode == "Normal_Casement")
							{
								main.options.grill.obj = "Normal_Colonial.obj";
								main.options.grill.mtl = "Normal_Colonial.mtl";
							}
							else
							{
								main.options.grill.obj = "Normal_Half_Colonial.obj";
								main.options.grill.mtl = "Normal_Half_Colonial.mtl";
							}
						break;
						case "fractional" :
							if(main.options.window.mode == "Normal_Casement")
							{
								main.options.grill.obj = "Normal_Big_Fractional.obj";
								main.options.grill.mtl = "Normal_Big_Fractional.mtl";
							}
							else
							{
								main.options.grill.obj = "Normal_SH_Big_Fractional.obj";
								main.options.grill.mtl = "Normal_SH_Big_Fractional.mtl";
							}
						break;
						case "prairie" :
							if(main.options.window.mode == "Normal_Casement")
							{
								main.options.grill.obj = "Normal_Fractional.obj";
								main.options.grill.mtl = "Normal_Fractional.mtl";
							}
							else
							{
								main.options.grill.obj = "Normal_SH_Fractional1.obj";
								main.options.grill.mtl = "Normal_SH_Fractional1.mtl";
							}
						break;
						case "none" :
							main.options.grill.obj = "";
							main.options.grill.mtl = "";
						break;
					}
				break;
				case "page_glass" :
					main.options.glass = sel_elem.children("img").attr("src");
				break;
				case "page_material" :
					main.options.pos.y 		= -7;
					main.options.material 	= sel_elem.children("img").attr("src");

					main.obj_3d.removeObj();
					main.obj_3d.addObject(main.options, 0);
				break;
			}

			main.showPage(curr_index * 1 + 1);
		});

		$("#btn_prev").click(function()
		{
			var curr_index = $("#progress-bar .done").index();

			main.showPage(curr_index * 1 - 1);
		});
	}

	main.showPage 	= function(index)
	{
		$(".active").removeClass("active");
		$("#content").children(":nth-child(" + (index + 1) + ")").addClass("active");
		$("#btn_prev").attr("disabled", "disabled");
		$("#btn_next").attr("disabled", "disabled");
		// $("#btn_next").attr("disabled", "disabled");

		$("#progress-bar .done").removeClass("done");
		$("#progress-bar").children(":nth-child(" + (index + 1) + ")").addClass("done");	

		if(index != 0)
		{
			$("#btn_prev").removeAttr("disabled");
		}

		if(index != 5)
		{
			$("#btn_next").removeAttr("disabled");
		}

		if(index == 4)
		{
			$("#btn_next").val("Render");
		}
		else
		{
			$("#btn_next").val("Next");
		}
	}

	main.initSlider = function()
	{
		$(".slider").each(function()
		{
			var elem = $(this).parent().children("input");
			var val  = elem.val();

			$(this).slider(
			{
				value 	: val, 
				min 	: 5.0, 
				max 	: 30.0, 
				step 	: 0.1, 
				slide 	: function(evt, ui)
				{
					elem.val(ui.value);
				}
			});
		});
	}

	main.init3D 	= function()
	{
		var width 	= 1024;
		var height 	= 500;

		main.obj_3d = jQuery("#render_area").showModel({width : width, height : height});
	}
}