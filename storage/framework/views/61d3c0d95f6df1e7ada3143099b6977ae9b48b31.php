<div align="right">
	<input type="text" class="form-control" placeholder="Search" style="width:300px;display:inline" id = "searchbar" oninput="search()"></input>
	<!-- <button class= "btn btn-primary" onclick="search()">Search</button> -->
</div>
<br>

<script>
	function search(){
		var searchbar = document.getElementById("searchbar");
		var tosearch = searchbar.value.toLowerCase();
		var table = document.getElementById("main-table");
		if(table && searchbar){
			var rows = table.rows;
			for(var i = 1; i < rows.length; i++){
				var cells = rows[i].cells;
				var includes = false;
				for(var j = 0; j < cells.length; j++){
					if(cells[j].innerHTML.toLowerCase().includes(tosearch) && !cells[j].hasAttribute("no-search")){
						includes = true;
						break;
					}
				}
				if(includes){
					rows[i].style.display = 'table-row';
				}else{
					rows[i].style.display = 'none';
				}
			}
		}
	}
</script>