<?php
	require_once 'C:/xampp/htdocs/b2c/sess_val.php';
?>
<!DOCTYPE html>
<html id="fh4jf">
	<head>
		<title>
			category | Merchant dashoboard
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		
		<?php
			//include head
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
				<h3>Category</h3>
				<div class="log-table">
					<table id="p-tab">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Description</th>
								<th>isTop</th>
								<th>category</th>
								<th>action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			
			<div class="center-block">
				<h3>Add Category</h3>
				<div>
					<form class="pdct-form" id="ctcfm">
						
						<div id="vs">
							<h3 id="vsh3">Something Went wrong</h3>
						</div>
						
						<div class="form-group">
							<input id="name" onchange="validate({'id':'name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null})" type="text" placeholder="Full Name" name="p_name"/>
						</div>
						
						<div class="form-group">
							<textarea id="description" onchange="validate({'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255})" type="text" placeholder="255 char long description" name="p_description"></textarea>
						</div>
						
						<div class="form-group">
							can have child categories ? Yes&nbsp;<input type="radio" name="isTop" value="1" checked/> No&nbsp;<input type="radio" name="isTop" value="0s"/> 
						</div>
						
						<div class="row form-group">
							<div class="col-1">
								Parent Category
							</div>
							<div class="col-2">
								<select id="category" onchange="validate({'id':'category','name':'Category','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':null})" name="p_category" style="margin:0;">
									<option value="null">Select Category</option>
								</select>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<h3>Sample Image</h3>
							<input type="hidden" name="imgcount" value="1"/>
							<input id="image1" onchange="validate({'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null})" type="file" name="image1"/>
						</div>
						<div class="form-group">
							<input type="button" id="add" class="btn btn-primary-color" value="Add"/>
						</div>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>