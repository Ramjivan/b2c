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
					<table class="stripped" id="p-tab">
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>parent category name</th>
								<th>action</th>
							</tr>
						</thead>
						<tbody id="tbdy">
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="center-block">
				<h3>Add Category</h3>
				<div>
					<form class="jk-form pdct-form" id="ctcfm">
						
						<div id="vsadc" class="vs">
							<h3 id="vsh3">Something Went wrong</h3>
						</div>
						
						<div class="form-group">
							<input id="name" onchange="validate({'id':'name','name':'Name','regex':/[a-zA-Z ]+/,'length':null,'min_length':1,'max_length':null})" type="text" placeholder="Full Name" name="cat_name"/>
						</div>
						
						<div class="form-group">
							<textarea id="description" onchange="validate({'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255})" type="text" placeholder="255 char long description" name="cat_description"></textarea>
						</div>
						<div class="form-group">
							<textarea id="metakey" onchange="validate({'id':'metakey','name':'metakey','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':null,'max_length':255})" type="text" placeholder="255 char long description" name="cat_meta_keyword"></textarea>
						</div>
						
						<div class="form-card form-group">
							can have child categories ? 
							<div class="jk-radio">
								<input id="1" type="radio" value="1" name="isTop" checked>
								<label for="1">Yes</label>
							</div>
							<div class="jk-radio">
								<input id="2" type="radio" name="isTop" value="0">
								<label for="2">No</label>
							</div>
						</div>
						
						<div id="cat_panel" class="form-card form-group">
							Parent Category
							<div >
								<div class="jk-radio">
									<input id="31trd1" value="select" name="3trd" type="radio" checked>
									<label for="3trd1">
										<select name="parent_id" id="31t1" style="width:auto;margin:0;" onchange="validate({'id':'31t1','name':'Category','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':null})">
										</select>
									</label>
								</div>
							</div>
						</div>
						<div class="form-card form-group">
							<h3>Sample Image</h3>
							<input id="image1" onchange="validate({'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null})" type="file" name="image"/>
							<span class="fa fa-file jk-input-ico-right"></span>
						</div>
						<div class="form-group">
							<input type="button" id="add" class="btn btn-primary-color" value="Add"/>
						</div>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="dialog">
		
			<div id="dhead">
				Edit Category
				<span class="fa right" onclick="this.parentElement.parentElement.style.display='none';document.getElementsByClassName('blurdfg')[0].style.display='none';">
					&times;
				</span>
				<div class="clearfix"></div>
			</div>
			
			<div class="dialog-body">
				<form class="jk-form pdct-form" id="ctefm">
					
					<div id="vsedc" class="vs">
						<h3 id="vsh3">Something Went wrong</h3>
					</div>
					
					<div class="form-group">
						<input id="e_name" onchange="validate({'id':'e_name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null})" type="text" placeholder="Full Name" name="cat_name"/>
					</div>
					
					<div class="form-group">
						<textarea id="e_description" onchange="validate({'id':'e_description','name':'description','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':null,'max_length':255})" type="text" placeholder="255 char long description" name="cat_description"></textarea>
					</div>
					<div class="form-group">
							<input type="hidden" name="cid" id="ce5d_3fid" value="">
							<input type="button" id="ed" class="btn btn-success" value="Edit"/>
					</div>
				</form>
			</div>
		</div>

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>