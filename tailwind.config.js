/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./modules/**/*.{html,js,php}", "./public/**/*.{html,js,php}", "./includes/**/*.{html,js,php}"],
    theme: {
        extend: {},
    },
    safelist: ["alert-error", "alert-info", "alert-warning.svg", "alert-success"],
    plugins: [require("daisyui")],
};
