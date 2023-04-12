const localization = {
	"ru": {
		"login": "Вход",
		"registration": "Регистрация",
		"without_registration": "Без регистрации",
		"logout": "Выход",
		"nickname": "Логин",
		"password": "Пароль",
		"repeat_password": "Повторить пароль",
		"done_tasks": "Выполненное",
		"archive_tasks": "Архив",
		"bookmark_tasks": "Закладки"
	},
	"en": {
		"login": "Login",
		"registration": "Registration",
		"without_registration": "Without registration",
		"logout": "Logout",
		"nickname": "Nickname",
		"password": "Password",
		"repeat_password": "Repeat password",
		"done_tasks": "Done",
		"archive_tasks": "Archive",
		"bookmark_tasks": "Bookmarks"
	} 
};

let languages = ["ru", "en"];

window.onload = function() {
	let currentLocalization = localStorage.getItem("localization");

	if (!languages.includes(currentLocalization)) {
		currentLocalization = "ru";
		return;
	}

	const selectElement = document.getElementById("localization_language");
	const index = Array.from(selectElement.options).findIndex(option => option.value === currentLocalization);
	selectElement.selectedIndex = index;

	changeLocalization(currentLocalization);	
};

function changeLocalization(lang) {
	localStorage.setItem("localization", lang);

	Object.entries(localization[lang]).forEach(([key, value]) => {
		if (
			document.querySelector("." + key + "_nav") !== null
			&& document.querySelector("." + key + "_nav") !== undefined
		) {
			let elements = document.querySelectorAll("." + key + "_nav");
			Object.entries(elements).forEach(([keyElem, element]) => {
				element.textContent = value;
			});
		}
	});
}
