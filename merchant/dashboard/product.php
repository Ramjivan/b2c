<?php
	require_once 'C:/xampp/htdocs/b2c/sess_val.php';
?>
<!DOCTYPE html>
<html id="fh4jf">
	<head>
		<title>
			products | dashoboard
		</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		
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
				<h3>Products</h3>
				<div class="log-table">
					<table id="p-tab">
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>price</th>
								<th>stock</th>
								<th>category</th>
								<th>image</th>
								<th>action</th>
							</tr>
						</thead>
						<tbody id="tbdy">
						</tbody>
					</table>
				</div>
				
			</div>

			<div class="center-block">
				<h3>Add Product</h3>
				<div>
					<form class="jk-form pdct-form" id="pctafm" action="/b2c/apies/product/add" method="post" enctype="multipart/form-data">
						<div id="vsap" class="vs">
							<h3 id="vsh3" class="vs">Something Went wrong</h3>
						</div>
						<div class="form-group">
							<input id="name" onchange="validate({'id':'name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null})" type="text" placeholder="Full Name" name="p_name"/>
						</div>
						<div class="form-group">
							<textarea id="description" onchange="validate({'id':'description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255})" type="text" placeholder="255 char long description" name="p_description"></textarea>
						</div>
						<div class="form-group">
							<input id="price" onchange="validate({'id':'price','name':'Price','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6})" type="text" placeholder="Price" name="p_price"/>
						</div>
						<div id="cat_panel" class="form-group">
							<select id="31t1" onchange="validate({'id':'31t1','name':'Category','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':null})" name="p_category">
							</select>
						</div>
						<div class="form-group">
							<input id="stock" onchange="validate({'id':'stock','name':'Stock','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6})" type="text" placeholder="Stocks" name="p_stock"/>
						</div>
						<div class="form-group">
							<h3>Images</h3>
							<input type="hidden" name="imgcount" value="1"/>
							<input id="image1" onchange="validate({'id':'image1','name':'image1','regex':null,'length':null,'min_length':1,'max_length':null})" type="file" name="image1" multiple/>
						</div>
						<div class="form-group">						
							<h3>Hightlights</h3>
						
							<input id="hlgt1" onchange="validate({'id':'hlgt1','name':'Hightlight1','regex':null,'length':null,'	min_length':5,'max_length':null})" type="text" placeholder="Hightlight 1" name="hlgt1"/>
							<input id="hlgt2" type="text" placeholder="Hightlight 2 (optional)" name="hlgt2"/>
							<input id="hlgt3" type="text" placeholder="Hightlight 3 (optional)" name="hlgt3"/>
							<input id="hlgt4" type="text" placeholder="Hightlight 4 (optional)" name="hlgt4"/>
							<input id="hlgt5" type="text" placeholder="Hightlight 5 (optional)" name="hlgt5"/>
							<input type="hidden" name="hlgtcount" value="5"/>
						</div>	
						<div class="form-group">
								<h2>Specifications</h2>
								<div style="margin:0% auto;position:relative;display:block;width:45%;background-color:white;box-shadow:0px 0px 1px rgba(0,0,0,0.2);padding:20px;">
									Specification count <select id="s_c" name="spcount" class="jk-select"></select>
								</div>
							<div id="qasw">
								<div class="clearfix"></div>
								<div class="spec">
									<h3>Specification 1</h3>
										<input id="sp_name1" onchange="validate({'id':'sp_name1','name':'Spec Name 1','regex':null,'length':null,'min_length':5,'max_length':null})" type="text" placeholder="Spec Name" name="sp_name1"/>
										<input id="sp_value1" onchange="validate({'id':'sp_value1','name':'Spec Value 1','regex':null,'length':null,'min_length':5,'max_length':null})" type="text" placeholder="Spec Value" name="sp_value1"/>
								</div>
							</div>
						</div>
						<div class="form-group">							
							COD eligible ? Yes <input type="radio" name="cod" value="1" checked> No <input type="radio" name="cod" value="0">
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
			Edit Product
			<span class="fa right" onclick="this.parentElement.parentElement.style.display='none';document.getElementsByClassName('blurdfg')[0].style.display='none';">
				&times;
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="dialog-body">
				<form class="pdct-form" id="pctefm" >
						<div class="vs" id="valsum">
							<h3 id="vsh4" class="vs">Something Went wrong</h3>
						</div>
						<div class="form-group">
							Name
							<input id="e_name" onchange="validate({'id':'e_name','name':'Name','regex':/^[a-zA-Z ]+$/,'length':null,'min_length':9,'max_length':null})" type="text" placeholder="Full Name" name="p_name"/>
						</div>
						
						<div class="form-group">
						Description
							<textarea id="e_description" onchange="validate({'id':'e_description','name':'description','regex':null,'length':null,'min_length':null,'max_length':255})" type="text" placeholder="255 char long description" name="p_description"></textarea>
						</div>
						
						<div class="form-group">
						Price
							<input id="e_price" onchange="validate({'id':'e_price','name':'Price','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6})" type="text" placeholder="Price" name="p_price"/>
						</div>			
				
						<div class="form-group">
						stock
							<input id="e_stock" onchange="validate({'id':'e_stock','name':'Stock','regex':/^[0-9]+$/,'length':null,'min_length':1,'max_length':6})" type="text" placeholder="Stocks" name="p_stock"/>
						</div>

						<div class="form-group">
							<input type="hidden" name="product_id" id="pe5d_3fid" value="">
							<input type="button" id="ed" class="btn btn-success" value="Edit"/>
						</div>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
		

	<?php
		//including footer
		include 'footer.php';
	?>
</body>
</html>