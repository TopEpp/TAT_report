function formatNum(value){
	if(value){
	    return Common.moneyFormat(value,0);
	}else{
	    return '';
	}
}

function formatNum2(value){
	if(value){
	    return Common.moneyFormat(value,2);
	}else{
	    return '';
	}
}

function dateThai(date=''){
	var label = '-';
	var m = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	if(date){
		var d = date.split('-');
		label = parseInt(d[2])+' '+m[parseInt(d[1])]+' '+(parseInt(d[0])+543);
	}

	return label;
}

function dateThaiNoDay(date=''){
	var label = '-';
	var m = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	if(date){
		var d = date.split('-');
		label = m[parseInt(d[1])]+' '+(parseInt(d[0])+543);
	}

	return label;
}

function dateDBtoPicker(date=''){
	var label ='';
	if(date){
		var d = date.split('-');
		label = d[2]+'/'+d[1]+'/'+(parseInt(d[0])+543);
	}

	return label;
}

function dropdown_toggle(menu){
	var id = $(menu).attr("data-id");console
	console.log(id);
	$(".drop_menu").each(function(index,ele) {
		if(ele.id!=id){
			$('#'+ele.id).hide();
		}else{
			var x = document.getElementById(id);
			console.log(x);
			if (x.style.display === "none" ) {
				$('#'+ele.id).show();
			}else{
				$('#'+id).hide();
			}
		}
	});

	// $('.dropdown-menu').hide();
	// $('#str'+id).toggle();

	//   if (x.style.display === "none") {
	//     x.style.display = "block";
	//   } else {
	//     x.style.display = "none";
	//   }
}
