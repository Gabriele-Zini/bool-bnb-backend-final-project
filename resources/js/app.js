import "./bootstrap";

import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);
//tom tom imports
import TomTom from '@tomtom-international/web-sdk-maps';
import { services } from '@tomtom-international/web-sdk-services';
import SearchBox from '@tomtom-international/web-sdk-plugin-searchbox';
import '@tomtom-international/web-sdk-plugin-searchbox/dist/SearchBox.css'

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

let city = document.getElementById('city');
let streetName = document.getElementById('street_name');
let streetNumber = document.getElementById('street_number');
let postalCode = document.getElementById('postal_code');
//tom tom code
const successCallback = (position) => {
    let center = { lat: position.coords.latitude, lng: position.coords.longitude };
    console.log("Latitudine: ", position.coords.latitude + " Longitudine: ", position.coords.longitude);
    console.log(center);

    let map = tt.map({
        key: 'HAMFczyVGd30ClZCfYGP9To9Y18u6eq7',
        container: 'map',
        center: center,
        zoom: 10,
    });

    map.on('load', () => {
        let element = document.createElement("div");
        element.id = "marker";
        element.innerHTML = "125$";
        new tt.Marker({ element: element }).setLngLat(center).addTo(map);
    });

    let options = {
        searchOptions: {
            key: "HAMFczyVGd30ClZCfYGP9To9Y18u6eq7",
            language: "en-GB",
            limit: 5,
            zoom: 10,
        },
        autocompleteOptions: {
            key: "HAMFczyVGd30ClZCfYGP9To9Y18u6eq7",
            language: "en-GB",
        },
    };

    const ttSearchBox = new SearchBox(services, options);

    ttSearchBox.on('tomtom.searchbox.resultselected', (e) => {
        console.log("Risultato selezionato:", e.data.result);
        map.flyTo({ center: e.data.result.position });

        let selectedResult = e.data.result;
        let selectedLocation = selectedResult.position;
        let selectedAddress = selectedResult.address;
        console.log("Posizione selezionata:", selectedLocation.lat);
        console.log("Indirizzo selezionato:", selectedAddress.streetNumber);
        let countryCode = document.getElementById('country').value = selectedAddress.countryCode || '';
        let city = document.getElementById('city').value = selectedAddress.municipality || '';
        let streetName = document.getElementById('street_name').value = selectedAddress.streetName || '';
        let streetNumber = document.getElementById('street_number').value = selectedAddress.streetNumber || '';
        let postalCode = document.getElementById('postal_code').value = selectedAddress.postalCode || '';
        let region = selectedAddress.countrySubdivision || '';
        let country = selectedAddress.country || '';
        document.getElementById('address').innerHTML = `${streetName}, ${streetNumber}, ${postalCode}, ${city}, ${region}, ${country} ` 
    });
    map.addControl(ttSearchBox, 'top-left');
};
const errorCallback = (error) => {
    console.log(error);
};

navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
