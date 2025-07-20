import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import GlobalProvider from "./provider.tsx";
import { RouterProvider, createRouter } from "@tanstack/react-router";
import "./global.css";

// Import the generated route tree
import { routeTree } from "./routeTree.gen";

// Create a new router instance
const router = createRouter({ routeTree });

// Register the router instance for type safety
declare module "@tanstack/react-router" {
  interface Register {
    router: typeof router;
  }
}

createRoot(document.getElementById("root")!).render(
  <StrictMode>
    <GlobalProvider>
      <RouterProvider router={router} />
    </GlobalProvider>
  </StrictMode>,
);
