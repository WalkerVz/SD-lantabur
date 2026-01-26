/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/css/**/*.css",
    ],
    theme: {
        extend: {
            colors: {
                green: {
                    50: "#f6f7f5",
                    100: "#e7eae5",
                    200: "#cfd7c7",
                    300: "#b1c1a2",
                    400: "#8ca36e",
                    500: "#6e8b4b",
                    600: "#5b753e",
                    700: "#47663D",
                    800: "#3a5232",
                    900: "#2e4127",
                },
            },
        },
    },
    plugins: [],
};
