import { createFileRoute } from "@tanstack/react-router";
import NavBar from "../components/navbar";
import { Button } from "primereact/button";

export const Route = createFileRoute("/")({
  component: Index,
});

function Index() {
  return (
    <div className="p-2">
      <h3>
        <Button>asdasd</Button>
      </h3>
    </div>
  );
}
