window.onload = function(){
	
	var wallet;

    function gettxns(){
		xhr_call(
        'GET',
        '/apies/wallet/txns',
        null,
        function(xhttp){
            if(xhttp.responseText.length > 0 )
            {
                var json = JSON.parse(xhttp.responseText);
                
                if(json.result && json.transactions.length > 0)
                {
                    if(txn_cn !== undefined)
                    {
                        json.transactions.forEach(function(item){

                            var app = '<div class="tc-card col-3">\
                                            <a href="#">\
                                            <div class="row">\
                                                <div class="col-1"><span class="amt">#txn-'+item.txn_id+'</span></div>\
                                                <div class="col-2"><span class="amt"><span class="fa fa-inr"></span>'+txn_scenerio(item.txn_credit_wallet_id,item.txn_debit_wallet_id,item.txn_amount)+'</span></div>\
                                                <div class="col-2"><span class="tm"><span class="fa fa-calendar-o"></span>'+item.txn_date_time+'</span></div>\
                                                <div class="col-1"><span class="amt"><b>'+pm(item.txn_desc)+'</b></span></div>\
                                            </div>\
                                            </a>\
                                        </div>';

                            txn_cn.innerHTML += app;
                        });
                    }
                }
            }
        },
        function(xhttp){

        }   
	);
}
    function pm(i)
		{
			if(i == 101 )
			{
				return "Pay Balance";
			}
			else if(i == 102)
			{
				return "UPI";
			}
			else if(i == 103)
			{
				return "Credit/Debit Card";
			}
			else if(i == 104)
			{
				return "Net Banking";
			}
			else if(i == 105)
			{
				return "Cash On Delivery(COD)";
            }
            return "Pay Balance";
        }
        
		function txn_scenerio(credit,debit,amount)
		{
			if(credit == wallet.wallet_id)
			{
				return amount;
			}
			else if(debit == wallet.wallet_id)
			{
				return ' -'+amount;
			}
		}

        //send money 
        //onclick listener for sendMoney btn 
			document.getElementById('w_sM0').onclick = function(){
				document.getElementsByClassName('dialog')[0].style.display = 'block';
				document.getElementsByClassName('blurdfg')[0].className += ' active'; 
			};
			//onclick listener for sendMoney 
			
			function sd_mo()
			{
				var fval = [
					{'id':'mob','name':'Mobile Number','regex':/^[0-9]+$/,'length':10,'min_length':null,'max_length':null},
					{'id':'amt','name':'Amount','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':5}
				];
				
				var s = function(xhttp){
					var response = xhttp.responseText;
					var json = JSON.parse(response);
					
					if(json.success)
					{						
						//closing dialog 
						document.getElementById('wdlg1a').style.display='none';
						document.getElementsByClassName('blurdfg')[0].style.display='none';
						document.getElementById('actefm').reset();
						//closing dialog
						
						document.getElementsByClassName('aS')[0].style.display='block';
					}
					else if(json.ERROR !== undefined)
					{
						alert(json.ERROR);
					}
				
				};
				var f = function(xhttp){
					alert('Error While etablishing a connection to server');
				};
				
				submit_form('actefm',fval,'valsum','apies/wallet/transfer','POST',s,f);
			}
			
			function g()
			{
				xhr_call(
					'GET',
					'apies/wallet',
					null,
					function(xhttp){
						var res = xhttp.responseText;
						var json = JSON.parse(res);
						if(json !== null)
						{								
							var tar = document.getElementById("sn_2-3b_ral_4w");
							
							if(tar !== null)
							{
								tar.innerHTML += json.wallet.balance;
								wallet = json.wallet;
								gettxns();
							}
						}
					
					},
					function(xhttp){
						
					}
				);
			}
			
			
			//set onclick listener on form submit
				document.getElementById('tlsambtn').onclick = function(){
					cb(sd_mo);
				};
			//set onclick listener on form submit
			g();
        //send money 
};