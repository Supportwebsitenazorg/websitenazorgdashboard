import "./bootstrap";
import "../sass/app.scss";

import {
    initRemovableUsers,
    showOrganizationDomains,
    initClickableRemovalEmails,
} from "./functionsManagement";

document.addEventListener("DOMContentLoaded", function () {
    initRemovableUsers();
    initClickableRemovalEmails();

    const organizationSelects = document.querySelectorAll(
        ".organization-select"
    );
    organizationSelects.forEach((select) => {
        select.addEventListener("change", function () {
            showOrganizationDomains(this);
        });
    });
});
