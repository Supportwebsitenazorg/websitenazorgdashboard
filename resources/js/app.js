import "./bootstrap";
import "../sass/app.scss";

// Import the functions from domainManagement.js
import {
    initRemovableUsers,
    showOrganizationDomains,
} from "./domainManagement";

document.addEventListener("DOMContentLoaded", function () {
    initRemovableUsers();

    // Assuming there's a specific event or condition under which showOrganizationDomains should be called.
    // Since showOrganizationDomains seems to be designed for handling select element changes,
    // you might not need to call it directly on DOMContentLoaded unless you're initializing a specific state.

    // If you have select elements that need to initialize with this function, make sure they exist and are correctly targeted.
    // For example, if you have a select element for organizations and you want to attach showOrganizationDomains to its 'change' event:
    const organizationSelects = document.querySelectorAll(
        ".organization-select"
    );
    organizationSelects.forEach((select) => {
        select.addEventListener("change", function () {
            showOrganizationDomains(this); // Ensure this function is designed to handle being called like this.
        });
    });
});

// Note: There's no call to initDomainManagement() as it wasn't defined or necessary based on your provided code.
// Make sure that any function you call is defined and imported if it's coming from another file.
