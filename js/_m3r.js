window.onload = function(){
	var loc_arr = window.location.toString().split('/');
	var length = loc_arr.length;
	if(/product.php/.test(loc_arr[length-1]))
	{
		//global vars 
		var spcount = 1;
		//global vars
		
		
		var formvalidation = [
			{'id':'name','name':'Email Address','regex':/^[a-zA-Z0-9 ]+$/,'length':null,'min_length':9,'max_length':null},
			{'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
			{'id':'price','name':'Price','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
			{'id':'stock','name':'Stock','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
			{'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null},
			{'id':'hlgt1','name':'Hightlight1','regex':null,'length':null,'min_length':5,'max_length':null},
			{'id':'sp_name1','name':'Spec Name 1','regex':null,'length':null,'min_length':5,'max_length':null},
			{'id':'sp_value1','name':'Spec Value 1','regex':null,'length':null,'min_length':5,'max_length':null}
		];
		
		var edit_formvalidation = [
			{'id':'e_name','name':'Email Address','regex':/^[a-zA-Z0-9 ]+$/,'length':null,'min_length':9,'max_length':null},
			{'id':'e_description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
			{'id':'e_price','name':'Price','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
			{'id':'e_stock','name':'Stock','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6},
		];
		
		function get()
		{
			var method = "GET";
			var url = "/apies/product";
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
										<td>'+json_response.items[i].p_name+'</td>\
										<td>'+json_response.items[i].p_description+'</td>\
										<td>'+json_response.items[i].p_price+'</td>\
										<td>'+json_response.items[i].p_stock+'</td>\
										<td>'+json_response.items[i].p_category+'</td>\
										<td><a href="/b2c/apies/'+json_response.items[i].images[0].img_dir+json_response.items[i].images[0].img_name+'">'+json_response.items[i].images[0].img_dir+json_response.items[i].images[0].img_name+'</a></td>\
										<td><span id="ed'+json_response.items[i].product_id+'" class="fa fa-pencil"></span></td>\
									   </tr>';
							
							tab.innerHTML += row;
							
						}
						for(var i = 0 ; i < json_response.items.length ; i++)
						{
							const str = 'ed'+json_response.items[i].product_id; 
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
								
								var elements = ['e_name','e_description','e_price','e_stock'];
								
								var parent =  document.getElementById(str).parentElement.parentElement;
								for(var j = 0 ; j < elements.length ; j++)
								{
									if(document.getElementById(elements[j]) !== null)
									{
										document.getElementById(elements[j]).value = parent.getElementsByTagName('td')[j].innerHTML;
									}
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
			
			while(specs.length >= index)
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
				
				if(i > 1)
				{
					span.setAttribute('class','fa fa-trash');
					const p = i-1;
					span.onclick = function(){
						rng(p);
					};
					h3.appendChild(span);
				}
				
				div.appendChild(h3);
				
				var sp_name = document.createElement('input');
				sp_name.setAttribute('id','sp_name'+i);
				sp_name.setAttribute('onchange','validate({\'id\':\'sp_name'+i+'\',\'name\':\'Spec Name '+i+'\',\'regex\':null,\'length\':null,\'min_length\':5,\'max_length\':null})');
				sp_name.setAttribute('Placeholder','Spec Name');
				sp_name.setAttribute('name','sp_name'+i);
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
				var specs = document.getElementsByClassName('spec');

				//truncate
				while(spcount > count)
				{
					specs[specs.length-1].parentNode.removeChild(specs[specs.length-1]);
					spcount--;
				}
				
			}
		}
		
	var _cat_sel_count = 1;
	
	function nescat(index,name)
	{
		var spinner = document.getElementById('31t'+index);
		
		if(spinner !== null)
		{
			while(index < _cat_sel_count )
			{
				if(document.getElementById('31t'+index) !== null)
				{
					var jk_radio_parent = document.getElementById('3trd'+_cat_sel_count).parentNode;
					var clearfix_div = jk_radio_parent.parentNode;
					
					clearfix_div.parentNode.removeChild(clearfix_div);

				}
				_cat_sel_count--;
			}
			xhr_call(
				'GET',
				'/apies/index/subcategory/'+spinner.value,
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
								
								var div = document.createElement('div');
								div.setAttribute("class","clearfix");
								
								var select = document.createElement('select');
								select.setAttribute('id','31t'+(index+1));
								select.style.width = 'auto';
								select.style.margin = '0';
								
								var fncrad = function(tar){
									var selects = document.querySelectorAll('[id*="31t"]');
									if(selects !== null)
									{				
									selects.forEach(function(item){
										item.removeAttribute('name');
									});
										tar.parentNode.getElementsByTagName('select')[0].setAttribute('name','parent_id');
									}
								};
								
								var radio = document.createElement('input');
								radio.setAttribute('type','radio');
								radio.setAttribute('id','3trd'+(index+1));
								radio.setAttribute('name','3trd');
								radio.onchange = function(){
									fncrad(this);
								};
								
								var radiojk = document.createElement('div');
								radiojk.setAttribute('class','jk-radio');
								
								var label = document.createElement('label');
								label.setAttribute('for','3trd'+(index+1));
								label.appendChild(select);
								
								radiojk.appendChild(radio);
								radiojk.appendChild(label);
								
								for(var i =0 ; i < json.items.length ; i++)
								{
									var option = document.createElement('option');
									option.setAttribute('value',json.items[i].category_id);
									option.appendChild(document.createTextNode(json.items[i].cat_name));
									select.appendChild(option);
								}
								
								div.appendChild(radiojk);
								document.getElementById('cat_panel').appendChild(div);
								_cat_sel_count+=1;
								select.onchange = function(){nescat(index+1,'p_category')};
								
								//document.getElementById('31t'+(_cat_sel_count-1)).removeAttribute('name');
								select.onchange();
							
							}
							else
							{
								//document.getElementById('31t'+_cat_sel_count).setAttribute('name',name);
							}
						}
					}							
				}
			);
		}
	}
		/**ajax call for cateegory spinner for parent category selection*/
			xhr_call(
				'GET',
				'/apies/index/category',
				null,
				function(xhttp){
				var tar = document.getElementById('31t1');
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
							tar.onchange=function(){nescat(1,'p_category')};
							tar.onchange();
						}
					}
				}
				},
				function(xhttp){
				alert('ERROR');
				}
			);
		
		
		
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
					else if(JSON.parse(xhttp.responseText).ERROR !== undefined)
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
	}
	else if(/qna.php/.test(loc_arr[length-1]))
	{
	
		var qne_vld = [
			{'id':'e_answer','name':'answer','regex':null,'length':null,'min_length':9,'max_length':255}
		];
		
		var qna_vld = [
			{'id':'answer','name':'answer','regex':null,'length':null,'min_length':9,'max_length':255}
		];
		
		function get_qna()
		{
			var method = "GET";
			var url = "/apies/qna/merchant";
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
										<td>'+json_response.items[i].qna_question+'</td>\
										<td>'+(json_response.items[i].qna_answer == null ? 'Not Answered Yet.' : json_response.items[i].qna_answer)+'</td>\
										<td>'+json_response.items[i].product_id+'</td>\
										<td>'+json_response.items[i].qna_added+'</td>\
										<td>'+(json_response.items[i].qna_closed == '0000-00-00 00:00:00' ? '<center>-</center>' : json_response.items[i].qna_closed)+'</td>\
										<td>'+(json_response.items[i].qna_answer !== null ?'<span id="ed'+json_response.items[i].qna_id+'" class="fa fa-pencil"></span>':'')+(json_response.items[i].qna_answer == null ?'<span id="ad'+json_response.items[i].qna_id+'" class="fa fa-plus"></span>':"")+'</td>\
									   </tr>';
							
							tab.innerHTML += row;
							
						}
						for(var i = 0 ; i < json_response.items.length ; i++)
						{
							
							
							
							const edit = 'ed'+json_response.items[i].qna_id; 
							const add = 'ad'+json_response.items[i].qna_id; 
							const id = json_response.items[i].qna_id;
							const edit_btn = document.getElementById(edit);
							
							
							
							
							// adding on click listeners on edit btn of dialog 
							if(edit_btn !== null)
							{
								edit_btn.addEventListener('click',function(){
									document.getElementById('dlg1').style.display = 'block';
									document.getElementsByClassName('blurdfg')[0].className += ' active'; 
									document.getElementById('qe5d_3fid').value = id;
									
									
									var btn = document.getElementById('ed');
									
									if(btn !== null)
									{
										var success = function(xhttp){
											if(JSON.parse(xhttp.responseText).success == '1')
											{
												get_qna();
												document.getElementById('pctefm').reset();
												document.getElementById('dlg1').style.display = 'none';
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
											submit_form('qntefm',qne_vld,'valsum1','/b2c/apies/answer/edit','POST',success,fail);
										});
									}
									
									var elements = ['ques_e_p','e_answer'];
									
									var parent =  document.getElementById(edit).parentElement.parentElement;
									for(var j = 0 ; j < elements.length ; j++)
									{
										if(document.getElementById(elements[j]) !== null)
										{
											document.getElementById(elements[j]).value = parent.getElementsByTagName('td')[j].innerHTML;
											document.getElementById(elements[j]).innerHTML = parent.getElementsByTagName('td')[j].innerHTML;
										}
									}
									
								});
							}
							
							
							const add_btn = document.getElementById(add);
							// adding on click listeners on add btn of dialog 
							if(add_btn !== null)
							{
								add_btn.addEventListener('click',function(){
									document.getElementById('dlg2').style.display = 'block';
									document.getElementsByClassName('blurdfg')[0].className += ' active'; 
									document.getElementById('qa5d_3fid').value += id;
									
									
									var btn = document.getElementById('ad');
									
									if(btn !== null)
									{
										var success = function(xhttp){
											if(JSON.parse(xhttp.responseText).success == '1')
											{
												get_qna();
												document.getElementById('qnatefm').reset();
												document.getElementById('dlg2').style.display = 'none';
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
											submit_form('qnatefm',qna_vld,'valsum2','/b2c/apies/answer/add','POST',success,fail);
										});
									}
									
									var elements = ['ques_a_p','answer'];
									
									var parent =  document.getElementById(add).parentElement.parentElement;
									for(var j = 0 ; j < elements.length ; j++)
									{
										if(document.getElementById(elements[j]) !== null)
										{
											document.getElementById(elements[j]).value = parent.getElementsByTagName('td')[j].innerHTML;
											document.getElementById(elements[j]).innerHTML = parent.getElementsByTagName('td')[j].innerHTML;
										}
									}
									
								});
							}
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
		(function(){
			get_qna();
		})();
	
	}
	
	else if(/category.php/.test(loc_arr[length-1]))
	
	{
		
		var add_formvalidation = [
			{'id':'name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':1,'max_length':null},
			{'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
			{'id':'metakey','name':'metakey','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':null,'max_length':255},
			{'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null}
		];
		
		
		var cat_edit_formvalidation = [
			{'id':'e_name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null},
			{'id':'e_description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
			{'id':'e_metakey','name':'metakey','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':null,'max_length':255}
		];
		
		function get_cat()
		{
			var method = "GET";
			var url = "/apies/product/category/merchant";
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
					if(json_response.result == '1')
					{
						for(var i= 0 ; i < json_response.items.length ; i++)
						{
							var row = '<tr>\
										<td>'+json_response.items[i].cat_name+'</td>\
										<td>'+json_response.items[i].cat_description+'</td>\
										<td>'+json_response.items[i].parent_name+'</td>\
										<td><span id="ed'+json_response.items[i].category_id+'" class="fa fa-pencil"></span></td>\
									   </tr>';
							
							tab.innerHTML += row;
						}
						
						for(var i = 0 ; i < json_response.items.length ; i++)
						{
							const str = 'ed'+json_response.items[i].category_id; 
							const id = json_response.items[i].category_id;
							document.getElementById(str).addEventListener('click',function(){
								document.getElementsByClassName('dialog')[0].style.display = 'block';
								document.getElementsByClassName('blurdfg')[0].className += ' active'; 
								document.getElementById('ce5d_3fid').value = id;
								
								var elements = ['e_name','e_description'];
								
								var parent =  document.getElementById(str).parentElement.parentElement;
								for(var j = 0 ; j < elements.length ; j++)
								{
									if(document.getElementById(elements[j]) !== null)
									{
										document.getElementById(elements[j]).value = parent.getElementsByTagName('td')[j].innerHTML;
									}
								}
								
								
								//product form action
								var btn = document.getElementById('ed');
								
								if(btn !== null)
								{
									var success = function(xhttp){
										if(JSON.parse(xhttp.responseText).success == '1')
										{
											get_cat();
											document.getElementById('ctefm').reset();
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
										submit_form('ctefm',cat_edit_formvalidation,'vsedc','/b2c/apies/product/category/edit','POST',success,fail);
									});
								}
								
							});
						}
					}
					else
					{
						tab.innerHTML += '<tr><td colspan="4"><center>No Categories Found</center></td></tr>';
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
			{'id':'name','name':'Name','regex':/[a-zA-Z ]+/,'length':null,'min_length':9,'max_length':null},
			{'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255},
			{'id':'category','name':'Category','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':null},
			{'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null}
		];
		
		
		function spinner_cat_fill()
		{
			
			var method = "GET";
			var url = "/apies/index/category";
			var formData = null;
			
			var success = function(xhttp){
				if(xhttp.responseText.length > 0)
				{
					var json = JSON.parse(xhttp.responseText);
					if(json.result !== undefined && json.result > 0)
					{
						var cat = document.getElementById('category');
						if(cat !== null && xhttp.response.items !== null)
						{
							for(var i = 0 ;  i < json.items.length ; i++)
							{
								var option = document.createElement('option');
								option.setAttribute('value',json.items[i].category_id);
								option.appendChild(document.createTextNode(json.items[i].cat_name));
								cat.appendChild(option);
							}
						}
					}
					else if(!xhttp.responseText.result)
					{
						alert('Nothing Found');
					}
				}
			};
			
			
			var fail = function(xhttp){
				alert("Sorry Couldn't establish the connection..");
			};
			
			xhr_call(
				method,
				url,
				formData,
				success,
				fail
			);
		}
		
		var btn = document.getElementById('add');
			if(btn !== null)
			{
				var success = function(xhttp){
					if(JSON.parse(xhttp.responseText).success == '1')
					{
						get_cat();
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
					submit_form('ctcfm',add_formvalidation,'vsadc','/b2c/apies/product/category/add','POST',success,fail);
				});
			}
		function nescat(index,name)
		{
			var spinner = document.getElementById('31t'+index);
			
			if(spinner !== null)
			{
				while(index < _cat_sel_count )
				{
					if(document.getElementById('31t'+index) !== null)
					{
						var jk_radio_parent = document.getElementById('3trd'+_cat_sel_count).parentNode;
						var clearfix_div = jk_radio_parent.parentNode;
					
						clearfix_div.parentNode.removeChild(clearfix_div);

					}
					_cat_sel_count--;
				}
				xhr_call(
					'GET',
					'/apies/index/subcategory/'+spinner.value,
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
									
									var div = document.createElement('div');
									div.setAttribute("class","clearfix");
									
									var select = document.createElement('select');
									select.setAttribute('id','31t'+(index+1));
									select.style.width = 'auto';
									select.style.margin = '0';
									
									var fncrad = function(tar){
										var selects = document.querySelectorAll('[id*="31t"]');
										if(selects !== null)
										{				
										selects.forEach(function(item){
											item.removeAttribute('name');
										});
											tar.parentNode.getElementsByTagName('select')[0].setAttribute('name','parent_id');
										}
									};
									
									var radio = document.createElement('input');
									radio.setAttribute('type','radio');
									radio.setAttribute('id','3trd'+(index+1));
									radio.setAttribute('name','3trd');
									radio.onchange = function(){
										fncrad(this);
									};
									
									var radiojk = document.createElement('div');
									radiojk.setAttribute('class','jk-radio');
									
									var label = document.createElement('label');
									label.setAttribute('for','3trd'+(index+1));
									label.appendChild(select);
									
									radiojk.appendChild(radio);
									radiojk.appendChild(label);
									
									for(var i =0 ; i < json.items.length ; i++)
									{
										var option = document.createElement('option');
										option.setAttribute('value',json.items[i].category_id);
										option.appendChild(document.createTextNode(json.items[i].cat_name));
										select.appendChild(option);
									}
									
									div.appendChild(radiojk);
									document.getElementById('cat_panel').appendChild(div);
									_cat_sel_count+=1;
									select.onchange = function(){nescat(index+1,'parent_id')};
									
									//document.getElementById('31t'+(_cat_sel_count-1)).removeAttribute('name');
									select.onchange();
								
								}
								else
								{
									//document.getElementById('31t'+_cat_sel_count).setAttribute('name',name);
								}
							}
						}							
					}
				);
			}
		}
		var _cat_sel_count = 1;
			
		(function(){
			get_cat();
			spinner_cat_fill();
			xhr_call(
				'GET',
				'/apies/index/category',
				null,
				function(xhttp){
				var tar = document.getElementById('31t1');
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
							tar.onchange=function(){nescat(1,'parent_id')};
							tar.onchange();
						}
					}
				}
				},
				function(xhttp){
				alert('ERROR');
				}
			);
		})();
	}
	
	else if(/Orders.php/.test(loc_arr[length-1]))
	{
		
		function st(i)
		{
			if(i == 1)
			{
				return "pending";
			}
			else if(i == 2)
			{
				return "confirmed";
			}
			else if(i == 3)
			{
				return "shipped";
			}
			else if(i == 4)
			{
				return "delivered";
			}
		}
		
		function pm(i)
		{
			if(i == 1)
			{
				return "Pay Balance";
			}
			else if(i == 2)
			{
				return "Credit Card";
			}
			else if(i == 3)
			{
				return "Paytm";
			}
			else if(i == 4)
			{
				return "COD";
			}
		}
		
		function get()
		{		
			xhr_call(
				'GET',
				'/apies/order/time/28',
				null,
				function(xhttp){					
					
					var response = xhttp.responseText;
					var json = JSON.parse(response);
					var tar = document.getElementById('tbdy');
					
					if(json.result)
					{
						var append = "";
						
						json.items.forEach(function(item){
							
							
							var append = '<tr>\
											<td>'+item.ord_date_time+'</td>\
											<td>'+st(item.ord_status)+'</td>\
											<td>'+item.pl_count+'</td>\
											<td>'+pm(item.ord_payment_method)+'</thd>\
											<td>'+(item.ord_invoice_id !== null ? '<a href="/ivcx?'+item.ord_invoice_id+'">invoice</a>' : 'No Invoice')+'</td>\
											<td><a class="btn btn-primary-color text-center" href="order/'+item.ord_pl_id+'"><i class="fa fa-arrow-right"></i></a></td>\
										</tr>';	
							tar.innerHTML += append;
						});
					}
					
				},
				function(xhttp){
					
				}
			);
	
		}
		(function(){get();})();
	}
	
	else if(/order([\w]*)/.test(loc_arr[length-2]+loc_arr[length-1]))
	{
		var id = loc_arr[length-1];
		
		function get(id)
		{
			xhr_call(
				'GET',
				'/apies/order/'+id,
				null,
				function(xhttp){
					
					var response = xhttp.responseText;
					var json = JSON.parse(response);
					
					var tar = document.getElementById('ordsucont');
					
					if(tar !== null && json.result)
					{
						var h3 = document.createElement('h3');
						h3.appendChild(document.createTextNode('Order #'+id));
						
						tar.appendChild(h3);	
						
						//extra details
						var extra_details = document.createElement('div');
						extra_details.setAttribute('class','clearfix');
						//order date
						var date = document.createElement('div');
						date.setAttribute('class','col-2');
						date.style.fontSize = "12px";
						date.appendChild(document.createTextNode('Ordered on : ' +json.items.orderDetails.ord_date_time));
						//order date
						
						//orderTimeLine
						var otdiv = document.createElement('div');
						otdiv.style.fontSize = "14px";
						otdiv.setAttribute('class','float-right col-1');
						if(json.items.orderDetails.ord_status == 1)
						{
							var aot = document.createElement('a');
							aot.setAttribute('href',"#");
							aot.setAttribute('id',"aot");
							aot.appendChild(document.createTextNode('mark as confirmed'));
							otdiv.appendChild(aot);
						}
						else
						{
							var aot = document.createElement('a');
							aot.appendChild(document.createTextNode('order confirmed'));
							otdiv.appendChild(aot);
						}
						//orderTimeLine
						extra_details.appendChild(date);
						extra_details.appendChild(otdiv);
						tar.appendChild(extra_details);
						//extra_details
						
						var div = document.createElement('div');
						div.setAttribute('class','row');
						
						var address_div = document.createElement('div');
						address_div.setAttribute('class','col-2 clearfix');
						
						var payment_div = document.createElement('div');
						payment_div.setAttribute('class','col-1');
						
						var summary_div = document.createElement('div');
						summary_div.setAttribute('class','col-3');
						
						
						//address tile
						var row = json.items.address;
						
						address_div.innerHTML = '<h4>Address</h4>\
							<div class="col-6">\
							<div class="col-6">'+row.adt_fullname+'</div>\
							<div class="col-6">'+row.adt_addressline1+'</div>\
							<div class="col-6">'+row.adt_addressline2+'</div>\
							<div class="col-6">'+row.adt_landmark+','+row.adt_city+','+row.adt_state+','+row.adt_mob+'</div>\
							<div class="col-6">'+(row.adt_type == 1 ? "Type : Home / residential" : "Type : Office / Industrial")+'</div>\
							<div class="clearfix"></div>';
						
								
						tar.appendChild(address_div);
						//address tile
						
						//payment_mode_tile
							
						payment_div.innerHTML = '<h4>Payment Method</h4><div>'+pm(json.items.orderDetails.ord_payment_method)+'</div>';
						tar.appendChild(payment_div);
						
						//payment_mode_tile
						
						//Order Summary
						
						summary_div.innerHTML = '<h4>Order Summary</h4>';
						
						var table = document.createElement('table');
						table.style.width = "100%";
						
						var theadtr = document.createElement('tr');
						theadtr.innerHTML = '<th></th><th></th>';
						table.appendChild(theadtr);
						
						var total = 0; 
						
						json.items.productDetails.forEach(function(item){
							total += parseInt(item.total_price);
						});
						
						table.innerHTML += '<tr><td>Item Total</td><td class="float-right">'+total+'</td></tr>';
						
						table.innerHTML += '<tr><td><b>Grand Total</b></td><td class="float-right"><b>'+total+'</b></td></tr>';
						
						summary_div.appendChild(table);
						
						tar.appendChild(summary_div);
						
						//Order Summary
						
						
						var product_container = document.createElement('div');
						product_container.setAttribute('class','col-6');
						product_container.style.marginTop = '20px'; 
						
						json.items.productDetails.forEach(function(item){
							var app = '<div class="ordItem col-6">\
									<div class="col-6">\
										<b><a href="/b2c/product?'+item.product_id+'">'+item.p_name+'</a></b>\
									</div>\
									<div class="col-3">\
										Qty : <b>'+item.qty+'</b>\
									</div>\
									<div class="col-3">\
										Total : <b>'+item.total_price+'</b>\
									</div>\
								</div>';
								
							product_container.innerHTML += app;
						});
						
						tar.appendChild(product_container);
					}
					
				},
				function(xhttp){
					
				}
			);
		}
		
		function pm(i)
		{
			if(i == 1)
			{
				return "Pay Balance";
			}
			else if(i == 2)
			{
				return "Credit Card";
			}
			else if(i == 3)
			{
				return "Paytm";
			}
			else if(i == 4)
			{
				return "COD";
			}
		}
		
		
		get(id);
	}
};
