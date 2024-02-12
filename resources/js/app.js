import "./bootstrap";

import "../sass/app.scss";

import {
    initRemovableUsers,
    showOrganizationDomains,
} from "./domainManagement";

document.addEventListener("DOMContentLoaded", function () {
    initRemovableUsers();
});

initDomainManagement();
window.showOrganizationDomains = showOrganizationDomains;
