window.onload = function(){
	
function get(){
		
    xhr_call(
        'GET',
        '/apies/store/merchant/index',
        null,
        function(xhttp){
            var res = xhttp.responseText ;
            var json = JSON.parse(res);
            var target = document.getElementById('main-str-cnr');
            
            if(json !== null && json.result)
            {
                if(!json.store.notOpen){

                }
                else
                {
                    alert('open store now..');
                }
            }
        },
        function(xhttp){
            
        }
    );
  
}
get();

};