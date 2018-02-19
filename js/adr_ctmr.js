window.onload = function(){
	
	
	function d_q(args){
		var tar = args[2];
		var form = new FormData();
		form.set('cid',args[1]);
		tar.parentNode.parentNode.parentNode.parentNode.style.filter = 'blur(0.3px)';
		xhr_call(
			'POST',
			'apies/address/delete',
			form,
			function(xhttp){
				if(xhttp.responseText.length > 0)
				{
					var json = JSON.parse(xhttp.responseText);
					if(json.success)
					{
						tar.parentNode.parentNode.parentNode.parentNode.removeChild(tar.parentNode.parentNode.parentNode.parentNode);
					}
				}
			},
			function(xhttp){
				tar.parentNode.parentNode.style.filter = 'none';
			}
		);
	}
	
	
	function get(){
		xhr_call(
			'GET',
			'apies/address',
			null,
			function(xhttp){
				var json = JSON.parse(xhttp.responseText);
				if(json.result !== undefined && json.result > 0 && document.getElementById('addressrow') !== null){
					
					var tar = document.getElementById('addressrow');
					
					for(var i = 0 ; i < json.items.length ; i++)
					{
						var row = json.items[i];
						var app = '<div class="jk-address-tile-container col-2">';
						app += '<div class="jk-address-tile col-6">';
						app += '<div class="col-6">'+row.adt_fullname+'</div>';
						app += '<div class="col-6">'+row.adt_addressline1+'</div>';
						app += '<div class="col-6">'+row.adt_addressline2+'</div>';
						app += '<div class="col-6">'+row.adt_landmark+','+row.adt_city+','+row.adt_state+','+row.adt_mob+'</div>';
						app += '<div class="col-6">'+row.adt_type+'</div>';
						if(json.default_id == row.address_id)
						{
							app+= '<div class="col-6"><center><button class="btn btn-default btn-primary-color fa fa-trash" id="uj945e2'+i+'"></button></center></div>';
						}
						else
						{
							
							app+= '<div class="col-6"><center><button class="btn btn-default btn-primary-color fa fa-trash"></button> | <a class="btn btn-primary-color"><b>set as default</b></a></center></div>';
						}
						
						tar.innerHTML += app;
						
					}
					
					
					//putting delete 
					for(var i = 0 ; i < json.items.length ; i++)
					{
						if(document.getElementById('uj945e2'+i) !== null)
						{
							const salt = json.items[i].address_id;
							var del = document.getElementById('uj945e2'+i);
							del.onclick = function(){
								cb(d_q,salt,this);
							};
						}
					}
					//putting delete 
					
				}
			},
			function(xhttp){
				
			}
		);
	}
	
	
	get();
};