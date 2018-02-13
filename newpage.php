<!DOCTYPE html>
<html>
	<head>
		<title>
			new Page | B2C
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		
		<?php
			//include head
			include 'headTags.php';
		?>
		
		<script>
		
		var _cat_sel_count = 1;
		
		function nescat(index)
		{
			var spinner = document.getElementById('31t'+index);
			
			if(spinner !== null)
			{
				while(index < _cat_sel_count )
				{
					if(document.getElementById('31t'+index) !== null)
					{
						document.getElementById('31t'+_cat_sel_count).parentNode.removeChild(document.getElementById('31t'+_cat_sel_count));
					}
					_cat_sel_count--;
				}
				xhr_call(
					'GET',
					'/b2c/apies/index/subcategory/'+spinner.value,
					null,
					function(xhttp){
						const tar = document.getElementById('31t'+index);
						if(tar !== null)
						{	
							if(xhttp.responseText.length > 0)
							{
								var json = JSON.parse(xhttp.responseText);
								if(json.result)
								{
									var select = document.createElement('select');
									select.setAttribute('id','31t'+(index+1));
									
									for(var i =0 ; i < json.items.length ; i++)
									{
										var option = document.createElement('option');
										option.setAttribute('value',json.items[i].category_id);
										option.appendChild(document.createTextNode(json.items[i].cat_name));
										select.appendChild(option);
									}
									
									document.getElementsByTagName('body')[0].appendChild(select);
									_cat_sel_count+=1;
									select.addEventListener('change',function(){nescat(index+1)});
								}
							}
						}							
					}
				);
			}
		}
xhr_call(
	'GET',
	'/b2c/apies/index/category',
	null,
	function(xhttp){
		var tar = document.getElementById('31t1');
		var classes = [];
		if(tar !== null)
		{	
			if(xhttp.responseText.length > 0)
			{
				var json = JSON.parse(xhttp.responseText);
				
				if(json.result > 0)
				{
					for(var i = 0 ; i < json.items.length ; i++)
					{
						var option = document.createElement('option');
						option.setAttribute('value',json.items[i].category_id);
						option.appendChild(document.createTextNode(json.items[i].cat_name));
						tar.appendChild(option);
					}
				}
			}
		}
	},
	function(xhttp){
		alert('ERROR');
	}
);
		</script>
		
	</head>
<body>
	<?php
		//including header
		include 'header.php';
	?>
	<!--Content Here-->
	
	
	<select id="31t1" onchange="nescat(1)">
	</select>
	<!--Content Here-->

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>