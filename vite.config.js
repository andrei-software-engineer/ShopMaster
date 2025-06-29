import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/sass/app.scss",
        // "resources/sass/appAdmin.scss",

        "resources/css/appPrint.css",
        "resources/css/appBase.css",

        "resources/js/appAdmin.js",
        "resources/js/app.js",
      ],
      refresh: true,
    }),
  ],
  resolve: {
    alias: {
      "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
      "~images": path.resolve(__dirname, "resources/images"),
    },
  },
});
