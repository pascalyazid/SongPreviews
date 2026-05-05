document.addEventListener("DOMContentLoaded", function () {
    const loadBtn = document.getElementById("load");

    window.addEventListener("scroll", function () {
        if (
            window.innerHeight + window.scrollY >=
            document.body.offsetHeight - 50
        ) {
            if (
                document
                    .getElementById("results-container")
                    .innerHTML.trim() !== ""
            ) {
                loadBtn.style.display = "block";
            }
        } else {
            loadBtn.style.display = "none";
        }
    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
});

function loadNext() {
    const loadBtn = document.getElementById("load");
    loadBtn.style.display = "none";

    fetch("index.php?ajax=true")
        .then((response) => response.text())
        .then((data) => {
            document
                .getElementById("results-container")
                .insertAdjacentHTML("beforeend", data);
        })
        .catch((error) => console.error("Error loading next:", error));
}

let currentButton = null;

function setSRC(url, button) {
    let audio = document.getElementById("audio");
    audio.volume = 0.3;

    if (button.innerHTML === "Play") {
        // If another song is playing, reset its button
        if (currentButton && currentButton !== button) {
            currentButton.innerHTML = "Play";
            currentButton.classList.remove("btn-danger");
            currentButton.classList.add("btn-primary");
        }

        if (audio.src !== url) {
            audio.src = url;
        }

        audio.play();
        button.innerHTML = "Pause";
        button.classList.remove("btn-primary");
        button.classList.add("btn-danger");

        currentButton = button;
    } else {
        audio.pause();
        button.innerHTML = "Play";
        button.classList.remove("btn-danger");
        button.classList.add("btn-primary");
        currentButton = null;
    }

    // Handle audio ending
    audio.onended = function () {
        button.innerHTML = "Play";
        button.classList.remove("btn-danger");
        button.classList.add("btn-primary");
        currentButton = null;
    };
}
