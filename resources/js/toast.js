import Toastify from "toastify-js";

(function (cash) {
    "use strict";

    // Basic Toast
    cash("#basic-non-sticky-toast").on("click", function () {
        Toastify({
            text:
                "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, consequuntur doloremque eveniet eius eaque dicta repudiandae illo ullam. Minima itaque sint magnam dolorum asperiores repudiandae dignissimos expedita, voluptatum vitae velit.",
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "left",
            backgroundColor: "#0e2c88",
            stopOnFocus: true,
        }).showToast();
    });
    cash("#basic-sticky-toast").on("click", function () {
        Toastify({
            text:
                "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, consequuntur doloremque eveniet eius eaque dicta repudiandae illo ullam. Minima itaque sint magnam dolorum asperiores repudiandae dignissimos expedita, voluptatum vitae velit.",
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "left",
            backgroundColor: "#0e2c88",
            stopOnFocus: true,
        }).showToast();
    });

    // HTML Toast
    cash("#html-non-sticky-toast").on("click", function () {
        Toastify({
            node: cash(
                '<span>Let\'s test some HTML stuff... <a class="font-medium" href="#">Github</a></span>'
            )[0],
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "left",
            backgroundColor: "#0e2c88",
            stopOnFocus: true,
        }).showToast();
    });
    cash("#html-sticky-toast").on("click", function () {
        Toastify({
            node: cash(
                '<span><strong>Remember!</strong> You can <span class="font-medium">always</span> introduce your own × HTML and <span class="font-medium">CSS</span> in the toast.<span>'
            )[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "left",
            backgroundColor: "#0e2c88",
            stopOnFocus: true,
        }).showToast();
    });
})(cash);


// Customize toast for CRUD submission
window.showSubmitToast = (function () {
    // This function will be immediately invoked and returned
    return function (message, color) {
        // Use Toastify with the provided arguments
        Toastify({
            text: message,
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "center",
            style: {
                background: color, // Use the provided color
            },
            stopOnFocus: true,
        }).showToast();
    };
})();