import "./bootstrap";
import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);
import { Axios } from "axios";

//tom tom imports
import TomTom from "@tomtom-international/web-sdk-maps";
import { services } from "@tomtom-international/web-sdk-services";
import SearchBox from "@tomtom-international/web-sdk-plugin-searchbox";
import "@tomtom-international/web-sdk-plugin-searchbox/dist/SearchBox.css";

// delete modal
let deleteBtn = document.querySelectorAll(".delete-btn");

deleteBtn.forEach((btn) => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        let apartmentTitle = this.getAttribute("data-title");

        let modalDeleteTitle = document.querySelectorAll(".apartment-title");

        modalDeleteTitle.forEach((element) => {
            element.innerHTML = apartmentTitle;
        });
        let deleteForm = this.closest("form");

        let confirmBtn = document.getElementById("confirm-delete");
        confirmBtn.addEventListener("click", () => {
            deleteForm.submit();
        });
    });
});

//tom tom api code
const successCallback = (position) => {
    // set device coordinate
    let center = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
    };
    console.log(
        "Latitudine: ",
        position.coords.latitude + " Longitudine: ",
        position.coords.longitude
    );
    console.log(center); 

    // init map
    let map = tt.map({
        key: "HAMFczyVGd30ClZCfYGP9To9Y18u6eq7",
        container: "map",
        center: center,
        zoom: 10,
    });

    // event listner to map elements

    // set options to tomtom searchbox
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

    let markersIcons = [];

    // searchbox init
    const ttSearchBox = new SearchBox(services, options);

    // event listener to searchbox
    ttSearchBox.on("tomtom.searchbox.resultselected", (e) => {
        console.log("Risultato selezionato:", e.data.result);
        map.flyTo({ center: e.data.result.position });
        // Rimuovere i marker precedenti dalla mappa
        for (let i = 0; i < markersIcons.length; i++) {
            markersIcons[i].remove();
        }
        // Svuotare l'array markersIcons e markers
        markersIcons = [];
        let startPosition = new tt.Marker()
            .setLngLat(e.data.result.position)
            .addTo(map);
        markersIcons.push(startPosition);
        ttSearchBox.on("tomtom.searchbox.resultscleared", (e) => {
            // Rimuovere i marker precedenti dalla mappa
            for (let i = 0; i < markersIcons.length; i++) {
                markersIcons[i].remove();
            }
            // Svuotare l'array markersIcons e markers
            markersIcons = [];
            // else set params
        });
        let selectedResult = e.data.result;
        let selectedLocation = selectedResult.position;
        let selectedAddress = selectedResult.address;
        console.log("Posizione selezionata:", selectedLocation.lat);
        console.log("Indirizzo selezionato:", selectedAddress.streetNumber);

        // remove d-none on address card
        let addressCard = document.getElementById("address-container");
        addressCard.classList.remove("d-none");

        // init position search infos
        let countryCode = (document.getElementById("country_code").value =
            selectedAddress.countryCode || "");
        let city = (document.getElementById("city").value =
            selectedAddress.municipality || "");
        let streetName = (document.getElementById("street_name").value =
            selectedAddress.streetName || "");
        let streetNumber = (document.getElementById("street_number").value =
            selectedAddress.streetNumber || "");
        let postalCode = (document.getElementById("postal_code").value =
            selectedAddress.postalCode || "");
        let region = selectedAddress.countrySubdivision || "";
        let country = selectedAddress.country || "";
        document.getElementById(
            "address"
        ).innerHTML = `<strong>Street name: </strong>${
            streetName
                ? streetName + "<br>"
                : '<span class="text-danger my-1 py-1 px-2 border border-1 border-danger rounded">missing street name</span><br>'
        }<strong>Street number: </strong>${
            streetNumber
                ? streetNumber + "<br>"
                : '<span class="text-danger my-1 py-1 px-2 border border-1 border-danger rounded">missing street number</span><br>'
        }<strong>Postal code: </strong>${
            postalCode
                ? postalCode + "<br>"
                : '<span class="text-danger my-1 py-1 px-2 border border-1 border-danger rounded">missing postal code</span><br>'
        }<strong>City: </strong>${city + "<br>"}<strong>Region: </strong>${
            region + "<br>"
        }<strong>Country: </strong>${country + "<br>"} `;
    });
    map.addControl(ttSearchBox, "top-left");
};
const errorCallback = (error) => {
    console.log(error);
};

navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

// previewImage

const previewImgContainer = document.querySelector(".images-container");
const imageInput = document.getElementById("image_path");

if (imageInput) {
    imageInput.addEventListener("change", function () {
        const files = this.files;

        for (let i = 0; i < files.length; i++) {
            const selectedFile = files[i];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                const imgContainer = document.createElement("div");
                imgContainer.classList.add("image-container", "col-5", "my-2");

                const imgElement = document.createElement("img");
                imgElement.src = reader.result;
                imgElement.classList.add("rounded", "ms_img-preview");
                imgContainer.classList.add(
                    "ms_img-preview-container",
                    "col-12",
                    "my-4"
                    /* "col-md-6",
                    "col-lg-4" */
                );

                const fileSize = document.createElement("span");
                fileSize.classList.add("ms_size-img");
                const fileSizeinKb = selectedFile.size / 1024;
                const fileSizeinMb = fileSizeinKb / 1024;
                if (fileSizeinKb < 1024) {
                    fileSize.textContent = fileSizeinKb.toFixed(2) + " Kb";
                } else {
                    fileSize.textContent = fileSizeinMb.toFixed(2) + " Mb";
                }

                const deleteButton = document.createElement("button");
                deleteButton.textContent = "X";
                deleteButton.classList.add(
                    "btn",
                    "btn-light",
                    "btn-sm",
                    "ms-2",
                    "ms_btn-delete-preview",
                    "m-0",
                    "p-0"
                );
                deleteButton.addEventListener("click", function () {
                    imgContainer.remove();
                });

                imgContainer.appendChild(imgElement);
                /* imgContainer.appendChild(deleteButton); */
                imgContainer.appendChild(fileSize);
                previewImgContainer.appendChild(imgContainer);
            });

            reader.readAsDataURL(selectedFile);
        }
    });
}

//popver

let imageControllerContainer = document.querySelectorAll(
    ".image-controller-container"
);
let popovers = document.querySelectorAll(".popover");

popovers.forEach((popover) => {
    popover.addEventListener("click", function () {
        let popOverContent = this.querySelector(".popover-content");
        popOverContent.classList.toggle("d-none");
    });
});

imageControllerContainer.forEach((element) => {
    element.addEventListener("mouseleave", function () {
        let popOverContent = this.querySelector(".popover-content");
        popOverContent.classList.add("d-none");
    });
});


// handling hamburger button

const hamburger = document.getElementById('hamburger');

hamburger.addEventListener('click', (e) => {
    const header = document.querySelector('.ms_office-header');
    header.classList.toggle('ms_hamburger');
})
