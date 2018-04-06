<?php
	include("/sess_val.php");
?>
<!DOCTYPE html>
<html id="fh4jf">
	<head>
		<title>
			Store | dashoboard
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<script language="javascript" src="/js/merstroe.js"></script>

		<?php
			//including head
			include 'headTags.php';
		?>
	</head>
<body class="body">
	<?php
		//including header
		include 'header.php';
	?>
	
		<div class="container"> 
			<div class="center-block">
                <h2>Store</h2>
                <div id="main-str-cnr">
					<form class="jk-form pdct-form" id="stafrm" enctype="multipart/form-data">
						<div id="vsap" class="vs">
							<h3 id="vsh3" class="vs">Something Went wrong</h3>
						</div>

						<div class="form-group">
							<h3>Store Name</h3>
							<input id="st_name" onchange="validate({'id':'st_name','name':'Name','regex':/^([a-zA-Z\s]+)$/,'length':null,'min_length':2,'max_length':null})" type="text" placeholder="Store Name (only alphabets allowed)" name="st_name"/>
						</div>

						<div class="form-group">
							<h3>Images</h3>
							<input id="st_logo" onchange="validate({'id':'st_logo','name':'logo','regex':null,'length':null,'min_length':1,'max_length':null})" type="file" name="st_logo"/>
						</div>

						<div class="form-group">
							<h3>Store Contact Details</h3>
							<p>Phone</p>
							<input id="st_phone" onchange="validate({'id':'st_phone','name':'Contact Number','regex':/^[0-9]{10}$/,'length':10,'min_length':10,'max_length':10})" type="text" placeholder="Contact Number 75848XXXXX" name="st_phone"/>
							<p>E-Mail</p>
							<input id="st_email" onchange="validate({'id':'st_email','name':'Mail Address','regex':/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,'length':null,'min_length':5,'max_length':255})" type="text" placeholder="Email" name="st_email"/>
						</div>

						<div class="form-group">
							<h3>Theme</h3>
							<select id="st_thm_spinner" class="jk-select" name="st_theme_id" onchange="validate({'id':'st_thm_spinner','name':'Theme','regex':/^([0-9]+)$/,'length':null,'min_length':1,'max_length':null})">
								<option value="1">Default - Free</option>
							</select>
							<span class="fa fa-chevron-down jk-input-ico-right" style="z-index:-1;"></span>
						</div>

						<div class="form-group">
							<h3>Address</h3>
							<div class="form-group">
								<p>House No. / House Name / Custome	r Name</p>
								<input id="adt_fullname" onchange="validate({'id':'adt_fullname','name':'House No. / House Name / Customer Name','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':4,'max_length':16})" type="text" name="adt_fullname" placeholder="House No. / House Name (eg. I-30 or Basant Kunj)"/>
							</div>
							
							<div class="form-group">
								<p>Mobile Number</p>
								<input id="adt_mob" onchange="validate({'id':'adt_mob','name':'Mobile','regex':/^[0-9]*$/,'length':10,'min_length':null,'max_length':null})" type="tel" name="adt_mob" class="jk-textbox wi-left" placeholder="(+91)1234567890">
								<span class="fa fa-phone jk-input-ico-left"></span>
							</div>
							
							<div class="form-group">
								<p>Pincode</p>
								<input id="adt_pincode" onchange="validate({'id':'adt_pincode','name':'Pincode','regex':/^[0-9]*$/,'length':6,'min_length':null,'max_length':null})" type="tel" name="adt_pincode" class="jk-textbox wi-left" placeholder="6 Digit Pincode">
								<span class="fa fa-envelope jk-input-ico-left"></span>
							</div>				
							
							<div class="form-group">
								<p>Address Line 1</p>
								<input id="adt_addressline1" onchange="validate({'id':'adt_al1','name':'Address Line 1','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':null,'max_length':null})" type="text" name="adt_addressline1" class="jk-textbox wi-left" placeholder="Address Line 1">
								<span class="fa fa-minus jk-input-ico-left"></span>
							</div>				
							
							<div class="form-group">
								<p>Address Line 2</p>
								<input id="adt_addressline2" onchange="validate({'id':'adt_al2','name':'Address Line 2','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+$/,'length':null,'min_length':null,'max_length':null})" type="text" name="adt_addressline2" class="jk-textbox wi-left" placeholder="Address Line 2">
								<span class="fa fa-minus jk-input-ico-left"></span>
							</div>				
							
							<div class="form-group">
								<p>Landamrk</p>
								<input id="adt_landmark" onchange="validate({'id':'adt_l','name':'Landmark','regex':/^[A-Za-z]([a-zA-Z0-9][\.\s]*)+/,'length':null,'min_length':8,'max_length':64})" type="text" name="adt_landmark" class="jk-textbox wi-left" placeholder="Landmark">
								<span class="fa fa-map jk-input-ico-left"></span>
							</div>

							<div class="form-group">
								<p>State</p>
								<select id="adt_state" class="jk-select" onchange="validate({'id':'adt_state','name':'Landmark','regex':/^([A-Za-z]*)$/,'length':null,'min_length':4,'max_length':128})" type="text" name="adt_state" class="jk-textbox wi-left"><option value="test">test</option></select>
								<span class="fa fa-caret-down jk-input-ico-right"></span>
							</div>	
							
							<div class="form-group">
								<p>City</p>
								<select id="adt_city" class="jk-select" onchange="validate({'id':'adt_city','name':'Landmark','regex':/^([A-Za-z]*)$/,'length':null,'min_length':4,'max_length':128})" type="text" name="adt_city" class="jk-textbox wi-left"><option value="test">test</option></select>
								<span class="fa fa-caret-down jk-input-ico-right"></span>
							</div>
							<div class="form-group">
								<p>Address Type</p>
								<select id="adt_type" class="jk-select" onchange="validate({'id':'adt_type','name':'Landmark','regex':/^[0-9]*$/,'length':1,'min_length':null,'max_length':null})" type="text" name="adt_type" class="jk-textbox wi-left">
									<option value="1">
										<p>Home / Residential</p>
									</option>		
									<option value="1">
										<p>Office / Industrial</p>
									</option>
								</select>
								<span class="fa fa-caret-down jk-input-ico-right"></span>
							</div>	
						</div>

						<div class="form-group">
							<h3>Social Links</h3>
							<p>Facebook Link</p>
							<input id="st_fb_lnk" class="jk-textbox" onchange="validate({'id':'st_fb_lnk','name':'Facebook Link','regex':/^([\w]+)\.facebook\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null})" type="url" placeholder="https://www.facebook.com/jhondoe" name="st_fb_lnk"/>

							<p>Twitter Link</p>
							<input id="st_tw_lnk" class="jk-textbox" onchange="validate({'id':'st_tw_lnk','name':'Twitter Link','regex':/^([\w]+)\.twitter\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null})" type="url" placeholder="https://www.twitter.com/jhondoe" name="st_tw_lnk"/>

							<p>Google+ Link</p>
							<input id="st_go_lnk" class="jk-textbox" onchange="validate({'id':'st_go_lnk','name':'Google+ Link','regex':/^([\w]+)\.google\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null})" type="url" placeholder="https://www.google.com/jhondoe" name="st_go_lnk"/>

							<p>Instagram Link</p>
							<input id="st_in_lnk" class="jk-textbox" onchange="validate({'id':'st_in_lnk','name':'Instagram Link','regex':/^([\w]+)\.instagram\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null})" type="url" placeholder="https://www.instagram.com/jhondoe" name="st_in_lnk"/>

							<p>Youtube Link</p>
							<input id="st_yt_lnk" class="jk-textbox" onchange="validate({'id':'st_yt_lnk','name':'Youtube Link','regex':/^([\w]+)\.youtube\.([\w\W]+)\/([\w\W]+)$/,'length':null,'min_length':9,'max_length':null})" type="url" placeholder="https://www.youtube.com/jhondoe" name="st_yt_lnk"/>

							<p>Whatsapp Bussiness Number</p>
							<input id="st_wpb_lnk" class="jk-textbox" onchange="validate({'id':'st_wpb_lnk','name':'Whatsapp Link','regex':/^[0-9]{10}$/,'length':10,'min_length':null,'max_length':null})" type="tel" placeholder=" 10 Digit Number 772696XXXX" name="st_wpb_lnk"/>
						</div>

						<div class="form-group">
							<input type="button" id="st_s_btn" class="btn btn-success" value="Create"/>
						</div>
					</form>
                </div>
            </div>
			<div class="clearfix"></div>
		</div>
		

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>