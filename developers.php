<!DOCTYPE html>
<html>
	<head>
		<title>
        Developers | B2C
		</title>
		<meta name="description" content="developers of platform Ramjivan Jangid, Kunal Awasthi, Kuldeep Jangid">
		<meta name="keywords" content="developers, b2c">
		
		<?php
			//include head
			include 'headTags.php';
		?>
		<style>
        .card {
        box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: 1em;
        text-align: center;
        font-family: arial;
        float:left;
        padding:1em;
        }
        .card:hover{
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2);
        }
        .title {
        color: grey;
        font-size: 18px;
        }

        button {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
        }

        a {
        text-decoration: none;
        font-size: 22px;
        color: black;
        }

        button:hover, a:hover {
        opacity: 0.7;
        }
        .space{
            margin:2px;
        }
        .title li{
            line-height:2em;
        }
        </style>
	</head>
<body>
	<?php
		//including header
		include 'header.php';
	?>
    <div class="main-container">
    <h3>... Our Team ...</h3>
        <div class="card">
            <img src="images/dev/jivan.jpg" alt="Ramjivan Jangid" style="width:100%">
            <h1>Ramjivan Jangid</h1>

            <p>Lachoo Memorial College</p>

            <h3>Job Roles</h3>
        
            <div class="title">
            <li>Cloud Architect</li>
                <li>SEO</li>
            </div>
            
            
            
            <br>
            <a href="https://www.linkedin.com/in/ramjivan-jangid/"><i class="fa fa-linkedin"></i></a> 
            <a href="https://www.santvanitv.com/developers.php"><i class="fa fa-github"></i></a> 
            <a href="https://twitter.com/ramjeewanj"><i class="fa fa-twitter"></i></a> 
            <a href="https://ramjivan.github.io/g1/"><i class="fa fa-globe"></i></a> 
            <p><button>Contact</button></p>
        </div>

        <div class="card">
            <img src="images/dev/kunal.jpg" alt="Kunal Awasthi" style="width:100%">
            <h1>Kunal Awasthi</h1>
            <p>Lachoo Memorial College</p>

            <h3>Job Roles</h3>
        
            <div class="title">
                <li>Database Administrator</li>
                <li>API Developer</li>
                <li>UI Development</li>
            </div>
            
            <br>
            <a href="https://www.linkedin.com/in/kunal-awasthi-37383112b/"><i class="fa fa-linkedin"></i></a> 
            <a href="https://www.santvanitv.com/developers.php"><i class="fa fa-github"></i></a> 
            <a href="#"><i class="fa fa-twitter"></i></a> 
            <a href="#"><i class="fa fa-facebook"></i></a> 
            <p><button>Contact</button></p>
        </div>

        <div class="card">
            <img src="images/dev/kuldeep.jpg" alt="Kuldeep Jangid" style="width:100%">
            <h1>Kuldeep Jangid</h1>
            <p>Lachoo Memorial College</p>

            <h3>Job Roles</h3>
        
            <div class="title">
                <li>UI Designer</li>
                <li>Social Media Handler</li>
            </div>
            
            <br>

            <a href="https://www.linkedin.com/in/ramjivan-jangid/"><i class="fa fa-linkedin"></i></a> 
            <a href="https://www.santvanitv.com/developers.php#"><i class="fa fa-github"></i></a> 
            <a href="https://kunalawasthi.github.io/KunalAwasthi/"><i class="fa fa-globe"></i></a> 
            <a href="https://www.facebook.com/kunal.awasthi1"><i class="fa fa-facebook"></i></a> 
            <p><button>Contact</button></p>
        </div>
    </div>
	<div class="clearfix"></div>	
	<?php
		//including footer
		include 'footer.php';
	?>

	
	<script>
			function putSlider(root_elem_id,elem_id,prev,next)
			{
				var main_root = document.getElementById(root_elem_id);
				var elem = document.getElementById(elem_id);
				var prev = document.getElementById(prev);
				var next = document.getElementById(next);

				var transval = 0;

				if(main_root !== null && elem !== null && prev !== null && next !== null)
				{
					var childs = elem.children; 
					var width = 0;
					var childWidth = 0;
					for(var i = 0 ; i < childs.length ; i++)
					{
						width += childs[i].clientWidth;
						
					}
					
					if(width > 0)
					{
						width+=100;
						elem.style.width = width+'px';
						childWidth = childs[0].clientWidth;
					}

					prev.onclick = function(){
						transval -= 200;
						if(transval < 0)
						{
							transval = 0;
						}
						elem.style.transform =  'translateX(-'+transval+'px)';
					};

					
					next.onclick = function(){
						transval += 200;
						
						measurediff = main_root.offsetWidth / childWidth;

						measurediff *= childWidth;

						if(transval > width-measurediff)
						{
							transval = width-measurediff;
						}
						
						elem.style.transform =  'translateX(-'+transval+'px)';
					};
				}

			}

			putSlider('u_slider_main1','u_slider1','u_slider_prev','u_slider_next');

			function fsSlider(root_elem_id,elem_id,prev,next)
			{
				var main_root = document.getElementById(root_elem_id);
				var elem = document.getElementById(elem_id);
				var prev = document.getElementById(prev);
				var next = document.getElementById(next);

				var transval = 0;

				if(main_root !== null && elem !== null && prev !== null && next !== null)
				{
					
					var lis = elem.children;

					for(var i = 0 ; i < lis.length ; i++)
					{
						lis[i].style.width = elem.clientWidth+'px'; 
					}

					var fsNext = function(){
						var childs = elem.children;

						for(var i = 0 ; i < lis.length ; i++)
						{
							lis[i].style.width = main_root.clientWidth+'px'; 
						}

						elem.style.width = childs.length * main_root.clientWidth+"px";
						transval += main_root.clientWidth;
						if(transval > elem.clientWidth/2)
						{
							transval = 0;
						}
						elem.style.transform =  'translateX(-'+transval+'px)';
					};

					setInterval(fsNext,2000);
				}
			}

			fsSlider('fs_slider1','fssldr_content','fs_slider_prev','fs_slider_next');
			
		</script>
		
</body>
</html>