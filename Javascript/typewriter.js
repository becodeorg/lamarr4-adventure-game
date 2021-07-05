
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
    let amount = health*5;
    document.getElementsByClassName('health')[0].style.width = amount+"%";
    document.getElementsByClassName('health')[0].innerText = health;
}

updateHealth(health);// todo help!