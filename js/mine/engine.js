/**
 *
 * Jquery WebGL Rendering Plugin
 *
 * Author 	: Excellent Skill
 * Created  : 2017/02/15
 * 
 * Jquery WebGL library
 *
 */

(function( $ ){
	
	$.fn.showModel = function(para) 
	{
		var main 		= this;

		main.elemID 	= "";
		main.param 	    = para;
		main.render_id 	= 0;

		main.view_angle = 45;
		main.near 		= 1;
		main.far 		= 3000;
        main.is_draw    = 0;
        main.last_intst = null;

		main.camera_x 	= 0;
		main.camera_y 	= 0;
		main.camera_z 	= 35;

		main.camera_lx 	= 0;
		main.camera_ly 	= 0;
		main.camera_lz 	= 0;

        main.obj_floor  = null;

        main.minPolarAngle  = 0;
        main.maxPolarAngle  = Math.PI / 6;

        main.minRotAngle    = - Math.PI * 0.2;
        main.maxRotAngle    =  Math.PI * 0.2;

        main.isDrag         = 0;
        main.sPos           = {x : 0, y : 0};

        main.window         = null;
        main.grill          = null;

        main.orbitControls  = null;
        main.intersect      = null;

		main.init 			= function()
		{
            main.elemID = $(this).attr("id");

			main.initScene();
            main.initCamera();
            main.initRenderer();
            main.initLights();
            main.initElement();
            main.initControl();
			main.render();
            main.initEvent();
            main.setBackground();
         }

		main.initElement 	= function()
		{
            document.getElementById(main.elemID).appendChild(main.webGLRenderer.domElement);
		}

        main.initEvent      = function()
        {

        }

		main.initScene      = function()
        {
            // main.cssScene   = new THREE.Scene();
            main.scene      = new THREE.Scene();
        }

        main.initCamera     = function()
        {
            main.screen_width   = main.param.width;
            main.screen_height  = main.param.height;

            var ASPECT 			= main.screen_width / main.screen_height;
            // var group           = new THREE.Object3D();
            
            main.camera         = new THREE.PerspectiveCamera(main.view_angle, ASPECT, main.near, main.far);
            // main.cameraGroup    = new THREE.Object3D();

            // main.cameraGroup.add(main.camera);
            main.scene.add(main.camera);
            
            // main.camera.position.set(0, 0, 80);
            main.camera.position.set(main.camera_x, main.camera_y, main.camera_z);
            main.camera.lookAt(new THREE.Vector3(main.camera_lx, main.camera_ly, main.camera_lz));
            main.camera.rotation.order = 'YXZ';
        }

        main.initControl    = function()
        {
            main.orbitControls = new THREE.OrbitControls(main.camera, main.webGLRenderer.domElement, new THREE.Vector3(main.camera_lx, main.camera_ly, main.camera_lz));
        }

        main.initRenderer   = function()
        {
            main.webGLRenderer = new THREE.WebGLRenderer({ antialias:true, preserveDrawingBuffer : true, alpha: true });
            main.webGLRenderer.setSize(main.screen_width, main.screen_height);
            main.webGLRenderer.setClearColor( 0x000000, 0 );
        }

        main.setBackground  = function(x, y ,z)
        {
            return;
            var geometry    = new THREE.SphereGeometry( 1024, 10, 10 );
            var texture     = new THREE.ImageUtils.loadTexture("img/sky_midafternoon.jpg");
            var material    = null;
            var background  = null;

            texture.wrapS   = texture.wrapT = THREE.RepeatWrapping;
            texture.repeat.x= 1;
            texture.repeat.y= 1;

            material        = new THREE.MeshBasicMaterial( { map: texture, transparent: true, side:THREE.DoubleSide, alphaTest : 0.5, depthWrite : false, opacity : 1.0 } );
            background      = new THREE.Mesh( geometry, material );

            main.scene.add( background );
        }

        main.initLights     = function()
        {
            var hemiLight    = new THREE.HemisphereLight( 0xFFFFFF, 0x999999, 1 );
            var ambientLight = new THREE.AmbientLight( 0x999999 );

            hemiLight.position.set( 0, 30, 0 );

            main.scene.add( hemiLight );
            main.scene.add( ambientLight );

            // main.addShadowedLight( 350, 320, -355, 0xFFFFFF, 0.76 );
            // main.addShadowedLight( -350, 320, 350, 0xFFFFFF, 0.76 );
        }

        main.addShadowedLight   = function( x, y, z, color, intensity ) 
        {
            var directionalLight = new THREE.DirectionalLight( color, intensity );
            directionalLight.position.set( x, y, z );
            main.scene.add( directionalLight );
            
            directionalLight.castShadow = true;

            var d = 2;
            directionalLight.shadowCameraLeft = -d;
            directionalLight.shadowCameraRight = d;
            directionalLight.shadowCameraTop = d;
            directionalLight.shadowCameraBottom = -d;
            directionalLight.shadowCameraNear = 1;
            directionalLight.shadowCameraFar = 10;
            directionalLight.shadowMapSizeWidth = 5;
            directionalLight.shadowMapSizeHeight = 5;
            directionalLight.shadowBias = -0.000002;
        }

        main.addObject 		= function(param, isGrill)
        {
            var mtlLoader   = new THREE.MTLLoader();
            var objLoader   = new THREE.OBJLoader();
            var group       = new THREE.Object3D();

            var onProgress  = function ( xhr ) {};
            var onError     = function ( xhr ) {};
            var g_param     = {};
            var texture     = null;
            var w_texture   = null;

            var obj         = param.window.obj;
            var mtl         = param.window.mtl;

            if(isGrill)
            {
                obj         = param.grill.obj;
                mtl         = param.grill.mtl;
            }

            mtlLoader.setPath( 'model/' );
            mtlLoader.load(mtl, function(materials) 
            {
                materials.preload();

                texture         = new THREE.ImageUtils.loadTexture(param.material);
                texture.wrapS   = texture.wrapT = THREE.RepeatWrapping;
                texture.repeat.x = texture.repeat.y = 1;

                if(isGrill)
                {
                    materials.materials.scene_material = new THREE.MeshPhongMaterial({map : texture});
                }
                else
                {
                    w_texture = new THREE.ImageUtils.loadTexture(param.glass);
                    w_texture.wrapS   = w_texture.wrapT = THREE.RepeatWrapping;
                    w_texture.repeat.x = w_texture.repeat.y = 1;

                    if(materials.materials["Polygon_XSIPOLYCLS.phong"])
                        materials.materials["Polygon_XSIPOLYCLS.phong"] = new THREE.MeshPhongMaterial({map : w_texture, opacity : 0.5, transparent : true, side:THREE.DoubleSide, shiniess : 100});
                    else
                        materials.materials["Polygon1_XSIPOLYCLS.phong"] = new THREE.MeshPhongMaterial({map : w_texture, opacity : 0.5, transparent : true, side:THREE.DoubleSide, shiniess : 100});

                    materials.materials.scene_material1 = new THREE.MeshPhongMaterial({map : texture});
                }

                objLoader.setPath( 'model/' );
                objLoader.setMaterials(materials);

                objLoader.load( obj, function ( object ) 
                {
                    object.position.y = param.pos.y;

                    var box     = new THREE.Box3().setFromObject( object );
                    var size    = box.size();

                    main.scene.add(object);

                    if(!isGrill)
                    {
                        object.scale.x = param.size.width / size.x;
                        object.scale.y = param.size.height / size.y;
                        object.scale.z = param.size.length / size.z;
 
                        main.window = object;
                    }
                    else
                    {
                        object.scale.x = param.scale.x;
                        object.scale.y = param.scale.y;
                        object.scale.z = param.scale.z;

                        main.grill = object;
                    }

                    if(!isGrill && param.grill.obj != "")
                    {
                        param.scale = object.scale;
                        main.addObject(param, 1);
                    }

                }, onProgress, onError);
            });
        }

        main.removeObj  = function()
        {
            if(main.window)
            {
                main.scene.remove(main.window);
                delete main.window;
            }

            if(main.grill)
            {
                main.scene.remove(main.grill);
                delete main.grill;
            }
        }

        main.render     = function() 
        {
            main.orbitControls.update();

            main.webGLRenderer.render(main.scene, main.camera);

            requestAnimationFrame(main.render);
        }

        main.init();

        return main;
	}; 

})( jQuery );