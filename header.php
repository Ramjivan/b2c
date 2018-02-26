<div class="row">
		<!--Mobile Navbar-->
		<div class="col-1" id="sidebar">
			<nav class="navbar side-nav">
				<div class="nav-header">
					<div>
					B2C
						<div class="return-btn right">
							&times;
						</div>
					</div>
					
				</div>
				
				
				<div class="nav-item"><span class="fa fa-1x fa-search"></span><a href="#">Explore</a></div>
				<div class="nav-item dropbtn">
					<span class="fa fa-sitemap"></span>
					<a>Categories</a>
					<i class="fa fa-caret-down"></i>
					<div class="dropdown-content" id="32tfg05">
					</div>
				</div>
				
			</nav>
		</div>
		<!--Desktop Navbar-->
        <div class="col-6">
		<div class="header">	
            <div class="nav-item"><a class="opn-btn" href="javascript:void(0);"><div class="dash"></div><div class="dash"></div><div class="dash"></div></a></div>
            <nav class="navbar top-nav">
               
              
				<div class="nav-item dropbtn">
						<span class="fa fa-sitemap"></span>
						<a>Categories</a>
						<i class="fa fa-caret-down"></i>
						<div class="dropdown-content" id="32t3g05">
						</div>
				</div>
                
                <div class="nav-item">
					<!--For desktop-->
					<form action="" class="nav-s-bar">
						<div class="form-group" style="background-color:white;">
							<input type="text" class="jk-textbox wi-right nav-sb">
							<span onclick="submit" class="fa fa-search jk-input-ico-right nav-bb"></span>
						</div>
						
					</form>
					
				</div>
                
			</nav>
			<!--for mobile-->
			<div id="sb-search" class="sb-search navbar float-right" >
						<form>
							<input class="sb-search-input " onkeyup="buttonUp();" placeholder="Enter your search term..." onblur="monkey();" type="search" value="" name="search" id="search">
							<input class="sb-search-submit" type="submit"  value="">
							<span class="sb-icon-search"><i class="fa fa-1dot5x fa-search" style="margin-top: -130px;"></i></span>
						</form>
						
					</div>
			<nav class="navbar float-right">
				
				<div class="nav-item"><a href="/b2c"><span class="fa fa-1dot5x fa-user-circle"></span>&nbsp;</a></div>
				<div class="nav-item"><a href="cart"><span class="fa fa-1dot5x fa-shopping-cart"></span></a></div>
				
			</nav>
		</div>
    </div>
</div>
<div class="blurdfg">
</div>
	</div>
	<div class="blurdfg">
	</div>

	<script>
	function buttonUp(){
		var valux = $('.sb-search-input').val(); 
			valux = $.trim(valux).length;
			if(valux !== 0){
				$('.sb-search-submit').css('z-index','99');
			} else{
				$('.sb-search-input').val(''); 
				$('.sb-search-submit').css('z-index','-999');
			}
	}
	
	$(document).ready(function(){
		var submitIcon = $('.sb-icon-search');
		var submitInput = $('.sb-search-input');
		var searchBox = $('.sb-search');
		var isOpen = false;
		
		$(document).mouseup(function(){
			if(isOpen == true){
			submitInput.val('');
			$('.sb-search-submit').css('z-index','-999');
			submitIcon.click();
			}
		});
		
		submitIcon.mouseup(function(){
			return false;
		});
		
		searchBox.mouseup(function(){
			return false;
		});
				
		submitIcon.click(function(){
			if(isOpen == false){
				searchBox.addClass('sb-search-open');
				
				submitInput.show();
				isOpen = true;
			} else {
				searchBox.removeClass('sb-search-open');
				isOpen = false;
				
				submitInput.hide();
			}
	});

});
</script>