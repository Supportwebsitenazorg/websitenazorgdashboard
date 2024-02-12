function initRemovableUsers() {
    document.querySelectorAll(".removable-user").forEach(function (element) {
        element.addEventListener("click", function () {
            const isDomain = this.getAttribute("data-domain") ? true : false;
            const url = isDomain
                ? "/remove-user-from-domain"
                : "/remove-user-from-organization";
            const data = {
                email: this.getAttribute("data-email"),
                domain: this.getAttribute("data-domain"),
                organization: this.getAttribute("data-organization"),
                _token: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            };

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        this.remove();
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    });
}

function showOrganizationDomains(selectElement) {
    const organizationId = selectElement.value;
    const domainsList = document.getElementById("domains_list");

    domainsList.innerHTML = "";

    if (organizationId) {
        fetch(`/api/organizations/${organizationId}/domains`)
            .then((response) => response.json())
            .then((data) => {
                if (data.length > 0) {
                    data.forEach((domain) => {
                        const li = document.createElement("li");
                        const a = document.createElement("a");
                        a.setAttribute("href", `/monitoring/${domain.domain}`);
                        a.textContent = domain.domain;
                        li.appendChild(a);
                        domainsList.appendChild(li);
                    });
                    document.getElementById(
                        "organization_domains"
                    ).style.display = "block";
                } else {
                    document.getElementById(
                        "organization_domains"
                    ).style.display = "none";
                }
            })
            .catch((error) => console.error("Error:", error));
    } else {
        document.getElementById("organization_domains").style.display = "none";
    }
}

export { initRemovableUsers, showOrganizationDomains };
