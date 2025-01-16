$(function(){
	function checkLength(o,min,max,title){
		if (o.val().length<min||o.val().length>max) {
			updateTips("length of "+title+" have to vary between "+min+" and "+max+".");
		o.focus().addClass('error');
		return false;
		}else{
			return true;
		}
	}
	function checkNumber(o,n){
		if (isNaN(o.val())) {
			updateTips(n);
			o.focus().addClass('error');
			return false;
		}else{
			return true;
		}
	}
	function checkRegexp(o, regexp, n) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "error" ).focus();
				updateTips( n );
				e.preventDefault();
				return false;
			} else {
				return true;
			}
		}
	var object=$("#Tips");
	function updateTips(data){
		object.text(data).effect('slide',600);
	}
	$("#button").click(function(e){
		e.preventDefault();
		$("input").removeClass('error');
	var first=$("#first"),last=$("#last"),date=$("#dat"),sex=$("#sex"),
	uname=$("#uname"),pass=$("#pass"),email=$("#email"),phone=$("#phone"),
	idno=$("#idno"),valid=true;
	valid=valid && checkLength(first,3,15,'firstName');
	valid =valid && checkRegexp( first, /^[a-z]([0-9a-z_])+$/i, "Use a-z, 0-9, underscores, begin with letter" );
	valid=valid && checkLength(last,3,15,'lastName');
	valid =valid && checkRegexp( last, /^[a-z]([0-9a-z_])+$/i, "Use a-z, 0-9, underscores, begin with letter" );
	valid=valid && checkLength(date,3,15,'date');
	valid=valid && checkLength(uname,3,15,'UserName');
	valid =valid && checkRegexp( uname, /^[a-z]([0-9a-z_])+$/i, "Use a-z, 0-9, underscores, begin with letter" );
	valid=valid && checkLength(pass,7,45,'Password');
	valid=valid && checkLength(email,6,40,'email');
    valid = valid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. radiant@gmail.com" );
    valid=valid && checkLength(phone,10,30,'PhoneNumber');
    valid=valid && checkNumber(phone,'plz use Numbers');
    valid=valid && checkLength(idno,16,50,'id number');
    valid=valid && checkNumber(idno,'plz use Numbers');
	if (valid) {
		$.ajax({
			type:"POST",
			url:"account.php",
			data:{
				fname:first.val(),
				lname:last.val(),
				dob:date.val(),
				sex:sex.val(),
				uname:uname.val(),
				pass:pass.val(),
				email:email.val(),
				phone:phone.val(),
			},
			success:function(res){
				alert(res);
				$("#form input[type=text]").val('');
			}
		});
	}
	});
});