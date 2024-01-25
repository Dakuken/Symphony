const wordLength = 5;
const maxGuess = 6;
const word = "salut";
const messageWordle = document.querySelector("#messageWordle");
let motIncorrect = false;
let row = 0;
let col = 1;

let focus = [0, 0];

document.addEventListener("DOMContentLoaded", () => {
    createWord();
    window.addEventListener("resize", adjustWidthToHeight);
    window.addEventListener("keydown", (e) => {
        if (e.key === "Backspace") {
            removeLetter();
        } else if (/^[a-zA-Z]$/.test(e.key)) { // Vérifie si la touche est une lettre
            addLetter(e.key);
        }
    });
});


let letter = `<input type="text" maxlength="1" class="w-full bg-transparent text-center text-3xl font-bold uppercase text-white focus:outline-0" disabled value="">`;
let letterWrapper = `<div class="flex items-center justify-center rounded-md cases">${letter}</div>`;
let wordWrapper = `<div class="flex h-full w-full max-w-4xl justify-center gap-3 word"></div>`;

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

function adjustKeyboardWeigth() {

    let refTaille = document.querySelector("#refTaille");
    let taille = refTaille.offsetWidth;

    let keyboard = document.querySelectorAll(".keyboard");
    keyboard.forEach(keyboard => {
        keyboard.style.width = taille + "px";
        keyboard.style.height = (taille + 50) + "px";
        keyboard.style.maxHeight = 110 + "px";
        let letter = keyboard.querySelector("p").innerText;
        keyboard.addEventListener("click", () => {
            addLetter(letter);
        });
    });

    let wordd = document.querySelectorAll(".wordKeyboard");
    wordd.forEach(word => {
        word.style.height = (taille + 50) + "px";
        word.style.maxHeight = 120 + "px";
    });

    let erased = document.querySelector(".erased");
    erased.style.width = taille * 2 + "px";
    erased.style.height = (taille + 50) + "px";
    erased.style.maxHeight = 110 + "px";
    erased.addEventListener("click", removeLetter);

}

function addLetter(letter) {
    currentInput().value = letter;
    nextFocus();
}

function removeLetter() {
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
            console.log(res, "cest : ");
            if (res) {
                focus[col] = 0;
                focus[row] = focus[row] + 1;
            } else {
                wordFalse();
            }
        });
    }
    if (focus[row] >= maxGuess) {
        partieFinis();
    }
}

function partieFinis() {
    console.log("partie finis");

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
    console.log("verif word");

    let word = getWord();
    return fetchWord(word).then(res => {
        if (!res) {
            return false;
        } else {
            verifLetter(word);
            return true;
        }
    }).catch((error) => {
        return false;
    });
}

function verifLetter(guessword){
    let result = []

    // Convertir les mots en tableaux de lettres
    let guessLetters = guessword.split('');
    let solutionLetters = word.split('');

    // Marquer les lettres correctes
    for (let i = 0; i < guessLetters.length; i++) {
        if (guessLetters[i] === solutionLetters[i]) {
            result[i] = { letter: guessLetters[i], status: 'correct' };
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
                result[i] = { letter: guessLetters[i], status: 'present' };
                // Marquer cette lettre comme traitée
                solutionLetters[index] = null;
            } else {
                result[i] = { letter: guessLetters[i], status: 'absent' };
            }
        }
    }
    console.log("result");
    console.log(result);
    result.forEach()
    return result;
}

function wordFalse() {
    console.log("poeut");
    let cases = currentRow().querySelectorAll(".cases");
    cases.forEach(cases => {
        cases.classList.add("wrongWord");
    });
    messageWordle.textContent = "Mot incorrect !";
    motIncorrect = true;
}

function removeFalseWord() {
    console.log("poeut");
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

currentRow = () => document.querySelector(`#wrapper${focus[row]}`);
currentCol = (el) => el.querySelector(`#letterWrapper${focus[col]}`);
currentInput = () => document.querySelector(`#wrapper${focus[row]}`).querySelector(`#letterWrapper${focus[col]}`).querySelector("input");