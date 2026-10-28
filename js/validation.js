/*
 * Surgical Store - Common Validation Logic
 * Validation types:
 * required, email, strongPassword, min, max, confirmPassword,
 * terms, alpha, numeric, file, filesize, min-items, max-items
 */
(function () {
    "use strict";

    function getErrorId(field) {
        var name = field.getAttribute("name") || field.id || "field";
        return name.replace(/[^a-zA-Z0-9_-]/g, "-") + "Error";
    }

    function getErrorElement(field) {
        var id = getErrorId(field);
        var error = document.getElementById(id);

        if (!error) {
            error = document.createElement("small");
            error.id = id;
            error.className = "validation-error";
            field.parentNode.appendChild(error);
        }

        return error;
    }

    function showError(field, message) {
        var error = getErrorElement(field);
        error.textContent = message;
        error.style.display = "block";
        field.classList.add("is-invalid");
        field.classList.remove("is-valid");
        field.setAttribute("aria-invalid", "true");
    }

    function clearError(field) {
        var error = document.getElementById(getErrorId(field));

        if (error) {
            error.textContent = "";
            error.style.display = "none";
        }

        field.classList.remove("is-invalid");
        field.removeAttribute("aria-invalid");
    }

    function showValid(field) {
        if (field.value && field.getAttribute("type") !== "checkbox" && field.getAttribute("type") !== "file") {
            field.classList.add("is-valid");
        }
    }

    function valueOf(field) {
        if (field.type === "checkbox" || field.type === "radio") {
            return field.checked ? "checked" : "";
        }
        return (field.value || "").trim();
    }

    function hasRule(rules, rule) {
        return rules.split(/\s+/).indexOf(rule) !== -1;
    }

    function validateField(field, form) {
        if (field.disabled || field.type === "hidden") {
            return "";
        }

        var name = field.getAttribute("name") || "";
        var type = (field.getAttribute("type") || "").toLowerCase();
        var value = valueOf(field);
        var rules = (field.getAttribute("data-validation") || "").trim();
        var minLength = parseInt(field.getAttribute("data-min") || field.getAttribute("minlength") || "0", 10);
        var maxLength = parseInt(field.getAttribute("data-max") || field.getAttribute("maxlength") || "999999", 10);
        var errorMessage = "";

        if (!rules && field.required) {
            rules = "required";
        }

        if (!rules) {
            return "";
        }

        if (hasRule(rules, "required")) {
            if (type === "checkbox" && !field.checked) {
                errorMessage = "This field is required.";
            } else if (type !== "checkbox" && type !== "radio" && value === "") {
                errorMessage = "This field is required.";
            }
        }

        if (!errorMessage && value !== "" && hasRule(rules, "email")) {
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/;
            if (!emailPattern.test(value)) {
                errorMessage = "Please enter a valid email address.";
            }
        }

        if (!errorMessage && value !== "" && hasRule(rules, "strongPassword")) {
            var pwdRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,25}$/;
            if (!pwdRegex.test(value)) {
                errorMessage = "Password must be 8-25 characters with uppercase, lowercase, number and special character.";
            }
        }

        if (!errorMessage && hasRule(rules, "confirmPassword")) {
            var passwordId = field.getAttribute("data-password-id");
            var password = passwordId ? document.getElementById(passwordId) : form.querySelector('[name="password"]');
            if (password && value !== password.value.trim()) {
                errorMessage = "Passwords do not match.";
            }
        }

        if (!errorMessage && hasRule(rules, "terms") && !field.checked) {
            errorMessage = "You must agree to the Terms & Conditions.";
        }

        if (!errorMessage && value !== "" && hasRule(rules, "alpha") && !/^[A-Za-z\s.'-]+$/.test(value)) {
            errorMessage = "Only letters, spaces, apostrophe and hyphen are allowed.";
        }

        if (!errorMessage && value !== "" && hasRule(rules, "numeric") && !/^[0-9]+$/.test(value)) {
            errorMessage = "Only numbers are allowed.";
        }

        if (!errorMessage && value !== "" && hasRule(rules, "min") && value.length < minLength) {
            errorMessage = "Must be at least " + minLength + " characters.";
        }

        if (!errorMessage && value !== "" && hasRule(rules, "max") && value.length > maxLength) {
            errorMessage = "Must be no more than " + maxLength + " characters.";
        }

        if (!errorMessage && (hasRule(rules, "min-items") || hasRule(rules, "max-items")) && (type === "checkbox" || type === "radio")) {
            var groupName = field.getAttribute("name");
            var group = form.querySelectorAll('input[name="' + groupName + '"]:checked');
            var count = group.length;
            var minItems = parseInt(field.getAttribute("data-min-items") || "0", 10);
            var maxItems = parseInt(field.getAttribute("data-max-items") || "999999", 10);

            if (hasRule(rules, "min-items") && count < minItems) {
                errorMessage = "Please select at least " + minItems + " option(s).";
            } else if (hasRule(rules, "max-items") && count > maxItems) {
                errorMessage = "You can only select up to " + maxItems + " option(s).";
            }
        }

        if (!errorMessage && hasRule(rules, "file")) {
            if (!field.files || field.files.length === 0) {
                errorMessage = "Please upload a file.";
            } else {
                var file = field.files[0];
                var fileTypes = (field.getAttribute("data-filetypes") || "").toLowerCase().split(",").map(function (item) { return item.trim(); }).filter(Boolean);
                var fileSizeKB = file.size / 1024;
                var extension = file.name.split(".").pop().toLowerCase();
                var maxFileSize = parseInt(field.getAttribute("data-filesize") || "0", 10);

                if (fileTypes.length && fileTypes.indexOf(extension) === -1) {
                    errorMessage = "Invalid file type. Allowed: " + fileTypes.join(", ") + ".";
                } else if (hasRule(rules, "filesize") && maxFileSize > 0 && fileSizeKB > maxFileSize) {
                    errorMessage = "File size must be less than " + maxFileSize + " KB.";
                }
            }
        }

        if (!errorMessage && field.tagName.toLowerCase() === "select" && hasRule(rules, "required")) {
            if (value === "" || field.selectedIndex === 0) {
                errorMessage = "Please select an option.";
            }
        }

        if (!errorMessage && type === "number" && value !== "") {
            var number = Number(value);
            var min = field.getAttribute("min");
            var max = field.getAttribute("max");

            if (!Number.isFinite(number)) {
                errorMessage = "Please enter a valid number.";
            } else if (min !== null && number < Number(min)) {
                errorMessage = "Value cannot be less than " + min + ".";
            } else if (max !== null && number > Number(max)) {
                errorMessage = "Value cannot be greater than " + max + ".";
            } else if ((name === "quantity" || name === "delivery_charge") && !Number.isInteger(number)) {
                errorMessage = "Please enter a whole number.";
            }
        }

        if (!errorMessage && (name === "mobile" || name === "phone")) {
            if (value !== "" && !/^[6-9][0-9]{9}$/.test(value)) {
                errorMessage = "Enter a valid 10-digit mobile number.";
            }
        }

        if (!errorMessage && name === "pincode" && value !== "" && !/^[0-9]{6}$/.test(value)) {
            errorMessage = "Pincode must contain exactly 6 digits.";
        }

        if (!errorMessage && /^(first_name|last_name|full_name|name|city|store_name)$/.test(name) && value !== "") {
            if (!/^[A-Za-z][A-Za-z\s.'-]*$/.test(value)) {
                errorMessage = "Only letters, spaces, apostrophe and hyphen are allowed.";
            } else if (value.length < 2) {
                errorMessage = "Please enter at least 2 characters.";
            }
        }

        if (!errorMessage && name === "address" && value !== "" && value.length < 10) {
            errorMessage = "Please enter a complete address.";
        }

        if (!errorMessage && (name === "message" || name === "review") && value !== "" && value.length < 10) {
            errorMessage = "Please enter at least 10 characters.";
        }

        if (!errorMessage && name === "coupon" && value !== "" && !/^[A-Za-z0-9_-]{4,20}$/.test(value)) {
            errorMessage = "Coupon code must be 4-20 letters or numbers.";
        }

        if (!errorMessage && field.hasAttribute("minlength") && value.length < Number(field.getAttribute("minlength"))) {
            errorMessage = "Please enter at least " + field.getAttribute("minlength") + " characters.";
        }

        if (!errorMessage && field.hasAttribute("maxlength") && value.length > Number(field.getAttribute("maxlength"))) {
            errorMessage = "Please enter no more than " + field.getAttribute("maxlength") + " characters.";
        }

        return errorMessage;
    }

    function validateFieldAndDisplay(field, form) {
        clearError(field);
        var message = validateField(field, form);
        if (message) {
            showError(field, message);
            return false;
        }
        showValid(field);
        return true;
    }

    function validateForm(form) {
        var isValid = true;
        var firstInvalid = null;
        var fields = form.querySelectorAll("input, textarea, select");

        fields.forEach(function (field) {
            if (!validateFieldAndDisplay(field, form)) {
                isValid = false;
                if (!firstInvalid) firstInvalid = field;
            }
        });

        if (firstInvalid) {
            firstInvalid.focus();
            firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
        }

        return isValid;
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("form[data-validate]").forEach(function (form) {
            form.querySelectorAll("input, textarea, select").forEach(function (field) {
                field.addEventListener("input", function () {
                    validateFieldAndDisplay(field, form);
                });
                field.addEventListener("change", function () {
                    validateFieldAndDisplay(field, form);
                });
                field.addEventListener("blur", function () {
                    validateFieldAndDisplay(field, form);
                });
            });

            form.addEventListener("submit", function (event) {
                if (!validateForm(form)) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });

            form.addEventListener("reset", function () {
                setTimeout(function () {
                    form.querySelectorAll("input, textarea, select").forEach(function (field) {
                        clearError(field);
                    });
                }, 0);
            });
        });

        var demoOrderButton = document.getElementById("demoOrderButton");
        if (demoOrderButton) {
            demoOrderButton.addEventListener("click", function (event) {
                var checkoutForm = demoOrderButton.closest("form");
                if (checkoutForm && !validateForm(checkoutForm)) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    return false;
                }
            }, true);
        }
    });
})();
