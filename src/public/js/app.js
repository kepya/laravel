const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

// *********************************************************
const background = document.querySelector('.top');
// background.classList.add('blueTheme');
const theme = document.querySelectorAll('.theme'); // ici je prend tout les elements qui ont la classe theme

// ici item represente chacun de mes elements de theme
theme.forEach( (item ) => {
    item.addEventListener('click', (event) => {
        console.log(event.target.id); //event.target.id me permet de recuperer chaque id de mes elements
        switch (event.target.id) {
            case "blue":
                background.classList.add('blueTheme');
                background.classList.remove('greenTheme');
                background.classList.remove('tealTheme');
                break;
            case "green":
                background.classList.remove('blueTheme');
                background.classList.remove('tealTheme');
                background.classList.add('greenTheme');
                break;
            case "teal":
                background.classList.remove('greenTheme');
                background.classList.remove('blueTheme');
                background.classList.add('tealTheme');
                break;
            default:
                null;
                break;
        }
    });
});
