//login principal
		$(function() {

			$("#formulario").submit(function(e) {
				e.preventDefault();
				var actionurl = e.currentTarget.action;
				 $.ajax({
						url: actionurl,
						type: 'post',
						data: $("#formulario").serialize(),
						success: function(data) {
								   var str = data;
								   var res = str.split(",");
								   
								   if(res[0]=="OK"){
										toastr.success(res[1], '', {timeOut: 2500, positionClass: "toast-top-center"});
										setTimeout(function() { location.reload(); }, 1000);
								   }
								   else{
										toastr.error(res[1], '', {timeOut: 5000, positionClass: "toast-top-center"})
								   }
								}
					});

			});

		});

//envia la informacion del formulario (encabezado y detalles) en este caso de las ordenes de compra
$(function() {

			$("#headerOC").submit(function(e) {
				e.preventDefault();
				var actionurl = e.currentTarget.action;
				console.log($("#test-table").FullTable("getData"));
				console.log($("#headerOC").serialize());
				 $.ajax({
						url: actionurl,
						type: 'post',
						data: { header: $("#headerOC").serialize(), detail: $("#test-table").FullTable("getData")},
						success: function(data) {
								   var str = data;
								   var res = str.split(",");
								   
								   if(res[0]=="Error"){
										toastr.error(res[1], 'Error', {timeOut: 5000, positionClass: "toast-top-center"})
								   }
								   else if(res[0]=="Warning"){
										toastr.warning(res[1], 'Warning', {timeOut: 5000, positionClass: "toast-top-center"})
								   }
								   else if(res[0]=="Ok"){
										toastr.success(res[1], 'Registro Correcto', {timeOut: 2500, positionClass: "toast-top-center"});
										setTimeout(function () { location.reload(true); }, 2500);
								   }
								   else{
									   toastr.error(data, 'Error ' + data, {timeOut: 5000, positionClass: "toast-top-center"})
								   }
								}
					});

			});

		});
		


		