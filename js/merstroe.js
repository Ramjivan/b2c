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
            var formvalidation = [
                {'id':'name','name':'Name','regex':/^([a-zA-Z\s]+)$/,'length':null,'min_length':5,'max_length':null},
                {'id':'logo','name':'logo','regex':null,'length':null,'min_length':1,'max_length':null},
                {'id':'fblnk','name':'Facebook Link','regex':/^([\w]+)\.facebook\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
                {'id':'twlnk','name':'Twitter Link','regex':/^([\w]+)\.twitter\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
                {'id':'golnk','name':'Google+ Link','regex':/^([\w]+)\.google\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
                {'id':'inlnk','name':'Instagram Link','regex':/^([\w]+)\.instagram\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
                {'id':'ytlnk','name':'Youtube Link','regex':/^([\w]+)\.youtube\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
                {'id':'wpblnk','name':'Whatsapp Link','regex':/^[0-9]{10}$/,'length':null,'min_length':9,'max_length':null},
                {'id':'st_phone','name':'Contact Number','regex':/^[0-9]{10}$/,'length':10,'min_length':null,'max_length':null},
                {'id':'st_mail','name':'Mail Address','regex':/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,'length':null,'min_length':9,'max_length':255},
                {'id':'st_thm_spinner','name':'Theme','regex':/^([0-9]+)$/,'length':null,'min_length':1,'max_length':null},
                {'id':'adt_n','name':'House No. / House Name / Customer Name','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':4,'max_length':16},
                {'id':'adt_m','name':'Mobile','regex':/^[0-9]*$/,'length':10,'min_length':null,'max_length':null},
                {'id':'adt_p','name':'Pincode','regex':/^[0-9]*$/,'length':6,'min_length':null,'max_length':null},
                {'id':'adt_al1','name':'Address Line 1','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':null,'max_length':null},
                {'id':'adt_al2','name':'Address Line 2','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':null,'max_length':null},
                {'id':'adt_l','name':'Landmark','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':8,'max_length':64},
                {'id':'adt_s','name':'State','regex':/^([A-Za-z]*)$/,'length':null,'min_length':3,'max_length':128},
                {'id':'adt_c','name':'City','regex':/^([A-Za-z]*)$/,'length':null,'min_length':3,'max_length':128},
                {'id':'adt_t','name':'Type','regex':/^[0-9]*$/,'length':1,'min_length':null,'max_length':null}
            ];
            var btn = document.getElementById('st_s_btn');

            if(json !== null && json.result)
            {
                if(!json.store.notOpen)
                {
                    
                    if(btn !== null)
                    {
                        var success = function(xhttp){
                            if(JSON.parse(xhttp.responseText).success == '1')
                            {

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
                            submit_form('stafrm',formvalidation,'vsap','/apies/store/edit','POST',success,fail);
                        });
                    }
                }
                else
                {

                    if(btn !== null)
                    {
                        var success = function(xhttp){
                            if(JSON.parse(xhttp.responseText).success == '1')
                            {
                                get();
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
                            submit_form('stafrm',formvalidation,'vsap','/apies/store/merchant/create','POST',success,fail);
                        });
                    }
                }
            }
        },
        function(xhttp){
            
        }
    );
  
}
get();
var formvalidation = [
    {'id':'name','name':'Name','regex':/^[a-zA-Z0-9 ]+$/,'length':null,'min_length':9,'max_length':null},
    {'id':'logo','name':'logo','regex':null,'length':null,'min_length':1,'max_length':null},
    {'id':'fblnk','name':'Facebook Link','regex':/^([\w]+)\.facebook\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
    {'id':'twlnk','name':'Twitter Link','regex':/^([\w]+)\.twitter\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
    {'id':'golnk','name':'Google+ Link','regex':/^([\w]+)\.google\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
    {'id':'inlnk','name':'Instagram Link','regex':/^([\w]+)\.instagram\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
    {'id':'ytlnk','name':'Youtube Link','regex':/^([\w]+)\.youtube\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null},
    {'id':'wpblnk','name':'Whatsapp Link','regex':/^[0-9]{10}$/,'length':null,'min_length':9,'max_length':null}
];
var btn = document.getElementById('st_s_btn ');
if(btn !== null)
{
    var success = function(xhttp){
        if(JSON.parse(xhttp.responseText).success == '1')
        {
            get();
            document.getElementById('').reset();
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
        submit_form('pctafm',formvalidation,'vsap','/apies/store/add','POST',success,fail);
    });
}

};