var message_container = document.querySelector('.message'),
	cross_message     = document.querySelector('.message .cross');

cross_message.onclick = () => {
	message_container.classList.add('disappear');
	sleep(300).then(result => {
		message_container.classList.remove('active');
		message_container.classList.remove('disappear');
	})
}

if (isUserHasError) {
	message_container.classList.add('active');
}