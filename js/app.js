$(document).ready(function() {
	$('.forms .input-group input').focusout(function(){
		var text_val = $(this).val();

		if(text_val === ""){
			$(this).removeClass('has-value');
		}
		else{
			$(this).addClass('has-value');
		}
	});
	displayService();
	services();
    $(".editBtn").click(function(){
        $(".on").toggleClass("off");
    });

    $(window).scroll(function(){
    var wScroll = $(this).scrollTop();

    if (wScroll > $('#header').offset().top-$(window).height()) {
       $('#header').css({'background-position':'center -'+ wScroll*1.8 +'%'});
    }

});

});

function validateInfo() {
    var fname = document.forms["info-form"]["firstName"].value;
    var lname = document.forms["info-form"]["lastName"].value;
    var email = document.forms["info-form"]["email"].value;
    var phone = document.forms["info-form"]["phone"].value;
    var address = document.forms["info-form"]["address"].value;
    var newPhone = phone.replace(/\D[^\.]/g, "");
    if (fname == null || fname == "") {
        alert("Name must be filled out");
        return false;
    }
    else if (lname == null || lname == ""){
    	alert("Last name must be filled out");
    	return false;
    }
    else if (email == null || email == ""){
    	alert("email must be filled out");
    	return false;
    }
    else if (newPhone == null || newPhone == ""){
    	alert("Phone number must be filled out");
    	return false;
    }
    else if (address == null || address == ""){
    	alert("Address must be filled out");
    	return false;
    }
}

function validateCard() {
    var cardNum = document.forms["card-info"]["cardNumber"].value;
    var cvv = document.forms["card-info"]["cvv"].value;
    var Name = document.forms["card-info"]["Name"].value;
    if (cardNum == null || cardNum == "" || isNaN(cardNum)) {
        alert("Card number must be filled out");
        return false;
    }
    else if (cvv == null || cvv == "") {
        alert("Cvv number must be filled out");
        return false;
    }
    else if (Name == null || Name == "") {
        alert("Name must be filled out");
        return false;
    }
}

function services(){
	$('input:radio[name=switch_3]').on('click', function(){
		var btn = $(this).val();
		var isService = $('#plans').find('div#'+btn);
		var allService = $('#plans').find('div.plan');
		allService.css('display','none');
		isService.css('display','flex');

	});
}

function displayService(){
		var isService = $('#plans').find('div#ParI');
		var allService = $('#plans').find('div.plan');
		allService.css('display','none');
		isService.css('display','flex');
}

