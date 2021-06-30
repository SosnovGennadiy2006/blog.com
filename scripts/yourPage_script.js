var phone_buttons       = document.querySelectorAll("#phone"),
	phone_block         = document.querySelector(".phone"),
	phone_info          = document.querySelector(".phone .information"),
	new_phone           = document.querySelector(".phone .form_input"),
	save_phone_buttons  = document.querySelectorAll("#save_phone");

for (var i = 0; i < phone_buttons.length; i++) {
	phone_buttons[i].onclick = () => {
		phone_block.classList.toggle("active");
	}
}

for (var i = 0; i < save_phone_buttons.length; i++) {
	save_phone_buttons[i].onclick = () => {
		phone_block.classList.toggle("active");
		if (new_phone.value){
			phone_info.innerHTML = new_phone.value;
		}
	}
}

var town_buttons       = document.querySelectorAll("#town"),
	town_block         = document.querySelector(".town"),
	town_info          = document.querySelector(".town .information"),
	new_town           = document.querySelector(".town .form_input"),
	save_town_buttons  = document.querySelectorAll("#save_town");


for (var i = 0; i < town_buttons.length; i++) {
	town_buttons[i].onclick = () => {
		town_block.classList.toggle("active");
	}
}

for (var i = 0; i < save_town_buttons.length; i++) {
	save_town_buttons[i].onclick = () => {
		town_block.classList.toggle("active");
		if (new_town.value){
			town_info.innerHTML = new_town.value;
		}
	}
}

var country_buttons       = document.querySelectorAll("#country"),
	country_block         = document.querySelector(".country"),
	country_info          = document.querySelector(".country .information"),
	new_country           = document.querySelector(".country .form_input"),
	save_country_buttons  = document.querySelectorAll("#save_country");

for (var i = 0; i < country_buttons.length; i++) {
	country_buttons[i].onclick = () => {
		country_block.classList.toggle("active");
	}
}

for (var i = 0; i < save_country_buttons.length; i++) {
	save_country_buttons[i].onclick = () => {
		country_block.classList.toggle("active");
		if (new_country.value){
			country_info.innerHTML = new_country.value;
		}
	}
}

var imgs      = document.querySelectorAll(".user_photo"),
	container = document.querySelector(".photo_description"),
	photo     = document.querySelector(".photo img"),
	cross     = document.querySelector(".cross");


imgs.forEach(img => {
	img.addEventListener('click', clickFunc);
})

function sleep(sec){
	return new Promise((resolve, reject) => {
		setInterval(() => resolve(), sec);
	});
}

function clickFunc(e){
	document.location.href = 'http://blog.com/yourPage.php?id='+e.target.getAttribute('data-n')+'&active=true';
}

window.addEventListener('keydown', e => {
	if(e.keyCode == 116){
		e.preventDefault();
		document.location.href = 'http://blog.com/yourPage.php';
	}
})

try{

	var description_button = document.querySelector('.write_description span')||document.querySelector('.li_change_description .change'),
		description_block  = document.querySelector('.li_description')||document.querySelector('.li_change_description'),
		isUserShouldSave   = false;

	description_button.onclick = () => {
		description_block.classList.add('active');
	}

	var description_textarea = document.querySelector('.description_textarea'),
		save_button          = document.querySelector('.save_img');

	description_textarea.addEventListener('input', e => {
		var value = description_textarea.value;

		if (value){
			if (!save_button.classList.contains('should_save')){
				save_button.classList.add('should_save');
				isUserShouldSave   = true;
			}
		}else{
			save_button.classList.remove('should_save');
			isUserShouldSave   = false;
		}
	})
}catch{

}

var alert     = document.querySelector('.alert'),
	buttonYES = document.querySelector('.yes'),
	buttonNO  = document.querySelector('.no');

buttonYES.onclick = () => {
	alert.classList.add('notActive');
	sleep(600).then(result => {
		alert.classList.remove('notActive');
		alert.classList.remove('active');
		container.classList.add('notActive');
		document.querySelector('body').style.overflowY = 'scroll';
		sleep(1000).then(result => {
			container.classList.remove('notActive');
			container.classList.remove('active');
		});
	});
}

buttonNO.onclick = () => {
	alert.classList.add('notActive');
	sleep(1000).then(result => {
		alert.classList.remove('notActive');
		alert.classList.remove('active');
	});
}

cross.onclick = () => {
	if (!isUserShouldSave) {
		container.classList.add('notActive');
		document.querySelector('body').style.overflowY = 'scroll';
		sleep(1000).then(result => {
			container.classList.remove('notActive');
			container.classList.remove('active');
		});
	}else{
		alert.classList.add('active');
	}
}

var input    = document.querySelector('.input__file'),
	label    = input.nextElementSibling,
	labelVal = label.querySelector('.input__file-button-text').innerText;
  
input.addEventListener('change', function (e) {
	if (this.files && this.files.length >= 1) label.querySelector('.input__file-button-text').innerText = this.files[0].name;
	else label.querySelector('.input__file-button-text').innerText = labelVal;
});