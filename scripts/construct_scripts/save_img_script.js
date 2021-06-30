function sleep(sec){
	return new Promise((resolve, reject) => {
		setInterval(() => resolve(), sec);
	});
}

function clear_all(array){
	array.forEach(item => {
		item.classList.remove('active');
	})
}



var save_photo_button = document.querySelector('.save_changes_block button');

save_photo_button.onclick = () => {
	isUserHasChanges = false;
	window.onbeforeunload = none;
}




var input              = document.querySelector('.input__file'),
	label              = input.nextElementSibling,
	labelVal           = label.querySelector('.input__file-button-text').innerText,
	save_changes_block = document.querySelector('.save_changes_block');
  
input.addEventListener('change', function (e) {
	if (this.files && this.files.length >= 1){
		label.querySelector('.input__file-button-text').innerText = this.files[0].name;
		save_changes_block.classList.remove('disabled');
	}
	else{ 
		label.querySelector('.input__file-button-text').innerText = labelVal;
		save_changes_block.classList.add('disabled');
	}
});

var select_how         = document.querySelector('.select_how select'),
	for_computer       = document.querySelectorAll('.for_computer'),
	for_profile        = document.querySelectorAll('.for_profile');

select_how.onchange = e => {
	if (select_how.value == 'С компьютера'){
		for_profile.forEach(a => {
			a.style.display = 'none';
		})
		for_computer.forEach(b => {
			b.style.display = 'block';
		})
	}else if (select_how.value == 'Из профиля'){
		for_profile.forEach(a => {
			a.style.display = 'flex';
		})
		for_computer.forEach(b => {
			b.style.display = 'none';
		})

	}
}

var message_container = document.querySelector('.message'),
	cross_message     = document.querySelector('.message .cross'),
	message_text      = document.querySelector('.message .message__text');

cross_message.onclick = () => {
	message_container.classList.add('disappear');
	sleep(300).then(result => {
		message_container.classList.remove('active');
		message_container.classList.remove('disappear');
	})
}

var button_show_profile_imgs = document.querySelector('.show_user_imgs'),
	profile_imgs             = document.querySelector('.background'),
	cross_profile_imgs       = document.querySelector('.cross_profile_imgs');

button_show_profile_imgs.onclick = () => {
	if (isUserHasError) {
		message_text.innerHTML = 'У вас нет фотографий!';
		message_container.classList.add('active');
	}else{
		profile_imgs.classList.add('active');
	}
}

cross_profile_imgs.onclick = () => {
	profile_imgs.classList.remove('active');
	clear_all(imgs);
	save_profile_img_button.classList.remove('active');
}

var imgs                    = document.querySelectorAll('.img_wrapper'),
	save_profile_img_button = document.querySelector('.save_profile_img'),
	post_img                = document.querySelector('.img_block');

imgs.forEach(img => {
	img.onclick = e => {
		clear_all(imgs);
		e.target.classList.add('active');
		if (!save_profile_img_button.classList.contains('active')){
			save_profile_img_button.classList.add('active');
		}
	}
})

save_profile_img_button.onclick = e => {
	if (save_profile_img_button.classList.contains('active')){
		var select_img = document.querySelector('.img_wrapper.active');
		var path           = select_img.childNodes[1].src,
			block_for_path = document.querySelector('.profile_img_path');
		
		block_for_path.value = path;
		post_img.innerHTML = `<img src=${path}?rnd=<?= time() ?>`;

		clear_all(imgs);
		save_profile_img_button.classList.remove('active');
		profile_imgs.classList.remove('active');
		save_changes_block.classList.remove('disabled');
	}
}

var save_post_button  = document.querySelector('.main button[type="submit"]'),
	description_block = document.querySelector('.post_description_textarea');

save_post_button.onclick = e => {
	if(!is_post_has_image){
		message_text.innerHTML = 'Фотография для поста не выбрана!';
		message_container.classList.add('active');
		e.preventDefault();
	}else if(!description_block.value){
		message_text.innerHTML = 'Введите описание для поста!';
		message_container.classList.add('active');
		e.preventDefault();
	}
	isUserHasChanges = false;
	window.onbeforeunload = none;
}