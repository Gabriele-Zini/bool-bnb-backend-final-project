import "./bootstrap";

import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);

let deleteBtn = document.querySelectorAll(".delete-btn");

deleteBtn.forEach(btn=>{
    btn.addEventListener('click', function() {
        console.log('ciccio')
    })
})
