import { createRootRoute, Link, Outlet } from "@tanstack/react-router";
import { TanStackRouterDevtools } from "@tanstack/react-router-devtools";
import NavBar from "../components/navbar";

export const Route = createRootRoute({
  component: () => (
    <>
      <NavBar />
      <Outlet />
      <TanStackRouterDevtools />
    </>
  ),
});
