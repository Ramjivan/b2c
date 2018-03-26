window.load = function(){
    xhr_call(
        'GET',
        'apies/wallet/txns',
        null,
        function(xhttp){
            if(xhttp.responseText.length > 0 )
            {
                var json = JSON.parse(xhttp.responseText);
                
                if(json.result)
                {
                    if(txn_cn !== undefined)
                    {
                        var app = '<div class="tc-card col-3 center">\
				            <div class="row">\
                                <div class="col-2"><h4>#txn-c6246fbc3c</h4></div>\
                                <div class="col-2"><span class="amt"><span class="fa fa-inr"></span>200</span></div>\
                                <div class="col-2"><span class="tm"><span class="fa fa-calendar-o"></span>2018/3/6</span></div>\
                            </div>\
                        </div>';
                        
                    }
                }
            }
        },
        function(xhttp){

        }   
    );
};