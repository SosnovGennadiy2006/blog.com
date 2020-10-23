var signInButton = document.querySelector(".signIn"),
	signUpButton = document.querySelector(".signUp"),
	active = document.querySelector(sessionStorage.getItem("active")) || signInButton,
	line = document.querySelector(".line"),
	slider = document.querySelector(".slider"),
	signUpSubmit = document.querySelector(".signUpSubmit");

if (window.innerWidth < 400) {
	signUpButton.innerHTML = "зарег.";
	signUpSubmit.innerHTML = "зарег.";
} else {
	signUpButton.innerHTML = "Зарегистрироваться";
	signUpSubmit.innerHTML = "Зарегистрироваться";
}

signInButton.classList.remove("active");
signUpButton.classList.remove("active");
active.classList.add("active");

line.style.width = active.offsetWidth + "px";
line.style.left = active.offsetLeft + "px";
if (active == signUpButton) {
	slider.style.left = "-100%";
}else{
	slider.style.left = "0%";
}

signInButton.onclick = () => {
	if (signUpButton.classList.contains("active")) {
		signUpButton.classList.remove("active");
		signInButton.classList.add("active");
		active = document.querySelector(".active");
	}
	line.style.width = active.offsetWidth + "px";
	line.style.left = active.offsetLeft + "px";
	slider.style.left = "0%";
	sessionStorage.setItem("active", ".signIn");
}

signUpButton.onclick = () => {
	if (signInButton.classList.contains("active")) {
		signInButton.classList.remove("active");
		signUpButton.classList.add("active");
		active = document.querySelector(".active");
	}
	line.style.width = active.offsetWidth + "px";
	line.style.left = active.offsetLeft + "px";
	slider.style.left = "-100%";
	sessionStorage.setItem("active", ".signUp");
}

window.addEventListener("resize", () => {
	if (window.innerWidth < 400) {
		signUpButton.innerHTML = "зарег.";
		signUpSubmit.innerHTML = "зарег.";
	} else {
		signUpButton.innerHTML = "Зарегистрироваться";
		signUpSubmit.innerHTML = "Зарегистрироваться";
	}

	line.style.width = active.offsetWidth + "px";
	line.style.left = active.offsetLeft + "px";
})