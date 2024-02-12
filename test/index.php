<table class="table table-striped table-hover">
  	<thead>
   		<tr>
			<th scope="col">#</th>
			<th scope="col">Name</th>
			<th scope="col">Surname</th>
			<th scope="col">Phone</th>
   		</tr>
  	</thead>
 	<tbody>	
		<!-- сюда будет подставляться значение из бд -->
  	</tbody>
</table>
<script> 
	let path = "/<?php echo $DP_Config->backend_dir; ?>/content/test/ajax_get_table_data.php";
	let params = (new URL(document.location)).searchParams; 
	let data = {
		'id': params.get("id"),
		'count':params.get("count"),
	};
	$.ajax({  // отправляем запрос на сервер и формируем ответ в виде тега <tr>
    	type: "post",
		async: true,
    	url: path,
		dataType:"json",
		data:{data},
		success: function(res){                        
		let tbody =document.querySelector('tbody');	
		for(let i=0; i< res.length; i++) {
			let tr = document.createElement('tr');
			tr.innerHTML = `	
				<th scope="row">${res[i]["id"]}</th>
				<td>${res[i]["name"]}</td>
				<td>${res[i]["surname"]}</td>
				<td>${res[i]["phone"]}</td>`;
				tbody.append(tr);
		}	
		},
		error:function(error){
			console.log(error);
		}
	});

	// подгружаем следующие по порядку строки из бд  
	window.addEventListener('scroll', function () {
		if($(window).scrollTop()+$(window).height()>=$(document).height()) {
		let tbody = document.querySelector('tbody');
		let tr = tbody.lastElementChild;
		let id = tr.firstElementChild.textContent;
		data['id'] = Number(id); // изменяем id строки на следующие по порядку (1 => 100) 
		$.ajax({
			type: "post",
			async: true,
			url: path,
			dataType:"json",
			data:{data},
			success: function(res){                        	
			for(let i=0; i< res.length; i++) {
				let tr = document.createElement('tr');
				tr.innerHTML = `	
				<th scope="row">${res[i]["id"]}</th>
				<td>${res[i]["name"]}</td>
				<td>${res[i]["surname"]}</td>
				<td>${res[i]["phone"]}</td>`;
				tbody.append(tr);
			}	
			},
			error:function(error){
				console.log(error);
			}
		});
	}
	});
</script>