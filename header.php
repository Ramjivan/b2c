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
				<script>
				
				</script>
                <div class="nav-item">
					<!--For desktop-->
					<form action="login.php" class="nav-s-bar" id="searchForm-d">
						<div class="form-group" style="background-color:white;">
							<input type="text" onkeyup="getSearchSuggestion(this.value);" class="jk-textbox wi-right nav-sb" autocomplete="off" list="suggestions">
							<span id="d-sb-fsub" class="fa fa-search jk-input-ico-right nav-bb"></span>
						</div>
						
					</form>
					
				</div>
                
			</nav>
			<nav class="navbar float-right">
				
			<div class="nav-item"><a href="/b2c"><span class="fa fa-1dot5x fa-user-circle"></span>&nbsp;</a></div>
				<div class="nav-item"><a href="cart"><span class="fa fa-1dot5x fa-shopping-cart"></span></a></div>
				
			</nav>
			<!--for mobile-->
			<div id="sb-search" class="sb-search navbar float-right" >
						<form>
							<input class="sb-search-input" onkeyup="buttonUp();getSearchSuggestion(this.value);" list="suggestions" placeholder="Let's Buy..." onblur="monkey();" type="search" value="" name="search" id="search" autocomplete="off">
							<input class="sb-search-submit" type="submit"  value="">
							<span class="sb-icon-search"><i class="fa fa-1dot5x fa-search" style="margin-top: -130px;"></i></span>
						</form>
						
					</div>
			
		</div>
    </div>
</div>
<div class="blurdfg">
</div>
	</div>
	<div class="blurdfg">
	</div>

<datalist id="suggestions">
    <option value="Internet Explorer">
    <option value="Firefox">
    <option value="Chrome">
    <option value="Opera">
    <option value="Safari">
  </datalist>