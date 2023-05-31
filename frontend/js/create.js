import { get, post } from "./api.js";

const btnRef = document.getElementById('submit-btn');

// Form
const emailRef = document.getElementById('email');
const nameRef = document.getElementById('name');
const passwordRef = document.getElementById('password');
const birthRef = document.getElementById('birth');

btnRef.addEventListener('click', create);

function create(e) {
    e.preventDefault();

    get('http://localhost:8080/api.php')
    .then(data => { 
        console.log(data); 
    })
    .catch(e => {
        console.log(e);
    });
    return false;
}