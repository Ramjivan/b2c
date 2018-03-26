window.onload = function(){
    //month picker
    for(m = 1; m <= 12; m++) {
        var optn = document.createElement("OPTION");
        optn.text = m;
        // server side month start from one
        optn.value = (m);
    
        document.getElementById('monthPicker').options.add(optn);
    }
    //year picker
    for(y = (new Date()).getFullYear(); y <= 2040; y++) {
            var optn = document.createElement("OPTION");
            optn.text = y;
            optn.value = y;
            
            document.getElementById('yearPicker').options.add(optn);
    }
    //net banking picker
    var banks = JSON.parse('["SBI", "ICICI"]');
    for (var i = 0; i < banks.length; i++) {
        var counter = banks[i];
    }
    //accordian
    //initially hide all options
    $('.pay-grp').hide();
    $('#cardP').change(function() {
        if(this.checked) {
            $('.pay-grp').hide();
            $('#card-gp').show();
        }
    });
    $('#net-bk').change(function() {
        if(this.checked) {
            $('.pay-grp').hide();
            $('#nb-gp').show();
        }
    });
    $('#upi-rd').change(function() {
        if(this.checked) {
            $('.pay-grp').hide();
            $('#upi-gp').show();
        }
    });
    $('#cod').change(function() {
        if(this.checked) {
            $('.pay-grp').hide();                
        }
    });


    //setting up map for payment option
    xhr_call(
        'GET',
        '/apies/payment/c',
        null,
        function(xhttp){
            if(xhttp.responseText.length > 0)
            {
                var json = JSON.parse(xhttp.responseText);
                
                if(json.result)
                {
                    var app = "";
                    if(json.op)
                    {            
                        app = '<div class="jk-checkbox">\
                            <input id="i1" name="payb" value="101" type="checkbox">\
                            <label for="i1">Use your <span class="fa fa-rupee"></span> '+json.wallet.balance+' Pay Balance.</label>\
                        </div>';
                    }
                    else
                    {
                        app = '<div class="jk-radio">\
                            <input id="i1" name="pay-method" value="101" type="radio">\
                            <label for="i1">Pay Balance.</label>\
                        </div>';
                    }
                    
                    pybal_co.innerHTML += app; 

                }
            }
        },
        function(xhttp){

        }
    );
    //setting up map for payment option
};