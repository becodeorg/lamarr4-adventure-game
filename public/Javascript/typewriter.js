
let number = 0;

function typeWriter(message) {
    for (let i = 0; i < message.length; i++) {
        let random = Math.floor(Math.random() * 100);
        number += random;
        setTimeout(function () {
            document.getElementById('message').innerHTML += message[i];
        }, number);
    }
}

typeWriter(message);



function updateHealth(health){
    let amount = health*10;
    document.getElementsByClassName('playerHealth')[0].style.background = `linear-gradient(to right, green ${amount}%, darkred ${amount}%)`;
    document.getElementsByClassName('playerHealth')[0].innerText = health;
}

updateHealth(health);// todo help!
