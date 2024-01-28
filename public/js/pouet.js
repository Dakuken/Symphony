let wordLength = 0;
let maxGuess = 0;
let word = "0";
const messageWordle = document.querySelector("#messageWordle");
let motIncorrect = false;
let row = 0;
let col = 1;
let isPartieFinis = false;
let isWin = false;

let focus = [0, 0];

document.addEventListener("DOMContentLoaded", () => {
    fetchGameInfo().then(res => {
        wordLength = res.solution.length
        maxGuess = res.maxTries
        word = res.solution
        createWord();
        listenerKeyBoard();
        window.addEventListener("resize", adjustWidthToHeight);
        window.addEventListener("keydown", (e) => {
            if (e.key === "Backspace") {
                removeLetter();
            } else if (/^[a-zA-Z]$/.test(e.key)) { // Vérifie si la touche est une lettre
                addLetter(e.key);
            }
        });
    });
});


let letter = `<input type="text" maxlength="1" class="w-full bg-transparent text-center text-3xl font-bold uppercase text-white focus:outline-0" disabled value="">`;
let letterWrapper = `<div class="flex items-center justify-center rounded-md cases">${letter}</div>`;
let wordWrapper = `<div class="flex h-full  w-full max-w-4xl justify-center gap-3 word"></div>`;

let letterNode = new DOMParser().parseFromString(letter, "text/html").body.firstChild;
let letterWrapperNode = new DOMParser().parseFromString(letterWrapper, "text/html").body.firstChild;
let wordWrapperNode = new DOMParser().parseFromString(wordWrapper, "text/html").body.firstChild;

function createWord() {
    let guessPlace = document.querySelector("#guessPlace");
    for (let i = 0; i < maxGuess; i++) {
        let wordWrapperName = "wrapper" + i;
        let wordWrapperClone = wordWrapperNode.cloneNode(true); // Clone le node pour éviter de réutiliser le même node
        wordWrapperClone.setAttribute("id", wordWrapperName);
        for (let j = 0; j < wordLength; j++) {
            let letterWrapperName = "letterWrapper" + j;
            let letterWrapperClone = letterWrapperNode.cloneNode(true); // Clone le node
            letterWrapperClone.setAttribute("id", letterWrapperName);
            wordWrapperClone.appendChild(letterWrapperClone); // Ajoute le clone à wordWrapper
        }
        guessPlace.appendChild(wordWrapperClone); // Ajoute wordWrapper à guessPlace
    }
    adjustWidthToHeight();
}

const adjustWidthToHeight = () => {
    const cases = document.querySelectorAll(".cases");
    cases.forEach(caseElement => {
        const height = caseElement.offsetHeight;
        caseElement.style.width = `${height}px`; // Ajuste la largeur pour être égale à la hauteur
    });
    adjustKeyboardWeigth();
};

function listenerKeyBoard() {
    let keyboard = document.querySelectorAll(".keyboard");
    keyboard.forEach(keyboard => {
        keyboard.addEventListener("click", () => {
            let letter = keyboard.querySelector("p").innerText;
            addLetter(letter);
        });
    });
    let erased = document.querySelector(".erased");
    erased.addEventListener("click", removeLetter);
}

function adjustKeyboardWeigth() {

    let refTaille = document.querySelector("#refTaille");
    let taille = refTaille.offsetWidth;

    let keyboard = document.querySelectorAll(".keyboard");
    let keyboardArray = Array.from(keyboard);
    keyboardArray = keyboardArray.filter((element) => element.id !== "#refTaille");

    keyboardArray.forEach(keyboard => {
        keyboard.style.width = taille + "px";
        keyboard.style.height = (taille + 30) + "px";
        keyboard.style.maxHeight = 110 + "px";
    });

    let wordd = document.querySelectorAll(".wordKeyboard");
    wordd.forEach(word => {
        word.style.height = (taille + 50) + "px";
        word.style.maxHeight = 120 + "px";
    });

    let erased = document.querySelector(".erased");
    erased.style.width = taille * 2 + "px";
    erased.style.height = (taille + 30) + "px";
    erased.style.maxHeight = 110 + "px";
    erased.addEventListener("click", removeLetter);
}

function addLetter(letter) {
    if (isPartieFinis) {
        return;
    }
    currentInput().value = letter;
    nextFocus();
}

