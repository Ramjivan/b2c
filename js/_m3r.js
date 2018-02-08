window.onload = function(){
	var loc_arr = window.location.toString().split('/');
	switch(true)
	{
		case /product.php/.test(loc_arr[loc_arr.length-1]):
			//global vars 
			var spcount = 1;
			//global vars
			
			
			var formvalidation = [
				{'id':'name','name':'Email Address','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null},
				{'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
				{'id':'price','name':'Price','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
				{'id':'category','name':'Category','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':null},
				{'id':'stock','name':'Stock','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
				{'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null},
				{'id':'hlgt1','name':'Hightlight1','regex':null,'length':null,'min_length':5,'max_length':null},
				{'id':'sp_name1','name':'Spec Name 1','regex':null,'length':null,'min_length':5,'max_length':null},
				{'id':'sp_value1','name':'Spec Value 1','regex':null,'length':null,'min_length':5,'max_length':null}
			];
			
			var edit_formvalidation = [
				{'id':'e_name','name':'Email Address','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null},
				{'id':'e_description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
				{'id':'e_price','name':'Price','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
				{'id':'e_stock','name':'Stock','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
			];
			
			function get()
			{
				var method = "GET";
				var url = "/b2c/apies/product";
				var formData = null;
				var success = function(xhttp){
					var tab = document.getElementById('tbdy');
					if(tab !== null)
					{
						if(tab !== null)
						{
							tab.innerHTML = "";
						}
						var json_response = JSON.parse(xhttp.responseText);
						if(json_response.success)
						{
							for(var i= 0 ; i < json_response.items.length ; i++)
							{
								var row = '<tr>\
											<td>'+json_response.items[i].product_id+'</td>\
											<td>'+json_response.items[i].p_name+'</td>\
											<td>'+json_response.items[i].p_description+'</td>\
											<td>'+json_response.items[i].p_price+'</td>\
											<td>'+json_response.items[i].p_category+'</td>\
											<td>'+json_response.items[i].p_stock+'</td>\
											<td>'+json_response.items[i].img_list_id+'</td>\
											<td><span id="ed'+json_response.items[i].product_id+'" class="fa fa-pencil"></span></td>\
										   </tr>';
								
								tab.innerHTML += row;
								
							}
							for(var i = 0 ; i < json_response.items.length ; i++)
							{
								var str = 'ed'+json_response.items[i].product_id; 
								const id = json_response.items[i].product_id;
								document.getElementById(str).addEventListener('click',function(){
									document.getElementsByClassName('dialog')[0].style.display = 'block';
									document.getElementsByClassName('blurdfg')[0].className += ' active'; 
									document.getElementById('pe5d_3fid').value = id;
									
									//product form action
									var btn = document.getElementById('ed');
									
									if(btn !== null)
									{
										var success = function(xhttp){
											if(JSON.parse(xhttp.responseText).success == '1')
											{
												get();
												document.getElementById('pctefm').reset();
												this.parentElement.parentElement.style.display='none';
												document.getElementsByClassName('blurdfg')[0].style.display='none';
											}
											else if(JOSN.parse(xhttp.responseText).ERROR !== undefined)
											{
												alert("Connection lost while connecting to Server");
											}
										};
										var fail = function(xhttp){
											alert(xhttp.responseText);
										};
										btn.addEventListener('click',function(){
											submit_form('pctefm',edit_formvalidation,'valsum','/b2c/apies/product/edit','POST',success,fail);
										});
									}
									
								});
							}
						}
						else
						{
							alert(json_response.ERROR);
						}
					}
					else
					{
						alert('Fatel Error');
					}
				};
				
				var fail = function(xhttp){
					alert(xhttp.responseText);
				};
				
				xhr_call(
					method,
					url,
					formData,
					success,
					fail
				);
			}
			
			function put_count(name,count)
			{
				var target = document.getElementById(name);
				if(target !== null)
				{
					for(var i = 1 ; i <= count ; i++)
					{
						var opt = document.createElement('option');
						opt.setAttribute('value',i);
						var txt = document.createTextNode(i);
						opt.appendChild(txt);
						target.appendChild(opt);
					}
					
				target.onchange = function(){
					spchange('qasw',this.value);
					return true;
				};
				
				}
			}
			
			function rng(index)
			{
				var data = new FormData(document.getElementById('pctafm'));
				var  specs = document.getElementsByClassName('spec');
				
				while(specs.length !== index-1)
				{
					specs[specs.length-1].parentNode.removeChild(specs[specs.length-1]);
				}
				
				for(var i = index ; i < spcount ;i++)
				{
				
					tar = document.getElementById('qasw');
					
					var div = document.createElement('div');
					
					div.setAttribute('class','spec');
					
					var h3 = document.createElement('h3');
					h3.appendChild(document.createTextNode('Specification '+i+' '));
					var span = document.createElement('span');
					span.setAttribute('class','fa fa-trash');
					const p = i-1;
					span.onclick = function(){
						rng(p);
					};
					h3.appendChild(span);
					div.appendChild(h3);
					
					var sp_name = document.createElement('input');
					sp_name.setAttribute('id','sp_name'+i);
					sp_name.setAttribute('onchange','validate({\'id\':\'sp_name'+i+'\',\'name\':\'Spec Name '+i+'\',\'regex\':null,\'length\':null,\'min_length\':5,\'max_length\':null})');
					sp_name.setAttribute('Placeholder','Spec Name');
					sp_name.setAttribute('name','sp_name'+i-1);
					sp_name.setAttribute('type','text');
					sp_name.setAttribute('value',data.get('sp_name'+(i+1)));
					div.appendChild(sp_name);
					
					var sp_value = document.createElement('input');  
					sp_value.setAttribute('id','sp_value'+i);
					sp_value.setAttribute('onchange','validate({\'id\':\'sp_value'+i+'\',\'name\':\'Spec Value '+i+'\',\'regex\':null,\'length\':null,\'min_length\':5,\'max_length\':null})');
					sp_value.setAttribute('placeholder','Spec Value');
					sp_value.setAttribute('name','sp_value'+i);
					sp_value.setAttribute('type','text');
					sp_value.setAttribute('value',data.get('sp_value'+(i+1)));
					div.appendChild(sp_value);
					
					tar.appendChild(div);
				}
				
				document.getElementById('s_c').value = i-1;
				spcount = i-1;
			}
			
			function spchange(target,count)
			{
				if(count > spcount)
				{
					//add
					for(var i = parseInt(spcount)+1 ; i <= count ;i++)
					{
					
						tar = document.getElementById(target);
						
						var div = document.createElement('div');
						
						div.setAttribute('class','spec');
						
						var h3 = document.createElement('h3');
						h3.appendChild(document.createTextNode('Specification '+i+' '));
						var span = document.createElement('span');
						span.setAttribute('class','fa fa-trash');
						const p = i;
						span.onclick = function(){
							rng(p);
						};
						h3.appendChild(span);
						div.appendChild(h3);
						
						var sp_name = document.createElement('input');
						sp_name.setAttribute('id','sp_name'+i);
						sp_name.setAttribute('onchange','validate({\'id\':\'sp_name'+i+'\',\'name\':\'Spec Name '+i+'\',\'regex\':null,\'length\':null,\'min_length\':5,\'max_length\':null})');
						sp_name.setAttribute('Placeholder','Spec Name');
						sp_name.setAttribute('name','sp_name'+i);
						sp_name.setAttribute('type','text');
						div.appendChild(sp_name);
						
						var sp_value = document.createElement('input');  
						sp_value.setAttribute('id','sp_value'+i);
						sp_value.setAttribute('onchange','validate({\'id\':\'sp_value'+i+'\',\'name\':\'Spec Value '+i+'\',\'regex\':null,\'length\':null,\'min_length\':5,\'max_length\':null})');
						sp_value.setAttribute('placeholder','Spec Value');
						sp_value.setAttribute('name','sp_value'+i);
						sp_value.setAttribute('type','text');
						div.appendChild(sp_value);
						
						tar.appendChild(div);
					}
					
					spcount = count;
				}
				else if(count < spcount)
				{
					//truncate
					alert(count);
				}
			}
			

			
			
			(function(){
				
				get(); //get data
				
				//product form action
				var btn = document.getElementById('add');
				if(btn !== null)
				{
					var success = function(xhttp){
						if(JSON.parse(xhttp.responseText).success == '1')
						{
							get();
							document.getElementById('pctafm').reset();
						}
						else if(JOSN.parse(xhttp.responseText).ERROR !== undefined)
						{
							alert("Connection lost while connecting to Server");
						}
					};
					var fail = function(xhttp){
						alert(xhttp.responseText);
					};
					btn.addEventListener('click',function(){
						submit_form('pctafm',formvalidation,'vsap','/b2c/apies/product/add','POST',success,fail);
					});
				}
				//product form action
				
				
				put_count('s_c',20);
				
			})();
			
		break;
		
		
		case /Orders.php/.test(loc_arr[loc_arr.length-1]):
		
		
		
		break;
		
		
		case /qna.php/.test(loc_arr[loc_arr.length-1]):
		
			
		
		break;
		
		case (/category.php/.test(loc_arr[loc_arr.length-1])):
			
			function get_cat()
			{
				var method = "GET";
				var url = "/b2c/apies/product/category/merchant";
				var formData = null;				
				var success = function(xhttp){
					var tab = document.getElementById('tbdy');
					if(tab !== null)
					{
						
						if(tab !== null)
						{
							tab.innerHTML = "";
						}							
						
						var json_response = JSON.parse(xhttp.responseText);
						if(json_response.result)
						{
							for(var i= 0 ; i < json_response.items.length ; i++)
							{
								var row = '<tr>\
											<td>'+json_response.items[i].cat_name+'</td>\
											<td>'+json_response.items[i].cat_description+'</td>\
											<td>'+json_response.items[i].parent_name+'</td>\
											<td><span class="fa fa-pencil"></span></td>\
										   </tr>';
								
								tab.innerHTML += row;
							}
						}
						else
						{
							alert(json_response.ERROR);
						}
					}
					else
					{
						alert('Fatel Error');
					}
				};
				
				var fail = function(xhttp){
					alert(xhttp.responseText);
				};
				
				xhr_call(
					method,
					url,
					formData,
					success,
					fail
				);
			}
			
			function pchange()
			{
				var tar = document.getElementsByName('isTop');
				var fn = function(target){
					if(target.checked == true)
					{
						document.getElementById('category').removeAttribute('disabled');
					}
					else
					{
						document.getElementById('category').setAttribute('disabled','true');
					}
				};
				
				var fn2 = function(target){
					if(target.checked == true)
					{
						document.getElementById('category').setAttribute('disabled','true');
					}
					else
					{
						document.getElementById('category').removeAttribute('disabled');
					}
				};
				
				
				if(tar !== null)
				{
					tar[0].onchange = function(){
						fn(this);
					};
					tar[1].onchange = function(){
						fn2(this);
					};
				}
			}
			
			var formvalidation = [
				{'id':'name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null},
				{'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
				{'id':'category','name':'Category','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':null},
				{'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null}
			];
			
			var btn = document.getElementById('add');
				if(btn !== null)
				{
					var success = function(xhttp){
						if(JSON.parse(xhttp.responseText).success == '1')
						{
							//get();
							document.getElementById('ctcfm').reset();
						}
						else if(JOSN.parse(xhttp.responseText).ERROR !== undefined)
						{
							alert("Connection lost while connecting to Server");
						}
					};
					var fail = function(xhttp){
						alert(xhttp.responseText);
					};
					btn.addEventListener('click',function(){
						submit_form('ctcfm',formvalidation,'vsadc','/b2c/apies/product/category/add','POST',success,fail);
					});
				}
				
			(function(){
				get_cat();
			})();
		break;
		
		default:
		break;
	}
};