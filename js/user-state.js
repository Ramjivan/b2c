    xhr_call(
        'GET',
        'apies/session/BSZC',
        null,
        function(xhttp){
            if(xhttp.responseText.length > 0 )
            {
                var json = JSON.parse(xhttp.responseText);
                
                if(json.result)
                {
                    //categories
                    var tar = document.getElementById('32t3g05');
                    var tar2 = document.getElementById('32tfg05');
                    if(tar !== null && tar2 !== null)
                    {	
                        if(json.items.category.length > 0)
                        {
                            for(var i = 0 ; i < json.items.category.length ; i++)
                            {
                                tar.innerHTML += '<a href="mcat='+json.items.category[i].category_id+'">'+json.items.category[i].cat_name+'</a>';
                                tar2.innerHTML += '<a href="mcat='+json.items.category[i].category_id+'">'+json.items.category[i].cat_name+'</a>';
                            }
                        }
                    } 
                    //cateogries

                    //user-state-[session]
                    var drop_dwn = document.getElementById('B5thg2w');
                    if(drop_dwn !== null)
                    {
                        if(json.items.SESSION.logged_in == true)
                        {
                            drop_dwn.innerHTML += '<a href="/logout.php"><span>Logout</span></a>';
                            usr_img.setAttribute('src','/apies/'+json.items.SESSION.user.ppimage.img_dir+json.items.SESSION.user.ppimage.img_name);
                        }
                        else
                        {
                            drop_dwn.innerHTML += '<a href="/login.php"><span>Login</span></a>';
                            usr_img.src="/default-user.png";
                        }
                    }
                    //user-state-[session]

                    //cart
                    if(!json.items.cart.empty && c_itm_cnt !== undefined)
                    {
                        c_itm_cnt.style.display = "flex";
                        c_itm_cnt.innerHTML = json.items.cart.items.length;
                    }
                    else
                    {

                    }
                    //cart

                }
            }
        },
        function(xhttp){

        }   
    );