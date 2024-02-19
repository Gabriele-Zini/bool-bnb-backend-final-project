import "./bootstrap";

import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);

let deleteBtn = document.querySelectorAll(".delete-btn");

deleteBtn.forEach(btn=>{
    btn.addEventListener('click', function(e) {
       e.preventDefault();

       let apartmentTitle = this.getAttribute("data-title");
     /*   console.log(apartmentTitle); */

       let modalDeleteTitle = document.querySelectorAll(".apartment-title");

       modalDeleteTitle.forEach((element) => {
           element.innerHTML = apartmentTitle;
       });
       let deleteForm=this.closest('form')

       let confirmBtn=document.getElementById('confirm-delete')
       confirmBtn.addEventListener('click', ()=>{
        deleteForm.submit();
       })
    })
})
