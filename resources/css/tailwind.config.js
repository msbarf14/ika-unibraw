import preset from "./../../vendor/filament/support/tailwind.config.preset";

const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        // "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./app/Livewire/**/*.php",
        "./resources/views/components/**/*.blade.php",
        "./resources/views/livewire/**/*.blade.php",
        // "./vendor/wire-elements/modal/resources/views/*.blade.php",
        // "./vendor/wire-elements/modal/src/ModalComponent.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["DM Sans", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                "2xs": "0.65rem",
            },
            colors: {
                brand: {
                    primary: "#023365",
                    secondary: "#0788BF",
                    dark: "#18181b",
                    blue: "#205BA8",
                    orange: "#F15829",
                    yellow: "#F9D734",
                    green: "#459B2E",
                },
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("daisyui"),
    ],
    daisyui: {
        themes: ["light"],
    },
};
