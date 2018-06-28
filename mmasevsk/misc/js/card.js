var bottone1 = document.getElementById("button-week");
var bottone2 = document.getElementById("button-month");
var bottone3 = document.getElementById("button-year");

var cards1 = document.getElementById("week-cards");
var cards2 = document.getElementById("month-cards");
var cards3 = document.getElementById("year-cards");


function buttonCheck(bottonePremuto) {
	if (bottonePremuto === 1) {
		bottone1.classList.add("selected");
		bottone2.classList.remove("selected");
		bottone3.classList.remove("selected");

		cards1.classList.remove("hidden");
		cards2.classList.add("hidden");
		cards3.classList.add("hidden");


	} else if (bottonePremuto === 2) {
		bottone2.classList.add("selected");
		bottone1.classList.remove("selected");
		bottone3.classList.remove("selected");
		
		cards2.classList.remove("hidden");
		cards1.classList.add("hidden");
		cards3.classList.add("hidden");

	} else {
		bottone3.classList.add("selected");
		bottone2.classList.remove("selected");
		bottone1.classList.remove("selected");
		
		cards3.classList.remove("hidden");
		cards2.classList.add("hidden");
		cards1.classList.add("hidden");

	}
}

function buttonEvent() {

	bottone1.addEventListener("click", function () {
		buttonCheck(1);
	});

	bottone2.addEventListener("click", function () {
		buttonCheck(2);
	});
	bottone3.addEventListener("click", function () {
		buttonCheck(3);
	});
}

buttonEvent();