function removeLetter() {
    if (isPartieFinis) {
        return;
    }
    previousFocus();
    if (motIncorrect) {
        removeFalseWord();
    }
    currentInput().value = "";
}

function nextFocus() {
    focus[col] = focus[col] + 1;

    if (focus[col] >= wordLength) {
        verifWord().then(res => {
            if (res) {
                focus[col] = 0;
                focus[row] = focus[row] + 1;
                verifPartieFinis();
            } else {
                wordFalse();
            }
            if (isPartieFinis) {
                partieFinis();
            }
        });
    }

}

function verifPartieFinis() {
    if (focus[row] >= maxGuess) {
        partieFinis();
    }
}

function partieFinis() {
    if (isWin) {
        messageWordle.textContent = "Vous avez gagné !";
    } else {
        messageWordle.innerHTML = `Vous avez perdu... <br> Le mot était : ${word} `;
    }
    motIncorrect = true;
}

function getWord() {
    let word = "";
    for (let i = 0; i < wordLength; i++) {
        let currentInput = currentRow().querySelector(`#letterWrapper${i}`).querySelector("input");
        word += currentInput.value;
    }
    return word;
}

function verifWord() {

    let word = getWord();
    return fetchWord(word).then(res => {
        if (!res) {
            return false;
        } else {
            verifLetter(word);
            return true;
        }
    });
}

function verifLetter(guessword) {
    let result = [];

    // Convertir les mots en tableaux de lettres
    let guessLetters = guessword.split("");
    let solutionLetters = word.split("");

    // Marquer les lettres correctes
    for (let i = 0; i < guessLetters.length; i++) {
        if (guessLetters[i] === solutionLetters[i]) {
            result[i] = {letter: guessLetters[i], status: "correct"};
            // Marquer cette lettre comme traitée
            solutionLetters[i] = null;
        }
    }

    // Vérifier les lettres présentes
    for (let i = 0; i < guessLetters.length; i++) {
        // Si la lettre n'a pas déjà été marquée comme correcte
        if (!result[i]) {
            let index = solutionLetters.indexOf(guessLetters[i]);
            if (index > -1) {
                result[i] = {letter: guessLetters[i], status: "present"};
                // Marquer cette lettre comme traitée
                solutionLetters[index] = null;
            } else {
                result[i] = {letter: guessLetters[i], status: "absent"};
            }
        }
    }
    result.forEach((letter, index) => {
        let input = currentRow().querySelector(`#letterWrapper${index}`);
        input.classList.add(letter.status);
    });
    const isAllCorrect = result.every(item => item.status === "correct");
    if (isAllCorrect) {
        isPartieFinis = true;
        isWin = true;
    }
    return result;
}

function wordFalse() {
    let cases = currentRow().querySelectorAll(".cases");
    cases.forEach(cases => {
        cases.classList.add("wrongWord");
    });
    messageWordle.textContent = "Mot incorrect !";
    motIncorrect = true;
}

function removeFalseWord() {
    let cases = currentRow().querySelectorAll(".cases");
    cases.forEach(cases => {
        cases.classList.remove("wrongWord");
    });
    messageWordle.textContent = "";
    motIncorrect = false;
}

function previousFocus() {
    focus[col] = focus[col] - 1;
    if (focus[col] < 0) {
        focus[col] = 0;
    }
}

function fetchWord(word) {
    return fetch(`/loldle/symphony/public/api/word/${word}`)
        .then(response => {
            if (response.status === 404) {
                return false;
            } else {
                return true;
            }
        })
        .catch(error => {
            console.error("Error fetching word:", error);
            return false;
        });
}

async function fetchGameInfo() {
    const url = new URL(window.location.href);
    const pathSegments = url.href.split("id="); // Divise l'URL en segments
    const id = pathSegments[pathSegments.length - 1];
    try {
        const response = await fetch(`/loldle/symphony/public/api/wordle/${id}`);
        if (!response.ok) {
            throw new Error('Erreur réseau: ' + response.statusText);
        }

        const data = await response.json(); // Traite la réponse JSON
        console.log(data); // Affiche les données JSON
        return data;
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
    }
}


currentRow = () => document.querySelector(`#wrapper${focus[row]}`);
currentCol = (el) => el.querySelector(`#letterWrapper${focus[col]}`);
currentInput = () => document.querySelector(`#wrapper${focus[row]}`).querySelector(`#letterWrapper${focus[col]}`).querySelector("input");